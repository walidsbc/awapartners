<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\ContactMail;
use SBC\AWAPartnersBundle\Form\ContactMailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactMailController
 * @package SBC\AWAPartnersBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ContactMailController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contactMails = $em->getRepository('AWAPartnersBundle:ContactMail')->findAll();

        return $this->render('@AWAPartners/ContactMail/index.html.twig', array(
            'contactMails' => $contactMails,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $contactMail = new ContactMail();
        $form = $this->createForm(ContactMailType::class, $contactMail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactMail);
            $em->flush();

            return $this->redirectToRoute('contactmail_index');
        }

        return $this->render('@AWAPartners/ContactMail/new.html.twig', array(
            'contactMail' => $contactMail,
            'form' => $form->createView(),
        ));
    }


    /**
     * @param Request $request
     * @param ContactMail $contactMail
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, ContactMail $contactMail)
    {

        $editForm = $this->createForm(ContactMailType::class, $contactMail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contactmail_index' );
        }

        return $this->render('@AWAPartners/ContactMail/edit.html.twig', array(
            'contactMail' => $contactMail,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param ContactMail $contactMail
     * @return JsonResponse
     */
    public function deleteAction(ContactMail $contactMail)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;
        try {
            $em->remove($contactMail);
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
        $contactMail = $this->getDoctrine()
            ->getManager()
            ->getRepository('AWAPartnersBundle:ContactMail')
            ->findOneBy(array('mailAddress' => $mail));

        $exists = true;

        if ($contactMail === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }

}
