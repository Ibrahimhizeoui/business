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
use STOCK\StockBundle\Entity\Produit;
use STOCK\StockBundle\Entity\Fournisseur;




class FournisseurController extends Controller
{
	public function fournisseursAction(){
		$em=$this->getDoctrine()->getManager();
		$fournisseurs=$em->getRepository('STOCKStockBundle:Fournisseur')->findAll();
		return $this->render('STOCKStockBundle:fournisseur:fournisseurs.html.twig',array('fournisseurs'=>$fournisseurs));
	}

	public function ajouter_fournisseurAction(Request $request){
		$fournisseur= new Fournisseur;
		$form=$this->createFormBuilder($fournisseur)
		->add('nom',TextType::class)
            ->add('tel',TextType::class)
            ->add('fax',TextType::class)
            ->add('email',TextType::class)
            ->add('adress',TextareaType::class)
            
           
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
          	
              $em = $this->getDoctrine()->getManager();
              $em->persist($fournisseur);
             
              $em->flush();
              //var_dump($employe);
             //return $this->redirectToRoute('fournisseurs');
           }
             return $this->render('STOCKStockBundle:fournisseur:ajouter_fournisseur.html.twig',array('form'=>$form->createView()));
             
	}

	public function modif_fournisseurAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$fournisseur=$em->getRepository('STOCKStockBundle:Fournisseur')->find($id);
		if (!$fournisseur) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $form=$this->createFormBuilder($fournisseur)
		->add('nom',TextType::class)
            ->add('tel',TextType::class)
            ->add('fax',TextType::class)
            ->add('email',TextType::class)
            ->add('adress',TextareaType::class)
            
           
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
          	
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('fournisseurs');

	              }
            return $this->render('STOCKStockBundle:fournisseur:modif_fournisseur.html.twig',array('form'=>$form->createView()));

	          }

	         public function supp_fournisseurAction($id){
	         	$em=$this->getDoctrine()->getManager();
		        $fournisseur=$em->getRepository('STOCKStockBundle:Produit')->find($id);
		        if (!$fournisseur) {
                 throw $this->createNotFoundException('No guest found for id '.$id);
                        }
                        $em->remove($fournisseur);
                  $em->flush();
             
               return $this->redirectToRoute('produits');

	         }
}

