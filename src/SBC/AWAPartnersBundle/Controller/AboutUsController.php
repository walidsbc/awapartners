<?php

namespace SBC\AWAPartnersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AboutUsController
 * @package SBC\AWAPartnersBundle\Controller
 */
class AboutUsController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutUsAction()
    {
        return $this->render('@AWAPartners/AboutUs/aboutUs.html.twig');
    }
}
