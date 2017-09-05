<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\ApplicationMail;
use SBC\AWAPartnersBundle\Form\ApplicationMailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApplicationMailController
 * @package SBC\AWAPartnersBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ApplicationMailController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applicationMails = $em->getRepository('AWAPartnersBundle:ApplicationMail')->findAll();

        return $this->render('@AWAPartners/ApplicationMail/index.html.twig', array(
            'applicationMails' => $applicationMails,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $applicationMail = new ApplicationMail();
        $form = $this->createForm(ApplicationMailType::class, $applicationMail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($applicationMail);
            $em->flush();

            return $this->redirectToRoute('applicationmail_index');
        }

        return $this->render('@AWAPartners/ApplicationMail/new.html.twig', array(
            'applicationMail' => $applicationMail,
            'form' => $form->createView(),
        ));
    }


    /**
     * @param Request $request
     * @param ApplicationMail $applicationMail
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, ApplicationMail $applicationMail)
    {

        $editForm = $this->createForm(ApplicationMailType::class, $applicationMail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('applicationmail_index' );
        }

        return $this->render('@AWAPartners/ApplicationMail/edit.html.twig', array(
            'applicationMail' => $applicationMail,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param ApplicationMail $applicationMail
     * @return JsonResponse
     */
    public function deleteAction(ApplicationMail $applicationMail)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;
        try {
            $em->remove($applicationMail);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return new JsonResponse(array('deleted' => $deleted));
    }


    /**
     * @param $mail
     * @return JsonResponse
     */
    public function findByMailAction($mail)
    {
        $applicationMail = $this->getDoctrine()
            ->getManager()
            ->getRepository('AWAPartnersBundle:ApplicationMail')
            ->findOneBy(array('mailAddress' => $mail));

        $exists = true;

        if ($applicationMail === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }

}
