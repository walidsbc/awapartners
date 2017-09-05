<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\Application;
use SBC\AWAPartnersBundle\Entity\ApplicationMail;
use SBC\AWAPartnersBundle\Form\ApplicationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApplicationController
 * @package SBC\AWAPartnersBundle\Controller
 */
class ApplicationController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('AWAPartnersBundle:Application')->findAll();

        return $this->render('@AWAPartners/Application/index.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * @param Request $request
     * @return Request|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            $this->sendMail($application, $request);

        }

        return $this->render('@AWAPartners/Application/new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Application $application
     * @param Request $request
     * @return Response
     */
    public function sendMail(Application $application, Request $request)
    {
        $listmail = array();
        $emails = $this->getDoctrine()->getRepository('AWAPartnersBundle:ApplicationMail')->findAll();
        foreach ($emails as $email) {
            array_push($listmail, $email->getMailAddress());
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Candidature: ' . $request->request->get('title'))
            ->setFrom($application->getEmail())
            ->setTo($listmail)
            ->setBody($application->getNote(),
                'text/html'
            );

        if ($this->get('mailer')->send($message)) {
            return new Response(
                'true'
            );
        } else {
            return new Response(
                'false'
            );
        }

    }

    /**
     * @param Application $application
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function showAction(Application $application)
    {
        return $this->render('@AWAPartners/Application/show.html.twig', array(
            'application' => $application
        ));
    }

}
