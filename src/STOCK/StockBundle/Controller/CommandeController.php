<?php

namespace STOCK\StockBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use STOCK\StockBundle\Entity\Categorie;
use STOCK\StockBundle\Entity\Commande;
use STOCK\StockBundle\Entity\Produit;
use STOCK\StockBundle\Entity\Fournisseur;
use STOCK\StockBundle\Entity\Lignecommande;

use STOCK\StockBundle\Entity\FPDF;
use STOCK\StockBundle\Entity\PDF_Invoice;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CommandeController extends Controller
{
  public function pdfventeAction(Request $request,$id) {

    //................//
    
//require('PDF_Invoice.php');
  
 $em=$this->getDoctrine()->getManager();
            $commande= $em->getRepository('STOCKStockBundle:Commande')->find($id);
            if (!$commande) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $cesligne=$em->getRepository('STOCKStockBundle:Lignecommande')->findByCommande($id);

$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete( "MaSociete",
                  "MonAdresse\n" .
                  "75000 PARIS\n".
                  "R.C.S. PARIS B 000 000 007\n" .
                  "Capital : 18000 " . EURO );
$pdf->fact_dev( "Devis ", "TEMPO" );
//$pdf->temporaire( "Devis temporaire" );
$pdf->addDate(date('d M Y'));
$pdf->addClient($commande->getClient()->getNom());
$pdf->addPageNumber("1");
$pdf->addClientAdresse($commande->getClient()->getAdress());
$pdf->addReglement("Chèque a reception de facture");
$pdf->addEcheance(".............");
$pdf->addNumTVA("FR888777666");
$pdf->addReference("Devis ... du ....");
$cols=array( "REFERENCE"    => 23,
             "DESIGNATION"  => 78,
             "QUANTITE"     => 22,
             "P.U. HT"      => 26,
             "MONTANT H.T." => 30,
             "TVA"          => 11 );
$pdf->addCols( $cols);
$cols=array( "REFERENCE"    => "L",
             "DESIGNATION"  => "L",
             "QUANTITE"     => "C",
             "P.U. HT"      => "R",
             "MONTANT H.T." => "R",
             "TVA"          => "C" );
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
$y    = 109;
foreach ($cesligne as $lign) {
  # code...
  $line = array( "REFERENCE"    => '#'.$lign->getId(),
               "DESIGNATION"  => $lign->getProduit()->getIntitule(),
               "QUANTITE"     => $lign->getQuantite(),
               "P.U. HT"      => $lign->getProduit()->getPrixunitaire(),
               "MONTANT H.T." => $lign->getProduit()->getPrixunitaire(),
               "TVA"          => "1" );
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

}



$pdf->addCadreTVAs();
        
$tot_prods = array( array ( "px_unit" => $commande->getMontans(), "qte" => 1, "tva" => 1 ),
                    );
$tab_tva = array( "1"       => 18,
                  "2"       => 5.5);
$params  = array( "RemiseGlobale" => 1,
                      "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                      "remise"         => 0,       // {montant de la remise}
                      "remise_percent" => $commande->getRemise(),      // {pourcentage de remise sur ce montant de TVA}
                  "FraisPort"     => 1,
                      "portTTC"        => 0,      // montant des frais de ports TTC
                                                   // par defaut la TVA = 19.6 %
                      "portHT"         => 0,       // montant des frais de ports HT
                      "portTVA"        => 18,    // valeur de la TVA a appliquer sur le montant HT
                  "AccompteExige" => 1,
                      "accompte"         => 0,     // montant de l'acompte (TTC)
                      "accompte_percent" => 0,    // pourcentage d'acompte (TTC)
                  "Remarque" => "Avec un acompte, svp..." );

$pdf->addTVAs( $params, $tab_tva, $tot_prods);
//$pdf->addCadreEurosFrancs();

$filename="./pdf/test5.pdf";
$pdf->Output($filename,'F');
$response = new Response(
        $pdf->Output(),
        Response::HTTP_OK,
        array('content-type' => 'application/pdf')
    );

    $d = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'vente.pdf'
    );

    $response->headers->set('Content-Disposition', $d);

    return $response;
}
     public function commandesAction(){
      $em=$this->getDoctrine()->getManager();
        $commandes= $em->getRepository('STOCKStockBundle:Commande')->findAll();
        
       return $this->render('STOCKStockBundle:commande:commandes.html.twig',array('commandes'=>$commandes));
      
     }
	   public function commande_venteAction(){
	   	$em=$this->getDoctrine()->getManager();
        $commande= new Commande;
        $em->persist($commande);
        $em->flush();
        //var_dump($commande->getId());        
        return $this->redirectToRoute('ajouter_commande_vente', array('id'=>$commande->getId()), 301);}



    public function ajouter_commande_venteAction(Request $request,$id){
       	$em=$this->getDoctrine()->getManager();
        $commande= $em->getRepository('STOCKStockBundle:Commande')->find($id);
         $ceslignes=$em->getRepository('STOCKStockBundle:Lignecommande')->findByCommande($id);
       	$lignecom= new Lignecommande;
        $form=$this->createFormBuilder($commande,array('csrf_protection' => false))
       	     ->add('montans',TextType::class)
             ->add('typelivraison',TextType::class)
             ->add('remise',TextType::class)
            
            ->add('dateajout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Accepter' => 'accepter','Brouillon' => 'brouillon'),
                          ))
            
            ->add('client', EntityType::class, array(
               'class' => 'CRMCrmBundle:Client',
               'choice_label' => 'nom',
                'attr' => array(
                   'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1')))
           
             ->add('ccc', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             $form->handleRequest($request);
             
             $form2=$this->createFormBuilder($lignecom, array('csrf_protection' => false))
          	->add('quantite',TextType::class)
            
            
            
            
            ->add('produit', EntityType::class, array(
               'class' => 'STOCKStockBundle:Produit',
               'choice_label' => 'intitule',
                'attr' => array(
                   'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1',
                   )
 
               ))
            
           
             ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))

             ->getForm();
             $form2->handleRequest($request);
             
             if ($form2->isSubmitted() && $form2->isValid()) {
              $lignecom->setCommande($commande);
               $produit=$em->getRepository('STOCKStockBundle:Produit')->find($lignecom->getProduit()->getId());
              
              if ($produit->getQuantite() < $lignecom->getQuantite()) {
                //throw $this->createNotFoundException('La commande ne peut pas passer');

              $response = new JsonResponse();
              return $response->setData(array('status'=>'block','q'=>$produit->getQuantite()));
              }
            else{
              $produit->setQuantite($produit->getQuantite()-$lignecom->getQuantite());
              $lignecom->setTotal($lignecom->getQuantite() * $lignecom->getProduit()->getPrixunitaire() );
              $lignecom->setPstock('nn_stock');
              //$em = $this->getDoctrine()->getManager();
              $em->persist($lignecom);
             
              $em->flush();
              }
            

          	  $response = new JsonResponse();
               return $response;
              //return $this->redirectToRoute('ajouter_commande_achat', array('id'=>$commande->getId()), 301);
          }

          if ($form->isSubmitted() && $form->isValid()) {
              if ($commande->getStatus()=='accepter') {
                foreach ($ceslignes as $ligne) {
                  if ($ligne->getPstock()!='stocke') {
                     $prod=$ligne->getProduit();
                  $x=$prod->getQuantite();
                  $prod->setQuantite($x-$ligne->getQuantite());
                  $ligne->setPstock('stocke');
                  $em->flush();
                 
                    # code...
                  }
                  //var_dump($prod);
                  # code...
                }
                }
              $em = $this->getDoctrine()->getManager();
              $em->flush();
             
              //return $this->redirectToRoute('ajouter_commande_achat', array('id'=>$commande->getId()), 301);
            return $this->redirectToRoute('commandes');
          }
    $produit= new Produit;
    $form3=$this->createFormBuilder($produit)
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
             $form3->handleRequest($request);
             if ($form3->isSubmitted() ) {
            
              $em = $this->getDoctrine()->getManager();
              $em->persist($produit);
             
              $em->flush();
              $response = new JsonResponse();
               return $response;
              
              //var_dump($employe);
             }
    
             
              
       	return $this->render('STOCKStockBundle:commande:ajouter_commande_vente.html.twig',array('id'=>$id,'ceslignes'=>$ceslignes,'commande'=>$commande,'form2'=>$form2->createView(),'form'=>$form->createView()
          ,'form3'=>$form3->createView()));
       }

       public function supp_ligneAction(){
        if (isset($_POST['id'])) {
        $id=$_POST['id'];
        $em=$this->getDoctrine()->getManager();
        $cesligne=$em->getRepository('STOCKStockBundle:Lignecommande')->find($id);
        if (!$cesligne) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $em->remove($cesligne);
        $em->flush();
        $response = new JsonResponse();
        return $response;
    
        # code...
      }
         	}



       public function modif_commandeAction(Request $request,$id){
            $em=$this->getDoctrine()->getManager();
            $commande=$em->getRepository('STOCKStockBundle:Commande')->find($id);
            if (!$commande) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $ceslignes=$em->getRepository('STOCKStockBundle:Lignecommande')->findByCommande($id);
            $form=$this->createFormBuilder($commande,array('csrf_protection' => false))
             ->add('montans',TextType::class)
             ->add('typelivraison',TextType::class)
             ->add('remise',TextType::class)
            
            ->add('dateajout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('status',ChoiceType::class, array(
                       'choices'  => array('Accepter' => 'accepter','Brouillon' => 'brouillon'),
                          ))
            
            ->add('client', EntityType::class, array(
               'class' => 'CRMCrmBundle:Client',
               'choice_label' => 'nom',
                'attr' => array(
                   'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1')))
           
           
             ->add('ccc', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
             $form->handleRequest($request);
             $lignecom= new Lignecommande;
             $form2=$this->createFormBuilder($lignecom, array('csrf_protection' => false))
            ->add('quantite',TextType::class)
            ->add('datecom', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            
            
            ->add('produit', EntityType::class, array(
               'class' => 'STOCKStockBundle:Produit',
               'choice_label' => 'intitule',
                'attr' => array(
                   'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1',
                   )
 
               ))
            
           
             ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))

             ->getForm();
             $form2->handleRequest($request);
             
             if ($form2->isSubmitted() && $form2->isValid()) {
              $lignecom->setCommande($commande);
               $produit=$em->getRepository('STOCKStockBundle:Produit')->find($lignecom->getProduit()->getId());
              
              if ($produit->getQuantite() < $lignecom->getQuantite()) {
                //throw $this->createNotFoundException('La commande ne peut pas passer');

              $response = new JsonResponse();
              return $response->setData(array('status'=>'block','q'=>$produit->getQuantite()));
              }
            else{
              $produit->setQuantite($produit->getQuantite()-$lignecom->getQuantite());
              $lignecom->setTotal($lignecom->getQuantite() * $lignecom->getProduit()->getPrixunitaire() );
              $lignecom->setPstock('nn_stock');
              //$em = $this->getDoctrine()->getManager();
              $em->persist($lignecom);
             
              $em->flush();
              }
            

              $response = new JsonResponse();
               return $response;
              //return $this->redirectToRoute('ajouter_commande_achat', array('id'=>$commande->getId()), 301);
            }
             if ($form->isSubmitted() && $form->isValid()) {
            
              $em = $this->getDoctrine()->getManager();
              $em->flush();
             
              //return $this->redirectToRoute('ajouter_commande_achat', array('id'=>$commande->getId()), 301);
            return $this->redirectToRoute('commandes');
              }
            $produit= new Produit;
    $form3=$this->createFormBuilder($produit)
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
             $form3->handleRequest($request);
             if ($form3->isSubmitted() ) {
            
              $em = $this->getDoctrine()->getManager();
              $em->persist($produit);
             
              $em->flush();
              $response = new JsonResponse();
               return $response;
              
              //var_dump($employe);
             }
    
             
              
        return $this->render('STOCKStockBundle:commande:modif_commande.html.twig',array('id'=>$id,'ceslignes'=>$ceslignes,'commande'=>$commande,'form2'=>$form2->createView(),'form'=>$form->createView()
          ,'form3'=>$form3->createView()));
    }

        



 public function supp_commandeAction($id){
          $em=$this->getDoctrine()->getManager();
            $commande=$em->getRepository('STOCKStockBundle:Commande')->find($id);
            if (!$commande) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $em->remove($commande);
            $em->flush();
            return $this->redirectToRoute('commandes');
        }
public function detail_commandeAction($id){
               $em=$this->getDoctrine()->getManager();
               $commande=$em->getRepository('STOCKStockBundle:Commande')->find($id);
                if (!$commande) {
                throw $this->createNotFoundException('No guest found for id '.$id);}
                 $ceslignes=$em->getRepository('STOCKStockBundle:Lignecommande')->findByCommande($id);
                return $this->render('STOCKStockBundle:commande:detail_commande.html.twig',array('ceslignes'=>$ceslignes,'commande'=>$commande));
        }
public function accepter_commandeAction($id){
               $em=$this->getDoctrine()->getManager();
               $commande=$em->getRepository('STOCKStockBundle:Commande')->find($id);
                if (!$commande) {
                throw $this->createNotFoundException('No guest found for id '.$id);}
                 $commande->setStatus('Accepter');
                 $em->flush();
                 return $this->redirectToRoute('detail_commande',array('id' => $id));
               
        }
public function ceslignesAction($id){
    $em=$this->getDoctrine()->getManager();
    $cesligne=$em->getRepository('STOCKStockBundle:Lignecommande')->findByCommande($id);
    if (isset($_POST['xid'])) {
          $cesligne=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->find($id);
          if (!$cesligne) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $em->remove($cesligne);
    $em->flush();
    $response = new JsonResponse();
    return $response;
                     }
    return $this->render('STOCKStockBundle:commande:ceslignes.html.twig',
              array('cesligne'=>$cesligne));
       
                      }            
        



}