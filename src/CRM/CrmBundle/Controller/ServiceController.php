<?php

namespace CRM\CrmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use CRM\CrmBundle\Entity\Client;
use CRM\ClientBundle\Entity\Service;

class ServiceController extends Controller
{
    public function servicesAction()
    {
    	$em=$this->getDoctrine()->getManager();
    	$services=$em->getRepository('CRMClientBundle:Service')->findAll();
    	//var_dump($services);
        return $this->render('CRMCrmBundle:service:services.html.twig',array('services'=>$services));
    }

    public function serviceenattentAction()
    {
    	$em=$this->getDoctrine()->getManager();
    	$services=$em->getRepository('CRMClientBundle:Service')->serviceenattent();
    	//var_dump($services);
        return $this->render('CRMCrmBundle:service:serviceenattent.html.twig',array('services'=>$services));
    }

    public function traiter_serviceAction(Request $request,$id)
    {
    	$em=$this->getDoctrine()->getManager();
    	$service=$em->getRepository('CRMClientBundle:Service')->find($id);
    	if (!$service) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
    	$form=$this->createFormBuilder($service)
                   //->add('sujet', TextType::class)
                   ->add('reponse',TextareaType::class)
                   ->add('prixservice',TextType::class)
                   ->add('etat',ChoiceType::class, array(
                         'choices'  => array('NON CONSULTER' => 'non_consulter','CONSULTER' => 'consulter','EN ATTENTE' => 'en_attente'), ))
                   
                   ->add('save', SubmitType::class, array('label' => 'enregistrer','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
          	          
                       
                       $em->flush();
              //var_dump($client);
                       return $this->redirectToRoute('services');
    }
    	//var_dump($services);
        return $this->render('CRMCrmBundle:service:traiter_service.html.twig',array('service'=>$service,'form'=>$form->createView()));
    }
}
