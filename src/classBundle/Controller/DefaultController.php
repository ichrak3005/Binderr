<?php

namespace classBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('@class/Default/index.html.twig');
    }
    public function homeAction()
    {

        return $this->render('@class/Default/home.html.twig');
    }
}
