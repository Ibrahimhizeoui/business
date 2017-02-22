<?php

namespace GRH\GrhBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use GRH\GrhBundle\Entity\Employe;
use GRH\GrhBundle\Entity\Conge;
use UserUserBundle\Entity\User;

class CongeController extends Controller
{
	public function congesAction(){
        $em= $this->getDoctrine()->getManager();
        $conges=$em->getRepository('GRHGrhBundle:Conge')->findAll();
        return $this->render('GRHGrhBundle:conge:conges.html.twig', array( 'conges' => $conges,));
	   }

	public function demande_congesAction(){
		$em= $this->getDoctrine()->getManager();
		$conges=$em->getRepository('GRHGrhBundle:Conge')->demandeconge();
		return $this->render('GRHGrhBundle:conge:demande_conges.html.twig', array( 'conges' => $conges,));
	}

	public function modif_congeAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$conge=$em->getRepository('GRHGrhBundle:Conge')->find($id);
		if (!$conge) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
		$form=$this->createFormBuilder($conge)
		->add('employe', EntityType::class, array(
               'class' => 'GRHGrhBundle:Employe',
               'choice_label' => 'prenom',))
            
		
    	->add('nbjours',TextType::class)
    	
    	->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
        ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            
            ->add('remarque',TextareaType::class)
            ->add('status',ChoiceType::class, array(
                         'choices'  => array('Non verifier' => 'Non verifier',
                         	                  'Verifier' => 'verifier',
                         	                  ),
                         	))
            
            //->add('email',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              $employe=$conge->getEmploye();
              if ($conge->getStatus()=='verifier') {
              $employe->setSoldeconges($employe->getSoldeconges()- $conge->getNbjours());
              $em->flush();
              return $this->redirectToRoute('conges');
              }
              $em->flush();
              return $this->redirectToRoute('conges');
    }
    
		 return $this->render('GRHGrhBundle:conge:modif_conges.html.twig',array('form' => $form->createView(),));

	}

	public function supp_congeAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$conge=$em->getRepository('GRHGrhBundle:Conge')->find($id);
		if (!$conge) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $em->remove($conge);
        $em->flush();
        return $this->redirectToRoute('conges');
	}
	

}