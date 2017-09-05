<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\Project;
use SBC\AWAPartnersBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 * @package SBC\AWAPartnersBundle\Controller
 */
class ProjectController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('AWAPartnersBundle:Project')->findAll();
        $projectTypes = $em->getRepository('AWAPartnersBundle:ProjectType')->findAll();

        return $this->render('@AWAPartners/Project/index.html.twig', array(
            'projects' => $projects,
            'projectTypes' => $projectTypes
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('AWAPartnersBundle:Project')->findAll();

        return $this->render('@AWAPartners/Project/list.html.twig', array(
            'projects' => $projects
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project_show', array('id' => $project->getId()));
        }

        return $this->render('@AWAPartners/Project/new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Project $project)
    {

        return $this->render('@AWAPartners/Project/show.html.twig', array(
            'project' => $project
        ));
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function editAction(Request $request, Project $project)
    {

        $editForm = $this->createForm(ProjectType::class, $project);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            foreach ($project->getPictures() as $picture) {
                if ($picture->getDescription() == null){
                    $project->removePicture($picture);
                    $em->remove($picture);
                }else{
                    $project->addPicture($picture);
                }
            }
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project_list');
        }

        return $this->render('@AWAPartners/Project/edit.html.twig', array(
            'project' => $project,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param Project $project
     * @return JsonResponse
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function deleteAction(Project $project)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;
        $msg = '';
        try {
            $em->remove($project);
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
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function findByTitleAction($title)
    {
        $project = $this->getDoctrine()
            ->getManager()
            ->getRepository('AWAPartnersBundle:Project')
            ->findOneBy(array('title' => $title));

        $exists = true;

        if ($project === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }


}
