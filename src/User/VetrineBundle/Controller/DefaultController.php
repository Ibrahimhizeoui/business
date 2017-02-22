<?php

namespace User\VetrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserVetrineBundle:Default:index.html.twig');
    }

    public function index2Action()
    {
        return $this->render('UserVetrineBundle:Default:index2.html.twig');
    }
}
