<?php

namespace COMPTABILITE\CompBundle\Controller;
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
use COMPTABILITE\CompBundle\Entity\Depence;

class DepenceController extends Controller
{
	public function depencesAction(){
		$em=$this->getDoctrine()->getManager();
		$depences=$em->getRepository('COMPTABILITECompBundle:Depence')->findAll();
		return $this->render('COMPTABILITECompBundle:depence:depences.html.twig',array('depences'=>$depences));
	}

	public function ajouter_depenceAction(Request $request){
		$depence= new Depence;
		$form=$this->createFormBuilder($depence)
		        ->add('fournisseur', EntityType::class, array(
                          'class' => 'STOCKStockBundle:Fournisseur',
                          'choice_label' => 'nom',
                          'placeholder' => 'Choisir un fournisseur',
                          'empty_data'  => null,
                          'required' => false))
		        ->add('datedepence', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                ->add('valeur',TextType::class)
                ->add('typepaiment',TextType::class)
                ->add('remarque',TextType::class)
                ->add('type',ChoiceType::class, array(
                         'choices'  => array('Brouillon' => 'brouillon','Facture' => 'facture'), ))
                ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
            	  $em=$this->getDoctrine()->getManager();
                  $em->persist($depence);
                  $em->flush();
                 $response = new JsonResponse();
                  return $response;
               }
        return $this->render('COMPTABILITECompBundle:depence:ajouter_depence.html.twig',array('form'=>$form->createView()));

	}

    public function modif_depenceAction(Request $request,$id){
    	$em=$this->getDoctrine()->getManager();
        $depence=$em->getRepository('COMPTABILITECompBundle:Depence')->find($id);
        if (!$depence) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $form=$this->createFormBuilder($depence)
		        ->add('fournisseur', EntityType::class, array(
                          'class' => 'STOCKStockBundle:Fournisseur',
                          'choice_label' => 'nom',
                          'placeholder' => 'Choisir un fournisseur',
                          'empty_data'  => null,
                          'required' => false))
		        ->add('datedepence', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                ->add('valeur',TextType::class)
                 ->add('typepaiment',TextType::class)
                ->add('remarque',TextType::class)
                ->add('type',ChoiceType::class, array(
                         'choices'  => array('Brouillon' => 'brouillon','Facture' => 'facture'), ))
                ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $em->persist($depence);
                  $em->flush();
                 return $this->redirectToRoute('depences');}
        return $this->render('COMPTABILITECompBundle:depence:modif_depence.html.twig',array('form'=>$form->createView()));

		
	}
 
}