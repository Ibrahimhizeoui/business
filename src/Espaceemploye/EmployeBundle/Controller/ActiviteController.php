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
use UserUserBundle\Entity\User;

class ActiviteController extends Controller
  {
       public function activitesAction(){
       	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
        $activites=$em->getRepository('GRHGrhBundle:Activite')->findByEmploye($employe);
        //var_dump($activites);
        return $this->render('EspaceemployeEmployeBundle:activite:activites.html.twig',array('activites'=>$activites,'employe'=>$employe));

       }
       public function ajouter_activiteAction(Request $request){

       	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
        $activite = new Activite;
        $form=$this->createFormBuilder($activite)
            ->add('sujet',TextType::class)
            ->add('remarque',TextType::class)
            //->add('email',TextType::class)
            ->add('description',TextareaType::class)
            ->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
            // $form1->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
          	 
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $activite->setEmploye($employe);
              $activite->setStatus('oui');
              $em->persist($activite);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('activites');
    
        
       }
       return $this->render('EspaceemployeEmployeBundle:activite:ajouter_activite.html.twig',array('form' => $form->createView(),'employe'=>$employe));
  }
 
  public function modif_activiteAction(Request $request,$id){

       	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
        $activite = $em->getRepository('GRHGrhBundle:Activite')->find($id);;
        $form=$this->createFormBuilder($activite)
            ->add('sujet',TextType::class)
            ->add('remarque',TextType::class)
            //->add('email',TextType::class)
            ->add('description',TextareaType::class)
            ->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
            ->add('status',ChoiceType::class ,array(
                         'choices'  => array('Oui' => 'oui','Non' => 'non'),))

             ->getForm();
            
         $form->handleRequest($request);
            // $form1->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
          	 
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('activites');
    
        
       }
       return $this->render('EspaceemployeEmployeBundle:activite:modif_activite.html.twig',array('form' => $form->createView(),'employe'=>$employe));
  }

  public function supp_activiteAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();

       	$activite = $em->getRepository('GRHGrhBundle:Activite')->find($id);
        if (!$activite) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $em->remove($activite);
        $em->flush();
        return $this->redirectToRoute('activites');
    
        
  }

}
