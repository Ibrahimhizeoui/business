<?php

namespace Espaceemploye\EmployeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use GRH\GrhBundle\Entity\Employe;
use GRH\GrhBundle\Entity\Conge;
use UserUserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	
    	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
    	$activites=$em->getRepository('GRHGrhBundle:Activite')->findByEmploye($employe);
        
        
        return $this->render('EspaceemployeEmployeBundle:Default:index.html.twig',array('employe'=>$employe,'activites'=>$activites));
    }
    public function changedonneeAction(Request $request){
    	$curuser=$this->getUser();
    	$email=$curuser->getEmail();
    	$em=$this->getDoctrine()->getManager();
    	$employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
        $form=$this->createFormBuilder($employe)
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            //->add('email',TextType::class)
            ->add('address',TextType::class)
            ->add('tel',TextType::class)
            ->add('datenaissance', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'choice',))
            ->add('sexe',ChoiceType::class, array(
                       'choices'  => array('Homme' => 'homme','Famme' => 'femme',),
                         'expanded'=>true,
                         'multiple'=>false	))
            ->add('nationalite',TextType::class)
            ->add('etatcivil',ChoiceType::class, array(
                         'choices'  => array('choisir etat' => null,'Célibataire' => 'celibataire','Marié' => 'marie'),
                         	))
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
            // $form1->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
          	 
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('espaceemploye_employe_homepage');
    }
       return $this->render('EspaceemployeEmployeBundle:Default:changedonnee.html.twig',array('form' => $form->createView(),'employe'=>$employe)); 
    }

    public function changepasswordAction(Request $request){
       $curuser=$this->getUser();
       $data= array('username'=>$curuser->getUsername());
       $form=$this->createFormBuilder($data)
       ->add('username',TextType::class)
       ->add('password',TextType::class)
       ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

       ->getForm();
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $data = $form->getData();
          
          $curuser->setUsername($data['username']);
          $curuser->setPlainPassword($data['password']);
          $this->get('fos_user.user_manager')->updateUser($curuser, false);
          $this->getDoctrine()->getManager()->flush();
          return $this->redirectToRoute('espaceemploye_employe_homepage');
          }
            //var_dump($form);
    	return $this->render('EspaceemployeEmployeBundle:Default:changepassword.html.twig',array('form' => $form->createView()));
    }

    public function congesAction(){
      $curuser=$this->getUser();
      $email=$curuser->getEmail();
      $em=$this->getDoctrine()->getManager();
      $employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
      $conges=$em->getRepository('GRHGrhBundle:Conge')->findByEmploye($employe);
       return $this->render('EspaceemployeEmployeBundle:Default:conges.html.twig',array('conges'=>$conges,'employe'=>$employe));
    }
    public function ajouter_congeAction(Request $request){
      $conge= new Conge;
      $curuser=$this->getUser();
      $email=$curuser->getEmail();
      $em=$this->getDoctrine()->getManager();
      $employe=$em->getRepository('GRHGrhBundle:Employe')->findOneByEmail($email);
      $form=$this->createFormBuilder($conge)
      
      ->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
        ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',))
            
            ->add('remarque',TextareaType::class)
            ->add('nbjours',TextType::class)
            //->add('email',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
             
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $conge->setEmploye($employe);
              $conge->setStatus('non verifier');
              $em->persist($conge);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('conges');


         
    }
    return $this->render('EspaceemployeEmployeBundle:Default:ajouter_conge.html.twig',array('form' => $form->createView(),'employe'=>$employe));
    }
}
