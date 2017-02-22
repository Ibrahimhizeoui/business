<?php

namespace STOCK\StockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('STOCKStockBundle:Default:index.html.twig');
    }
}
