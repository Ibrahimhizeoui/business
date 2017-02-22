<?php

namespace GRH\GrhBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GRHGrhBundle:Default:index.html.twig');
    }
}
