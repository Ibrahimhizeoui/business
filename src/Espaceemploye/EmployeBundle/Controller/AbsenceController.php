<?php

namespace Espaceemploye\EmployeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use GRH\GrhBundle\Entity\Employe;
use GRH\GrhBundle\Entity\Activite;
use GRH\GrhBundle\Entity\Absence;
use UserUserBundle\Entity\User;

class AbsenceController extends Controller
  {
  	public function absencesAction(){
  		$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
    	$absences=$em->getRepository('GRHGrhBundle:Absence')->findByEmploye($employe);
    	 return $this->render('EspaceemployeEmployeBundle:absence:absences.html.twig',array('absences'=>$absences,'employe'=>$employe));
  	}
  	public function ajouter_absenceAction(Request $request){
  		$absence= new Absence;
  		$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
    	$form=$this->createFormBuilder($absence)
    	->add('cause',TextType::class)
    	->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
        ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            
            ->add('remarque',TextareaType::class)
            //->add('email',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
          	 
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $absence->setEmploye($employe);
              $absence->setStatus('nn justifier');
              $em->persist($absence);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('absences');


         
  	}
  	return $this->render('EspaceemployeEmployeBundle:absence:ajouter_absence.html.twig',array('form' => $form->createView(),'employe'=>$employe));}
  }