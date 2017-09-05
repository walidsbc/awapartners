<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\Skill;
use SBC\AWAPartnersBundle\Form\SkillType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SkillController
 * @package SBC\AWAPartnersBundle\Controller
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class SkillController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $skills = $this->getDoctrine()->getManager()->getRepository('AWAPartnersBundle:Skill')->findAll();

        return $this->render('@AWAPartners/Skill/index.html.twig', array(
            'skills' => $skills,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($skill);
            $em->flush();

            return $this->redirectToRoute('skill_show', array('id' => $skill->getId()));
        }

        return $this->render('@AWAPartners/Skill/new.html.twig', array(
            'skill' => $skill,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Skill $skill
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Skill $skill)
    {
        return $this->render('@AWAPartners/Skill/show.html.twig', array(
            'skill' => $skill,

        ));
    }

    /**
     * @param Request $request
     * @param Skill $skill
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Skill $skill)
    {
        $editForm = $this->createForm(SkillType::class, $skill);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('skill_show', array('id' => $skill->getId()));
        }

        return $this->render('@AWAPartners/Skill/edit.html.twig', array(
            'skill' => $skill,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * @param Skill $skill
     * @return JsonResponse
     */
    public function deleteAction(Skill $skill)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;
        try {
            $em->remove($skill);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return new JsonResponse(array('deleted' => $deleted));
    }

    /**
     * @param $name
     * @return JsonResponse
     */
    public function findByNameAction($name)
    {
        $skill = $this->getDoctrine()
            ->getManager()
            ->getRepository('AWAPartnersBundle:Skill')
            ->findOneBy(array('name' => $name));

        $exists = true;

        if ($skill === null)
            $exists = false;

        return new JsonResponse(array('exists' => $exists));
    }

}
