<?php

namespace CRM\ClientBundle\Controller;

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
use CRM\ClientBundle\Entity\Service;
use CRM\CrmBundle\Entity\Client;




class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CRMClientBundle:Default:index.html.twig');
    }

    public function messervicesAction()
    {
    	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$client=$em->getRepository('CRMCrmBundle:Client')->findOneByEmail($email);
    	$services=$em->getRepository('CRMClientBundle:Service')->findByClient($client);

        return $this->render('CRMClientBundle:Default:messervices.html.twig',array('services'=>$services));
    }

    public function ajouter_serviceAction(Request $request)
    {
    	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$client=$em->getRepository('CRMCrmBundle:Client')->findOneByEmail($email);
    	$service= new Service;
    	$service->setClient($client);
    	$form=$this->createFormBuilder($service)
                   ->add('sujet', TextType::class)
                   ->add('description',TextareaType::class)
                   ->add('status',ChoiceType::class, array(
                         'choices'  => array('Non' => 'non','OUI' => 'oui'), ))
                   ->add('dateajout', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',))
                   ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $service->setEtat('non_consulter');
                  $em->persist($service);
                  $em->flush();
                 return $this->redirectToRoute('messervices');}

        return $this->render('CRMClientBundle:Default:ajouter_service.html.twig',array('form'=>$form->createView()));
    }
    public function supp_serviceAction($id)
    {
        $em=$this->getDoctrine()->getManager();
    	$service=$em->getRepository('CRMClientBundle:Service')->find($id);
    	if (!$service) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute('messervices');
    }

    public function modif_serviceAction(Request $request,$id)
    {
    	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$client=$em->getRepository('CRMCrmBundle:Client')->findOneByEmail($email);
    	$service=$em->getRepository('CRMClientBundle:Service')->find($id);
    	if (!$service) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
    	$form=$this->createFormBuilder($service)
                   ->add('sujet', TextType::class)
                   ->add('description',TextareaType::class)
                   ->add('status',ChoiceType::class, array(
                         'choices'  => array('Non' => 'non','OUI' => 'oui'), ))
                   ->add('dateajout', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',))
                   ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  
                  $em->flush();
                 return $this->redirectToRoute('messervices');}

        return $this->render('CRMClientBundle:Default:modif_service.html.twig',array('form'=>$form->createView()));
    }

    public function danger_serviceAction()
    {
        $em=$this->getDoctrine()->getManager();
        $curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$client=$em->getRepository('CRMCrmBundle:Client')->findOneByEmail($email);
    	$nbservices=$em->getRepository('CRMClientBundle:Service')->danger_service($client->getId());
        $response = new JsonResponse();
        return $response->setData(array('service'=>$nbservices));
    }

    public function mes_services_traiteeAction(){
        $em=$this->getDoctrine()->getManager();
        $curuser=$this->getUser();
        $email=$curuser->getEmail();
        $client=$em->getRepository('CRMCrmBundle:Client')->findOneByEmail($email);
        $services=$em->getRepository('CRMClientBundle:Service')->services($client->getId()); 
        return $this->render('CRMClientBundle:Default:mes_services_traitee.html.twig',array('services'=>$services));
    }

    public function detail_serviceAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
        
        $service=$em->getRepository('CRMClientBundle:Service')->find($id); 
        if (!$service) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $form=$this->createFormBuilder($service)
                   
                   ->add('status',ChoiceType::class, array(
                         'choices'  => array('Non' => 'non','OUI' => 'oui'), ))
                   
                   ->add('save', SubmitType::class, array('label' => 'Ok','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  
                  $em->flush();
                 return $this->redirectToRoute('mes_services_traitee');}

        return $this->render('CRMClientBundle:Default:detail_service.html.twig',array('form'=>$form->createView(),'service'=>$service));
    }
}
