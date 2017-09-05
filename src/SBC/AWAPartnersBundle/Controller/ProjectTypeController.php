<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\ProjectType;
use SBC\AWAPartnersBundle\Form\ProjectTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ProjectTypeController
 * @package SBC\AWAPartnersBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ProjectTypeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $projectTypes = $this->getDoctrine()->getManager()->getRepository('AWAPartnersBundle:ProjectType')->findAll();

        return $this->render('@AWAPartners/ProjectType/index.html.twig', array(
            'projectTypes' => $projectTypes
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {

        $projectType = new ProjectType();
        $form = $this->createForm(ProjectTypeType::class, $projectType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($projectType);
            $em->flush();

            return $this->redirectToRoute('project_type_show', array('id' => $projectType->getId()));
        }

        return $this->render('@AWAPartners/ProjectType/new.html.twig', array(
            'projectType' => $projectType,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param ProjectType $projectType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(ProjectType $projectType)
    {

        return $this->render('@AWAPartners/ProjectType/show.html.twig', array(
            'projectType' => $projectType

        ));
    }

    /**
     * @param Request $request
     * @param ProjectType $projectType
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, ProjectType $projectType)
    {

        $editForm = $this->createForm(ProjectTypeType::class, $projectType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project_type_show', array('id' => $projectType->getId()));
        }

        return $this->render('@AWAPartners/ProjectType/edit.html.twig', array(
            'projectType' => $projectType,
            'form' => $editForm->createView(),

        ));
    }

    /**
     * @param ProjectType $projectType
     * @return JsonResponse
     */
    public function deleteAction(ProjectType $projectType)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;
        $msg = '';
        try {
            $em->remove($projectType);
            $em->flush();
        } catch (\Exception $e) {
            $success = false;
            $msg = $e->getMessage();
        }
        return new JsonResponse(array('success' => $success, 'mesgerror' => $msg));
    }

    /**
     * @param $title
     * @return JsonResponse
     */
    public function findByTitleAction($title)
    {
        $projectType = $this->getDoctrine()
            ->getManager()
            ->getRepository('AWAPartnersBundle:ProjectType')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($projectType === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}