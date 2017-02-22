<?php

namespace CRM\CrmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CRMCrmBundle:Default:index.html.twig');
    }
}
