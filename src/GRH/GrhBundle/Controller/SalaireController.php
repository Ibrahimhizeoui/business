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
use GRH\GrhBundle\Entity\Salaire;
use GRH\GrhBundle\Entity\Absence;
use UserUserBundle\Entity\User;

class SalaireController extends Controller
{
      public function salairesAction(){
      	$em=$this->getDoctrine()->getManager();
      	$salaires=$em->getRepository('GRHGrhBundle:Salaire')->findAll();
      	return $this->render('GRHGrhBundle:salaire:salaires.html.twig',array('salaires' => $salaires ));
      }
      public function ajouter_salaireAction(){
      	$em = $this->getDoctrine()->getManager();

        $employes = $em->getRepository('GRHGrhBundle:Employe')->findAll();

        return $this->render('GRHGrhBundle:Salaire:ajouter_salaire.html.twig', array(
            'employes' => $employes,
        ));

      }
      public function creer_salaireAction(Request $request,$id){
      		$em = $this->getDoctrine()->getManager();
      		$employe=$em->getRepository('GRHGrhBundle:Employe')->find($id);
		if (!$employe) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $user=$em->getRepository('UserUserBundle:User')->findOneByEmail($employe->getEmail());
            $absences=$em->getRepository('GRHGrhBundle:Absence')->nbabsencesmois($id);
            $nbabsences=$em->getRepository('GRHGrhBundle:Absence')->nbabsences($id);
            
        $salaire= new Salaire;
		$form=$this->createFormBuilder($salaire)
		->add('datepay', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
    ->add('montans', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
          	 
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $salaire->setEmploye($employe);
              $salaire->setNbjours($nbabsences);
              
             
              $em->persist($salaire);
              $em->flush();
              
             return $this->redirectToRoute('salaires');
    }
        return $this->render('GRHGrhBundle:Salaire:creer_salaire.html.twig', array(
            'employe' => $employe,'absences' => $absences,'nbabsences' => $nbabsences
            ,'form' => $form->createView(),'user'=>$user
        ));
      	}
}