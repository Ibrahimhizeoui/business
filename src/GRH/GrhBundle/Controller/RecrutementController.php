<?php

namespace GRH\GrhBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use GRH\GrhBundle\Entity\Employe;
use GRH\GrhBundle\Entity\Recrutement;
use GRH\GrhBundle\Entity\Entretien;
use GRH\GrhBundle\Entity\Condidat;
use UserUserBundle\Entity\User;

class RecrutementController extends Controller
{
      public function recrutementsAction(){
      	$em=$this->getDoctrine()->getManager();
      	$recrutements=$em->getRepository('GRHGrhBundle:Recrutement')->findAll();
      	return $this->render('GRHGrhBundle:Recrutement:recrutements.html.twig',array('recrutements' =>$recrutements , ));
      }

     

      public function suivis_recrutementsAction(Request $request){
      	$em=$this->getDoctrine()->getManager();
      	$condidat= new Condidat;
      	$form=$this->createFormBuilder($condidat)
      	->add('recrutement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Recrutement',
               'choice_label' => 'intitule',))
          ->add('nom',TextType::class)
     	    ->add('tel',TextType::class)
     	    ->add('prenom',TextType::class)
     	    ->add('datenaiss', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
     	     ->add('dateentretien', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
     	     ->add('niveau',TextType::class)
     	    ->add('remarque',TextareaType::class)
     	    ->add('save', SubmitType::class, array('label' => 'Ajouter condidat'))
     	    ->getForm();
             $form->handleRequest($request);
         
            
             if ($form->isSubmitted() && $form->isValid()) {
             
           	  
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($condidat);
              $em->flush();
              
             return $this->redirectToRoute('suivis_recrutements');
             }
      	$recrutement=$em->getRepository('GRHGrhBundle:Recrutement')->recrutouvert();
      	$condidats=$em->getRepository('GRHGrhBundle:Condidat')->findAll();

      	return $this->render('GRHGrhBundle:Recrutement:suivis_recrutements.html.twig',array('condidats' =>$condidats,'recrutements' =>$recrutement ,'form' => $form->createView() ));
      }

      public function list_condidatAction($id){
        $em = $this->getDoctrine()->getManager();
      	$recrutement=$em->getRepository('GRHGrhBundle:Recrutement')->find($id);
      	$condidats=$em->getRepository('GRHGrhBundle:Condidat')->sescondidats($id);
      	return $this->render('GRHGrhBundle:Recrutement:list_condidat.html.twig',array('condidats' =>$condidats,'recrutement' =>$recrutement ));


      }



      public function ajouter_recrutementAction(Request $request){
        $recrutement= new Recrutement;
      	$form=$this->createFormBuilder($recrutement)
     	    ->add('departement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Departement',
               'choice_label' => 'nom',
               'required'    => false,
                'placeholder' => 'Choisir le departement',
                'empty_data'  => null))
     	    ->add('type',TextType::class)
     	    ->add('intitule',TextType::class)
     	    ->add('dateAjout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
           
            ->add('nbEmployes',TextType::class)
            
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Ouvert' => 'ouvert','Fermer' => 'fermer'),
                         'expanded'=>true,
                         'multiple'=>false	))
            
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

            ->getForm();
             $form->handleRequest($request);
            
             if ($form->isSubmitted() && $form->isValid()) {
             
           	  
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($recrutement);
              $em->flush();
              
             return $this->redirectToRoute('recrutements');
          }
            
        return $this->render('GRHGrhBundle:Recrutement:ajouter_recrutement.html.twig',array('form' => $form->createView()));

     }

     public function supp_recrutementAction($id){
     	$em = $this->getDoctrine()->getManager();

        $recrutement = $em->getRepository('GRHGrhBundle:Recrutement')->find($id);
        if (!$recrutement) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $em->remove($recrutement);
        $em->flush();
        return $this->redirectToRoute('recrutements');
    
     }

     public function modif_recrutementAction(Request $request,$id){
     	$em = $this->getDoctrine()->getManager();

        $recrutement = $em->getRepository('GRHGrhBundle:Recrutement')->find($id);
        if (!$recrutement) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $form=$this->createFormBuilder($recrutement)
     	    ->add('departement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Departement',
               'choice_label' => 'nom',))
     	    ->add('type',TextType::class)
     	    ->add('intitule',TextType::class)
     	    ->add('dateAjout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
           
            ->add('nbEmployes',TextType::class)
            
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Ouvert' => 'ouvert','Fermer' => 'fermer'),
                         'expanded'=>true,
                         'multiple'=>false	))
            
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

            ->getForm();
             $form->handleRequest($request);
            
             if ($form->isSubmitted() && $form->isValid()) {
             
           	  
          	  $em = $this->getDoctrine()->getManager();
            
              $em->flush();
              
             return $this->redirectToRoute('recrutements');
          }
            
        return $this->render('GRHGrhBundle:Recrutement:modif_recrutement.html.twig',array('form' => $form->createView()));
     	
     }

     public function detail_recrutementAction(Request $request,$id){
     	$em = $this->getDoctrine()->getManager();

        $recrutement = $em->getRepository('GRHGrhBundle:Recrutement')->find($id);
        if (!$recrutement) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        return $this->render('GRHGrhBundle:Recrutement:detail_recrutement.html.twig',array('recrutement' => $recrutement));

     }

     public function ajouter_entretienAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $entretien= new Entretien;
        $condidat = $em->getRepository('GRHGrhBundle:Condidat')->find($id);
        if (!$condidat) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $form=$this->createFormBuilder($entretien)
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Refuser' => 'refuser','Passable' => 'passable','Accepter' => 'accepter'),
                         'expanded'=>true,
                         'multiple'=>false  ))
            
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

            ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
             
              
              $em = $this->getDoctrine()->getManager();
              $entretien->setCondidat($condidat);
              $em->persist($entretien);
              $em->flush();
              
             return $this->redirectToRoute('suivis_recrutements');
             }

             return $this->render('GRHGrhBundle:Recrutement:ajouter_entretien.html.twig',array('form' => $form->createView(),
              'condidat'=> $condidat));

     }
     public function list_entretienAction(){
       $em = $this->getDoctrine()->getManager();
       $entretiens=$em->getRepository('GRHGrhBundle:Entretien')->findAll();
       return $this->render('GRHGrhBundle:Recrutement:list_entretien.html.twig',array(
              'entretiens'=> $entretiens));

     }

     public function supp_entretienAction($id){
       $em = $this->getDoctrine()->getManager();
      $entretien = $em->getRepository('GRHGrhBundle:Entretien')->find($id);
        if (!$entretien) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
         $em = $this->getDoctrine()->getManager();
         $em->remove($entretien);
         $em->flush();
         return $this->redirectToRoute('list_entretien');
     }

     public function supp_condidatAction($id){
       $em = $this->getDoctrine()->getManager();
      $condidat = $em->getRepository('GRHGrhBundle:Condidat')->find($id);
        if (!$condidat) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
         $em = $this->getDoctrine()->getManager();
         $em->remove($condidat);
         $em->flush();
         return $this->redirectToRoute('recrutements');
     }
    
      
}