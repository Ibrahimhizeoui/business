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
use Symfony\Component\HttpFoundation\Request;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use GRH\GrhBundle\Entity\Employe;
use UserUserBundle\Entity\User;

class EmployeController extends Controller
{

	public function indexAction(){
		$em = $this->getDoctrine()->getManager();

        $employes = $em->getRepository('GRHGrhBundle:Employe')->findAll();

        return $this->render('GRHGrhBundle:Employe:index.html.twig', array(
            'employes' => $employes,
        ));
	}

	public function ajouter_employeAction(Request $request){
         $employe = new Employe;

         $userManager = $this->get('fos_user.user_manager'); 
         $user = $userManager->createUser();  
         $form=$this->createFormBuilder($employe)
            ->add('departement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Departement',
               'choice_label' => 'nom',
               'required'    => false,
                'placeholder' => 'Choisir le departement',
                'empty_data'  => null))
            ->add('post', EntityType::class, array(
               'class' => 'GRHGrhBundle:Post',

               'choice_label' => 'intitule',
               'required'    => false,
                'placeholder' => 'Choisir la poste ',
                'empty_data'  => null))
          
            ->add('nom',TextType::class)
            ->add('soldeconges',TextType::class)
            ->add('prenom',TextType::class)
            ->add('username',TextType::class)
            ->add('email',TextType::class)
            ->add('address',TextType::class)
            ->add('tel',TextType::class)
            ->add('datenaissance', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('sexe',ChoiceType::class, array(
                       'choices'  => array('Homme' => 'homme','Famme' => 'femme'),
                         'expanded'=>true,
                         'multiple'=>false	))
            ->add('nationalite',TextType::class)
            ->add('salaire',TextType::class)
            ->add('etatcivil',ChoiceType::class, array(
                         'choices'  => array('choisir etat' => null,'Célibataire' => 'celibataire','Marié' => 'marie'),
                         	))
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             
           
             $form->handleRequest($request);
            // $form1->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
          	 $user->setEmail($employe->getEmail()) ;
             $user->setUsername($employe->getUsername()) ;
             $user->setPlainPassword($employe->getUsername()) ;
             $role = array('ROLE_EMPLOYE');
             $user->setRoles($role) ;
             $user->setEnabled(true) ;
             $user->setSuperAdmin(false) ;

              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $em->persist($employe);
              $em->persist($user);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('employe');
    }
    
           
		return $this->render('GRHGrhBundle:Employe:ajouter_employe.html.twig',array('form' => $form->createView()));
	}


	public function supp_employeAction($id){
    	$em = $this->getDoctrine()->getManager();
      $userManager = $this->get('fos_user.user_manager');
        
        $employe = $em->getRepository('GRHGrhBundle:Employe')->find($id);
        if (!$employe) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
         $user=$em->getRepository('UserUserBundle:User')->findOneByEmail($employe->getEmail());
        $em->remove($user);
        
        $em->remove($employe);
        $em->flush();
        return $this->redirectToRoute('employe');
    

    }
   public function modif_employeAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        $employe = $em->getRepository('GRHGrhBundle:Employe')->find($id);
        if (!$employe) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $user=$em->getRepository('UserUserBundle:User')->findOneByEmail($employe->getEmail());
         $form=$this->createFormBuilder($employe)
               ->add('departement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Departement',
               'choice_label' => 'nom',
               'required'    => false,
                'placeholder' => 'Choisir le departement',
                'empty_data'  => null))
            ->add('post', EntityType::class, array(
               'class' => 'GRHGrhBundle:Post',

               'choice_label' => 'intitule',
               'required'    => false,
                'placeholder' => 'Choisir la poste ',
                'empty_data'  => null))
           ->add('username',TextType::class)
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('email',TextType::class)
            ->add('address',TextType::class)
            ->add('tel',TextType::class)
            ->add('datenaissance', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
             ->add('salaire',TextType::class)
            ->add('sexe',ChoiceType::class, array(
                       'choices'  => array('Homme' => 'homme','Famme' => 'femme'),
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
          	 
              $user->setEmail($employe->getEmail());
              $user->setUsername($employe->getUsername());
              $userManager->updateUser($user);
              
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('employe');
    }
       return $this->render('GRHGrhBundle:Employe:modif_employe.html.twig',array('form' => $form->createView(),'employe'=>$employe)); 

   }

   public function profil_employeAction(Request $request,$id){
   	    $em = $this->getDoctrine()->getManager();
   	    $employe = $em->getRepository('GRHGrhBundle:Employe')->find($id);
        if (!$employe) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
         $user=$em->getRepository('UserUserBundle:User')->findOneByEmail($employe->getEmail());
         return $this->render('GRHGrhBundle:Employe:profil_employe.html.twig',array('employe'=>$employe,'user'=>$user)); 
   }
}