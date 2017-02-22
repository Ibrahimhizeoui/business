<?php

namespace STOCK\StockBundle\Controller;
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
use STOCK\StockBundle\Entity\Categorie;




class CategorieController extends Controller
{
    public function categoriesAction()
    {
    	$em=$this->getDoctrine()->getManager();
    	$categories=$em->getRepository('STOCKStockBundle:Categorie')->findAll();
        return $this->render('STOCKStockBundle:categorie:categories.html.twig',array('categories'=>$categories));
    }

    public function ajouter_categorieAction(Request $request){
    	$catgorie=new Categorie;
    	$form=$this->createFormBuilder($catgorie)
    	->add('categorie',TextType::class)
    	->add('parentcategorie', EntityType::class, array(
               'class' => 'STOCKStockBundle:Categorie',
               'choice_label' => 'categorie',
               'placeholder' => 'Choisir une categorie',
               'empty_data'  => null,
               'required' => false))


    	->add('save', SubmitType::class, array('label' => 'Enregistrer'))
    	->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          	
              $em = $this->getDoctrine()->getManager();
              $em->persist($catgorie);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('categories');
        }
        return $this->render('STOCKStockBundle:categorie:ajouter_categorie.html.twig', array('form' => $form->createView() ));
    
        }


        public function modif_categorieAction(Request $request,$id){
        	$em = $this->getDoctrine()->getManager();
    	$catgorie=$em->getRepository('STOCKStockBundle:Categorie')->find($id);
    	
        if (!$catgorie) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
    	$form=$this->createFormBuilder($catgorie)
    	->add('categorie',TextType::class)
    	->add('parentcategorie', EntityType::class, array(
               'class' => 'STOCKStockBundle:Categorie',
               'choice_label' => 'categorie',
               'placeholder' => 'Choisir une categorie',
               'empty_data'  => null,
               'required' => false))


    	->add('save', SubmitType::class, array('label' => 'Enregistrer'))
    	->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          	
              
              $em->persist($catgorie);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('categories');
        }
        return $this->render('STOCKStockBundle:categorie:modif_categorie.html.twig', array('form' => $form->createView() ));
    
        }

        public function supp_categorieAction($id){
        	$em = $this->getDoctrine()->getManager();
    	    $catgorie=$em->getRepository('STOCKStockBundle:Categorie')->find($id);
    	    
        if (!$catgorie) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
           $em->remove($catgorie);
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('categories');

        }


}
