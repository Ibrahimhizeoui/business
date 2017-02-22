<?php

namespace STOCK\StockBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use STOCK\StockBundle\Entity\Categorie;
use STOCK\StockBundle\Entity\Produit;
use STOCK\StockBundle\Entity\LigneBonreception;




class ProduitController extends Controller
{
	public function produitsAction(){
		$em=$this->getDoctrine()->getManager();
		$produits=$em->getRepository('STOCKStockBundle:Produit')->findAll();
		return $this->render('STOCKStockBundle:produit:produits.html.twig',array('produits'=>$produits));
	}

	public function ajouter_produitAction(Request $request){
		$produit= new Produit;
		$form=$this->createFormBuilder($produit)
    ->add('categorie', EntityType::class, array(
                  'class' => 'STOCKStockBundle:Categorie',
                  'choice_label' => 'categorie',
                  'attr' => array(
                  'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1')))
           
		->add('intitule',TextType::class)
            ->add('prixunitaire',TextType::class)
            ->add('quantite',TextType::class)
            ->add('quantitemin',TextType::class)
            ->add('description',TextareaType::class)
            ->add('type',TextType::class)
            ->add('dateajout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
           
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() ) {
          	
              $em = $this->getDoctrine()->getManager();
              $em->persist($produit);
             
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('produits');}
             return $this->render('STOCKStockBundle:produit:ajouter_produit.html.twig',array('form'=>$form->createView()));
             
	}

	public function modif_produitAction(Request $request,$id){
		$em=$this->getDoctrine()->getManager();
		$produit=$em->getRepository('STOCKStockBundle:Produit')->find($id);
		if (!$produit) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $form=$this->createFormBuilder($produit)
    ->add('categorie', EntityType::class, array(
                  'class' => 'STOCKStockBundle:Categorie',
                  'choice_label' => 'categorie',
                  'attr' => array(
                  'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1')))
    
		->add('intitule',TextType::class)
            ->add('prixunitaire',TextType::class)
            ->add('quantite',TextType::class)
            ->add('quantitemin',TextType::class)
            ->add('description',TextareaType::class)
            ->add('type',TextType::class)
            ->add('dateajout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'MM-dd-yyyy'))
           
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
          	
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('produits');

	              }
            return $this->render('STOCKStockBundle:produit:modif_produit.html.twig',array('form'=>$form->createView()));

	          }

	         public function supp_produitAction($id){
	         	$em=$this->getDoctrine()->getManager();
		        $produit=$em->getRepository('STOCKStockBundle:Produit')->find($id);
		        if (!$produit) {
                 throw $this->createNotFoundException('No guest found for id '.$id);
                        }
                        $em->remove($produit);
                  $em->flush();
             
               return $this->redirectToRoute('produits');

	         }

           public function detail_produitAction($id){
            $em=$this->getDoctrine()->getManager();
            $produit=$em->getRepository('STOCKStockBundle:Produit')->find($id);
            if (!$produit) {
                 throw $this->createNotFoundException('No guest found for id '.$id);
                        }
            $cesbons=$em->getRepository('STOCKStockBundle:Lignebonreception')->findByProduit($id);
            $cescoms=$em->getRepository('STOCKStockBundle:Lignecommande')->findBy(array('produit'=>$id),array('datecom' => 'DESC'));
            return $this->render('STOCKStockBundle:produit:detail_produit.html.twig',array('produit'=>$produit,'cesbons'=>$cesbons,'cescoms'=>$cescoms));


           }
            public function danger_stockAction(){
              $em=$this->getDoctrine()->getManager();
              $produit=$em->getRepository('STOCKStockBundle:Produit')->danger_stock();
              $response = new JsonResponse();
              return $response->setData(array('produit'=>$produit));
            }
}

