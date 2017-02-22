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
use CRM\CrmBundle\Entity\Compagne;




class CompagneController extends Controller
{
   public function compagnesAction()
    {
      $em=$this->getDoctrine()->getManager();
      $compagnes=$em->getRepository('CRMCrmBundle:Compagne')->findAll();
      //var_dump($services);
        return $this->render('CRMCrmBundle:compagne:compagnes.html.twig',array('compagnes'=>$compagnes));
    }

	public function ajouter_compagneAction(Request $request){
		$compagne=new Compagne;
		$form=$this->createFormBuilder($compagne)
		           ->add('intitule',TextType::class)
		           ->add('moyenne',TextType::class)
		           ->add('budget',TextType::class)
                   ->add('description',TextareaType::class)
                   ->add('datefermeture',DateType::class,
                   	array(
                         'input'  => 'datetime',
                         'widget' => 'single_text'))

                   ->add('save', SubmitType::class, array('label' => 'enregistrer'))
            ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
          	           $em=$this->getDoctrine()->getManager();
          	           $em->persist($compagne);
                       
                       $em->flush();
                       }
    	
        return $this->render('CRMCrmBundle:compagne:ajouter_compagne.html.twig',array('form'=>$form->createView()));

	}
}