<?php

namespace SBC\AWAPartnersBundle\Controller;

use SBC\AWAPartnersBundle\Entity\Client;
use SBC\AWAPartnersBundle\Form\ClientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClientController
 * @package SBC\AWAPartnersBundle\Controller
 */
class ClientController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('AWAPartnersBundle:Client')->findAll();

        return $this->render('@AWAPartners/Client/index.html.twig', array(
            'clients' => $clients,
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('AWAPartnersBundle:Client')->getAll();

        return $this->render('@AWAPartners/Client/list.html.twig', array(
            'clients' => $clients
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $lastposition = $em->getRepository('AWAPartnersBundle:Client')->getLastPosition();
            $client->setPosition($lastposition + 1);
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_show', array('id' => $client->getId()));
        }

        return $this->render('@AWAPartners/Client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Client $client)
    {

        return $this->render('@AWAPartners/Client/show.html.twig', array(
            'client' => $client
        ));
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function editAction(Request $request, Client $client)
    {
        $editForm = $this->createForm(ClientType::class, $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_show', array('id' => $client->getId()));
        }

        return $this->render('@AWAPartners/Client/edit.html.twig', array(
            'client' => $client,
            'form' => $editForm->createView()
        ));
    }

    /**
     * @param Client $client
     * @return JsonResponse
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function deleteAction(Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $deleted = true;
        try {
            $em->remove($client);
            $em->flush();
        } catch (\Exception $e) {
            $deleted = false;
        }
        return new JsonResponse(array('deleted' => $deleted));

    }

    /**
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function updatePositionsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $old = $request->request->get('old');
        $old++;
        $new = $request->request->get('new');
        $new++;

        $client = $em->getRepository('AWAPartnersBundle:Client')->findOneBy(array('position' => $old));
        $em->getRepository('AWAPartnersBundle:Client')->updatePositions($old, $new);


        $client->setPosition($new);
        $em->persist($client);
        $em->flush();


        return new Response(json_encode($old));
    }

    /**
     * @param Client $client
     * @return JsonResponse
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function maskOrDisplayAction(Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $done = true;

        $client->setDisplayed(!$client->isDisplayed());
        try {
            $em->persist($client);
            $em->flush();
        } catch (\Exception $e) {
            $done = false;

        }
        return new JsonResponse(array('done' => $done));
    }


}
