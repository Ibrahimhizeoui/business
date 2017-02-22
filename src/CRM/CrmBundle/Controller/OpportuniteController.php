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
use CRM\ClientBundle\Entity\Service;
use CRM\CrmBundle\Entity\Client;
use CRM\CrmBundle\Entity\Opportunite;
use CRM\CrmBundle\Entity\Compagne;
use CRM\CrmBundle\Entity\Rendezvous;





class OpportuniteController extends Controller
{

	public function opportunitesAction(){
		$em=$this->getDoctrine()->getManager();
    	$opportunites=$em->getRepository('CRMCrmBundle:Opportunite')->findAll();
    	

        return $this->render('CRMCrmBundle:opportunite:opportunites.html.twig',array('opportunites'=>$opportunites));
	}
  public function calendierAction(){
    
      

        return $this->render('CRMCrmBundle:Default:calendier.html.twig');
  }
	public function ajouter_opportuniteAction(Request $request){
		$opportunite= new Opportunite;
		$form=$this->createFormBuilder($opportunite)
		           ->add('intitule', TextType::class)
		           ->add('revenue', TextType::class)
                   //->add('description',TextareaType::class)
                   ->add('activite',ChoiceType::class, array(
                         'choices'  => array('Courriel' => 'courriel','Appeler' => 'appeler'), ))
                   ->add('type',ChoiceType::class, array(
                         'choices'  => array('Nouveau' => 'nouveau','Qualifié' => 'qualifie','Proposition' => 'Proposition','Négociation' => 'negociation'), ))
                   ->add('datefermeture', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',))
                   ->add('client', EntityType::class, array(
                          'class' => 'CRMCrmBundle:Client',
                          'choice_label' => 'nom',
                          'required'    => true,
                         'placeholder' => 'Choisir le client',
                          'empty_data'  => null))
                   ->add('compagne', EntityType::class, array(
                          'class' => 'CRMCrmBundle:Compagne',
                          'choice_label' => 'intitule',
                          'required'    => true,
                          'placeholder' => 'Choisir la compagne marketing',
                          'empty_data'  => null))
                   ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $em=$this->getDoctrine()->getManager();
                  $opportunite->setGagnier('');
                  $opportunite->setFermer('non');
                  $em->persist($opportunite);
                  $em->flush();
                 return $this->redirectToRoute('opportunites');}

        return $this->render('CRMCrmBundle:opportunite:ajouter_opportunite.html.twig',array('form'=>$form->createView()));
	}

	public function modif_opportuniteAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$opportunite=$em->getRepository('CRMCrmBundle:Opportunite')->find($id);
    	
    	if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		
		$form=$this->createFormBuilder($opportunite)
		           ->add('intitule', TextType::class)
		           ->add('revenue', TextType::class)
                   //->add('description',TextareaType::class)
                   ->add('activite',ChoiceType::class, array(
                         'choices'  => array('Courriel' => 'courriel','Appeler' => 'appeler'), ))
                   ->add('type',ChoiceType::class, array(
                         'choices'  => array('Nouveau' => 'nouveau','Qualifié' => 'qualifie','Proposition' => 'Proposition','Négociation' => 'negociation'), ))
                   ->add('datefermeture', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',))
                   ->add('client', EntityType::class, array(
                          'class' => 'CRMCrmBundle:Client',
                          'choice_label' => 'nom',))
                   ->add('compagne', EntityType::class, array(
                          'class' => 'CRMCrmBundle:Compagne',
                          'choice_label' => 'intitule',))
                   ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $em=$this->getDoctrine()->getManager();
                  
                  $em->flush();
                 return $this->redirectToRoute('opportunites');}

        return $this->render('CRMCrmBundle:opportunite:modif_opportunite.html.twig',array('form'=>$form->createView()));
	}

	public function supp_opportuniteAction($id){
		$em=$this->getDoctrine()->getManager();
		$opportunite=$em->getRepository('CRMCrmBundle:Opportunite')->find($id);
    	
    	if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		$em->remove($opportunite);
        $em->flush();
        return $this->redirectToRoute('opportunites');
     }

     public function traiter_opportuniteAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$opportunite=$em->getRepository('CRMCrmBundle:Opportunite')->find($id);
		if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
    	
    	$form=$this->createFormBuilder($opportunite)
		           
                   //->add('description',TextareaType::class)
                   ->add('activite',ChoiceType::class, array(
                         'choices'  => array('Courriel' => 'courriel','Appeler' => 'appeler'), ))
                   ->add('type',ChoiceType::class, array(
                         'choices'  => array('Nouveau' => 'nouveau','Qualifié' => 'qualifie','Proposition' => 'Proposition','Négociation' => 'negociation'), ))
                   
                   ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $em=$this->getDoctrine()->getManager();
                  
                  $em->flush();
                 return $this->redirectToRoute('opportunites');}
         return $this->render('CRMCrmBundle:opportunite:traiter_opportunite.html.twig',array('form'=>$form->createView(),'opportunite'=>$opportunite));
     }

     public function piplineAction(Request $request){
     	$em=$this->getDoctrine()->getManager();
      $opportunites=$em->getRepository('CRMCrmBundle:Opportunite')->fermeroppor();
    	$rdvarriver=$em->getRepository('CRMCrmBundle:Rendezvous')->rdvarriver();
      $rdv=new Rendezvous;
      $form=$this->createFormBuilder($rdv)
               ->add('titre', TextType::class)
               ->add('type',ChoiceType::class, array(
                         'choices'  => array('a faire' => 'a faire','travail' => 'travail','profesionnelee' => 'profesionnelee','Négociation' => 'negociation'), ))
                   ->add('debut', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',))
                    ->add('fin', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $em=$this->getDoctrine()->getManager();
                  $em->persist($rdv);
                  $em->flush();
                  $response = new JsonResponse();
                  return $response;
              
                 
               }

    	

        return $this->render('CRMCrmBundle:opportunite:pipline.html.twig',array('opportunites'=>$opportunites,
          'form'=>$form->createView(),'rdvarriver'=>$rdvarriver));
     	
     }

     public function fermeropporAction(){
        // var_dump(expression)
        if (isset($_POST['id'])) {
        	$id=$_POST['id'];
        	$em=$this->getDoctrine()->getManager();
		    $opportunite=$em->getRepository('CRMCrmBundle:Opportunite')->find($id);
		    if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
                        $opportunite->setFermer('oui');
            $em->flush();
              $response = new JsonResponse();
              return $response;
    	
        	# code...
        }
     }

     public function margergagnierAction(){
            // var_dump(expression)
             if (isset($_POST['id'])) {
        	$id=$_POST['id'];
        	$em=$this->getDoctrine()->getManager();
		    $opportunite=$em->getRepository('CRMCrmBundle:Opportunite')->find($id);
		    if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
                        $opportunite->setFermer('oui');
                        $opportunite->setGagnier('oui');
            $em->flush();
              $response = new JsonResponse();
              return $response;
    	
        	# code...
         }
     }

     public function margerperdusAction(){
        // var_dump(expression)
       if (isset($_POST['id'])) {
        	$id=$_POST['id'];
        	$em=$this->getDoctrine()->getManager();
		    $opportunite=$em->getRepository('CRMCrmBundle:Opportunite')->find($id);
		    if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
                        $opportunite->setFermer('oui');
                        $opportunite->setGagnier('non');
            $em->flush();
              $response = new JsonResponse();
              return $response;
    	
        	# code...
         }
     	
    }

    public function opportunitesouvertAction(){
     	$em=$this->getDoctrine()->getManager();
    	$opportunites=$em->getRepository('CRMCrmBundle:Opportunite')->opportunitesouvert();
    	

        return $this->render('CRMCrmBundle:opportunite:opportunitesouvert.html.twig',array('opportunites'=>$opportunites));
     	
     }

     public function opportunitesfermeAction(){
     	$em=$this->getDoctrine()->getManager();
    	$opportunites=$em->getRepository('CRMCrmBundle:Opportunite')->opportunitesferme();
    	

        return $this->render('CRMCrmBundle:opportunite:opportunitesferme.html.twig',array('opportunites'=>$opportunites));
     	
     }

     public function opportunitesperdusAction(){
     	$em=$this->getDoctrine()->getManager();
    	$opportunites=$em->getRepository('CRMCrmBundle:Opportunite')->opportunitesperdus();
    	

        return $this->render('CRMCrmBundle:opportunite:opportunitesperdus.html.twig',array('opportunites'=>$opportunites));
     	
     }

     public function opportunitesganigerAction(){
     	$em=$this->getDoctrine()->getManager();
    	$opportunites=$em->getRepository('CRMCrmBundle:Opportunite')->opportunitesganiger();
    	

        return $this->render('CRMCrmBundle:opportunite:opportunitesganiger.html.twig',array('opportunites'=>$opportunites));
     	
     }


}


     
    