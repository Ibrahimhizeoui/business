<?php

namespace COMPTABILITE\CompBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use COMPTABILITE\CompBundle\Entity\Taxe;




class TaxeController extends Controller
{
	public function TaxesAction(){
		$em=$this->getDoctrine()->getManager();
		$taxes=$em->getRepository('COMPTABILITECompBundle:Taxe')->findAll();
		return $this->render('COMPTABILITECompBundle:taxes:taxes.html.twig',array('taxes'=>$taxes));
	}

	public function ajouter_taxeAction(Request $request){
		$em=$this->getDoctrine()->getManager();
		$taxe= new Taxe;
		$form=$this->createFormBuilder($taxe)
		     ->add('nom',TextType::class)
             ->add('valeur',TextType::class)
             ->add('type',TextType::class)
             ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                  $em->persist($taxe);
                  $em->flush();
                 return $this->redirectToRoute('taxes');}
             return $this->render('COMPTABILITECompBundle:taxes:ajouter_taxe.html.twig',array('form'=>$form->createView()));
	}
	public function modif_taxeAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$taxe= $em->getRepository('COMPTABILITECompBundle:Taxe')->find($id);
		if (!$taxe) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		$form=$this->createFormBuilder($taxe)
		     ->add('nom',TextType::class)
             ->add('valeur',TextType::class)
             ->add('type',TextType::class)
             ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                  
                  $em->flush();
                 return $this->redirectToRoute('taxes');}
             return $this->render('COMPTABILITECompBundle:taxes:modif_taxe.html.twig',array('form'=>$form->createView()));
	}
	public function supp_taxeAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$taxe= $em->getRepository('COMPTABILITECompBundle:Taxe')->find($id);
		if (!$taxe) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		
                  $em->remove($taxe);
                  $em->flush();
                 return $this->redirectToRoute('taxes');
	}
}