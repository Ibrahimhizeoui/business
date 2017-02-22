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
use CRM\CrmBundle\Entity\Rendezvous;




class RendezvousController extends Controller
{
	public function rendezvousAction(){}
	public function ajouterrendezvousAction(Request $request){
		$rdv=new Rendezvous;
		$form=$this->createFormBuilder($rdv)
		           ->add('titre', TextType::class)
		           ->add('type',ChoiceType::class, array(
                         'choices'  => array('Nouveau' => 'nouveau','Qualifié' => 'qualifie','Proposition' => 'Proposition','Négociation' => 'negociation'), ))
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
                 return $this->redirectToRoute('rendez-vous');}

        return $this->render('CRMCrmBundle:rendezvous:ajouter_opportunite.html.twig',array('form'=>$form->createView()));
                                  

	}

	public function supp_rdvAction($id){
		$em=$this->getDoctrine()->getManager();
		$opportunite=$em->getRepository('CRMCrmBundle:Rendezvous')->find($id);
    	
    	if (!$opportunite) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		$em->remove($opportunite);
        $em->flush();
        return $this->redirectToRoute('pipline');
     }

}