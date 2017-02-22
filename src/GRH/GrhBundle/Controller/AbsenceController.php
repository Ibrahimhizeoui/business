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
use GRH\GrhBundle\Entity\Absence;
use UserUserBundle\Entity\User;

class AbsenceController extends Controller
{
	public function absencesAction(){
		$em=$this->getDoctrine()->getManager();
		$absences=$em->getRepository('GRHGrhBundle:Absence')->findAll();
		return $this->render('GRHGrhBundle:absence:absences.html.twig', array( 'absences' => $absences,));
	}

	public function ajouter_absenceAction(Request $request){
		$absence= new Absence;
		$form=$this->createFormBuilder($absence)
		->add('employe', EntityType::class, array(
               'class' => 'GRHGrhBundle:Employe',
               'choice_label' => 'prenom',
                'required'    => true,
                'placeholder' => 'Choisir l\'employé',
                'empty_data'  => null))
            
		->add('cause',TextType::class)
    	->add('nbjours',TextType::class)
    	
    	->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
        ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            
            ->add('remarque',TextareaType::class)
            ->add('status',ChoiceType::class, array(
                         'choices'  => array('Non justifier' => 'Non justifier',
                                            'Justifier' => 'Justifier',
                                            ),
                          ))
            
            //->add('email',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($absence);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('absences');
    }
    
		 return $this->render('GRHGrhBundle:absence:ajouter_absence.html.twig',array('form' => $form->createView(),));


	}

	public function modif_absenceAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$absence=$em->getRepository('GRHGrhBundle:Absence')->find($id);
		
		$form=$this->createFormBuilder($absence)
		->add('employe', EntityType::class, array(
               'class' => 'GRHGrhBundle:Employe',
               'choice_label' => 'prenom',
               'required'    => true,
                'placeholder' => 'Choisir l\'employé',
                'empty_data'  => null))
            
		->add('cause',TextType::class)
    	->add('nbjours',TextType::class)
    	
    	->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
        ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            
            ->add('remarque',TextareaType::class)
             ->add('status',ChoiceType::class, array(
                         'choices'  => array('Non justifier' => 'Non justifier',
                                            'Justifier' => 'Justifier',
                                            ),
                          ))
           
            //->add('email',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('absences');
    }
    
		 return $this->render('GRHGrhBundle:absence:modif_absence.html.twig',array('form' => $form->createView(),));


	}

	 public function supp_absenceAction($id){
      $em=$this->getDoctrine()->getManager();
      $absence=$this->getDoctrine()->getRepository('GRHGrhBundle:Absence')->find($id);
      if (!$absence) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $em->remove($absence);
        $em->flush();
        return $this->redirectToRoute('absences');
    }
}