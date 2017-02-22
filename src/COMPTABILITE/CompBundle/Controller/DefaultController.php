<?php

namespace COMPTABILITE\CompBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('COMPTABILITECompBundle:Default:index.html.twig');
    }
}
