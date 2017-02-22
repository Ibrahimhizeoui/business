<?php

namespace GRH\GrhBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use GRH\GrhBundle\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
	/***************************** Show POST ******************************/
        public function indexAction(){
    	$em = $this->getDoctrine()->getManager();

        $postes = $em->getRepository('GRHGrhBundle:Post')->findAll();

        return $this->render('GRHGrhBundle:Post:index.html.twig', array(
            'postes' => $postes,
        ));

      }
    /***************************** End show POST ******************************/




	/***************************** Ajouter POST ******************************/
     public function ajouter_postAction(Request $request){
     	$post= new Post;
     	$form=$this->createFormBuilder($post)
     	    ->add('departement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Departement',
               'choice_label' => 'nom',

               
               'required'    => true,
                'placeholder' => 'Choisir le responsable',
                'empty_data'  => null))
     	    ->add('intitule',TextType::class)
     	    ->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            
            ->add('salaire',TextType::class)
            
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Occupé' => 'occupe','Libre' => 'libre'),
                         'expanded'=>true,
                         'multiple'=>false	))
            
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

            ->getForm();
             $form->handleRequest($request);
            
             if ($form->isSubmitted() && $form->isValid()) {
             //var_dump($post);
           	  
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($post);
              $em->flush();
              
             return $this->redirectToRoute('postes'); 
          }
            
        return $this->render('GRHGrhBundle:Post:ajouter_post.html.twig',array('form' => $form->createView()));

     }
    /***************************** END Ajouter POST ******************************/


   
    /***************************** Supp POST ******************************/
       public function supp_postAction($id){
       	  $em= $this->getDoctrine()->getManager();
       	  $post= $em->getRepository('GRHGrhBundle:Post')->find($id);
       	  if (!$post) {
       	  	# code...
       	  	 throw $this->createNotFoundException('No guest found for id '.$id);
       	  }
           $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('postes');
       }
	/***************************** END supp POST ******************************/
    


    /***************************** modif POST ******************************/
        public function modif_postAction(Request $request,$id){
        	$em= $this->getDoctrine()->getManager();
       	    $post= $em->getRepository('GRHGrhBundle:Post')->find($id);
       	    if (!$post) {
       	  	# code...
       	  	 throw $this->createNotFoundException('No guest found for id '.$id);
       	    }
       	    $form=$this->createFormBuilder($post)
       	     ->add('departement', EntityType::class, array(
               'class' => 'GRHGrhBundle:Departement',
               'choice_label' => 'nom',
               
               'required'    => true,
                'placeholder' => 'Choisir le responsable',
                'empty_data'  => null))
     	    ->add('intitule',TextType::class)
     	    ->add('debut', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('fin', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            
            ->add('salaire',TextType::class)
            
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Occupé' => 'occupe','Libre' => 'libre'),
                         'expanded'=>true,
                         'multiple'=>false	))
            
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

            ->getForm();
             $form->handleRequest($request);
            
             if ($form->isSubmitted() && $form->isValid()) {
              
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($post);
              $em->flush();
              
             return $this->redirectToRoute('postes'); 
          }

        return $this->render('GRHGrhBundle:Post:modif_post.html.twig',array('form' => $form->createView(),'post'=>$post)); 
        }
    /***************************** END modif POST ******************************/


    /***************************** detail POST ******************************/
       public function detail_postAction($id){
          $em= $this->getDoctrine()->getManager();
          $post= $em->getRepository('GRHGrhBundle:Post')->find($id);
          $employe= $em->getRepository('GRHGrhBundle:Employe')->findOneByPost($id);
          
          if (!$post) {
            # code...
             throw $this->createNotFoundException('No guest found for id '.$id);
          }
          

          return $this->render('GRHGrhBundle:Post:detail_post.html.twig',array('post'=>$post,'employe'=>$employe)); 
       
       }
    /***************************** END detail POST ******************************/
      
   
}
