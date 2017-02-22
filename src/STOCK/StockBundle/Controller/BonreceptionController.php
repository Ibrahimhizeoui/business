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
use STOCK\StockBundle\Entity\Bonreception;
use STOCK\StockBundle\Entity\Lignebonreception;
use STOCK\StockBundle\Entity\FPDF;
use STOCK\StockBundle\Entity\PDF_Invoice;

 use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;



class BonreceptionController extends Controller
{

public function pdfAction(Request $request,$id) {

    //................//
    
//require('PDF_Invoice.php');
  
 $em=$this->getDoctrine()->getManager();
            $bonreception= $em->getRepository('STOCKStockBundle:Bonreception')->find($id);
            if (!$bonreception) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $ceslignes=$em->getRepository('STOCKStockBundle:Lignebonreception')->findByBonreception($id);

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
$pdf->addClient($bonreception->getFournisseur()->getNom());
$pdf->addPageNumber("1");
$pdf->addClientAdresse($bonreception->getFournisseur()->getAdress());
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
foreach ($ceslignes as $lign) {
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
        
// invoice = array( "px_unit" => value,
//                  "qte"     => qte,
//                  "tva"     => code_tva );
// tab_tva = array( "1"       => 19.6,
//                  "2"       => 5.5, ... );
// params  = array( "RemiseGlobale" => [0|1],
//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
//                      "remise"         => value,     // {montant de la remise}
//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
//                  "FraisPort"     => [0|1],
//                      "portTTC"        => value,     // montant des frais de ports TTC
//                                                     // par defaut la TVA = 19.6 %
//                      "portHT"         => value,     // montant des frais de ports HT
//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
//                  "AccompteExige" => [0|1],
//                      "accompte"         => value    // montant de l'acompte (TTC)
//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
//                  "Remarque" => "texte"              // texte
$tot_prods = array( array ( "px_unit" => $bonreception->getMontans(), "qte" => 1, "tva" => 1 ),
                    );
$tab_tva = array( "1"       => 18,
                  "2"       => 5.5);
$params  = array( "RemiseGlobale" => 1,
                      "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                      "remise"         => 0,       // {montant de la remise}
                      "remise_percent" => $bonreception->getRemise(),      // {pourcentage de remise sur ce montant de TVA}
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

//$filename="./pdf/test.pdf";
//$pdf->Output($filename,'F');
$response = new Response(
        $pdf->Output(),
        Response::HTTP_OK,
        array('content-type' => 'application/pdf')
    );

    $d = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'foo.pdf'
    );

    $response->headers->set('Content-Disposition', $d);

    return $response;
}
     public function bonreceptionsAction(){
        $em=$this->getDoctrine()->getManager();
        $receptions= $em->getRepository('STOCKStockBundle:Bonreception')->findByTypelivraison('commande d\'achat');
        return $this->render('STOCKStockBundle:bonreception:liste_commande_achat.html.twig',array('receptions'=>$receptions)); }

    public function bonreceptions2Action(){
        $em=$this->getDoctrine()->getManager();
        $receptions= $em->getRepository('STOCKStockBundle:Bonreception')->findByTypelivraison('bonreception');
        return $this->render('STOCKStockBundle:bonreception:bonreceptions.html.twig',array('receptions'=>$receptions)); }

	 public function bon_receptionAction(){
	   	$em=$this->getDoctrine()->getManager();
        $bonreception= new Bonreception;
        $bonreception->setStatus('cc');
        $em->persist($bonreception);
        $em->flush();
        //var_dump($commande->getId());        
        return $this->redirectToRoute('ajouter_bon_reception', array('id'=>$bonreception->getId()), 301);}
     
     public function ajouter_bon_receptionAction(Request $request,$id){
            $em=$this->getDoctrine()->getManager();
            $bonreception= $em->getRepository('STOCKStockBundle:Bonreception')->find($id);
            if (!$bonreception) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $ceslignes=$em->getRepository('STOCKStockBundle:Lignebonreception')->findByBonreception($id);


            $form=$this->createFormBuilder($bonreception,array('csrf_protection' => false))
             ->add('montans',TextType::class)
             ->add('remise',TextType::class)
             //->add('',TextType::class)
             ->add('dateajout', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('typelivraison',ChoiceType::class, array(
                    'choices'  => array('Bon reception' => 'bonreception','Commande d\'achat' => 'commande d\'achat'), ))
            ->add('status',ChoiceType::class, array(
                    'choices'  => array('Affecter' => 'affecter','Non affecter' => 'affecter'), ))
            ->add('etat',ChoiceType::class, array(
                    'choices'  => array('Livré' => 'livre','Non Livré' => 'nonlivre'), ))
            ->add('fournisseur', EntityType::class, array(
                  'class' => 'STOCKStockBundle:Fournisseur',
                  'choice_label' => 'nom',
                  'attr' => array(
                  'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1')))
           
             ->add('ccc', SubmitType::class, array('label' => 'Enregistrer'))

             ->getForm();
            $form->handleRequest($request);

            $lignerecep= new Lignebonreception;
            $form2=$this->createFormBuilder($lignerecep, array('csrf_protection' => false))
            ->add('quantite',TextType::class)
            ->add('datebon', DateType::class, array(
                   'input'  => 'datetime',
                   'widget' => 'single_text',
                   'format' => 'yyyy-MM-dd'))
            ->add('produit', EntityType::class, array(
               'class' => 'STOCKStockBundle:Produit',
               'choice_label' => 'intitule',
                'attr' => array(
                   'class' => 'js-example-basic-single js-states form-control',
                   'tabindex'=>'-1', )))
            ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form2->handleRequest($request);
            if ($form2->isSubmitted() && $form2->isValid()) {
              $lignerecep->setBonreception($bonreception);
              $x= $lignerecep->getProduit()->getPrixunitaire() * $lignerecep->getQuantite() ;
              $lignerecep->setTotal($x);
              $em = $this->getDoctrine()->getManager();
              $lignerecep->SetPstock('nn_stock');
              $em->persist($lignerecep);
              $em->flush();
              $response = new JsonResponse();
              return $response;
              //return $this->redirectToRoute('ajouter_commande_achat', array('id'=>$commande->getId()), 301);
              }
              if ($form->isSubmitted() && $form->isValid()) {
              if ($bonreception->getEtat()=='livre') {
                foreach ($ceslignes as $ligne) {
                  if ($ligne->getPstock()!='stocke') {
                     $prod=$ligne->getProduit();
                  $x=$prod->getQuantite();
                  $prod->setQuantite($x+$ligne->getQuantite());
                  $ligne->setPstock('stocke');
                  $em->flush();
                 
                    # code...
                  }
                  //var_dump($prod);
                  # code...
                }
                }
              //$em = $this->getDoctrine()->getManager();
              $em->flush();
             
              //return $this->redirectToRoute('ajouter_commande_achat', array('id'=>$commande->getId()), 301);
            return $this->redirectToRoute('bonreceptions');
              }


              $ceslignes=$em->getRepository('STOCKStockBundle:Lignebonreception')->findByBonreception($id);
              return $this->render('STOCKStockBundle:bonreception:ajouter_bon_reception.html.twig',array('id'=>$id,'ceslignes'=>$ceslignes,'bonreception'=>$bonreception,'form2'=>$form2->createView(),'form'=>$form->createView()));}
     public function supp_bonreceptionAction($id){
            $em=$this->getDoctrine()->getManager();
            $bonreception= $em->getRepository('STOCKStockBundle:Bonreception')->find($id);
            if (!$bonreception) {
            throw $this->createNotFoundException('No guest found for id '.$id);}

            $em->remove($bonreception);
            $em->flush();
            $em->remove();
            return $this->redirectToRoute('bonreceptions'); }
     public function detail_bonreceptionAction(Request $request,$id){
            $em=$this->getDoctrine()->getManager();
            $reception= $em->getRepository('STOCKStockBundle:Bonreception')->find($id);
            if (!$reception) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
            $ceslignes=$em->getRepository('STOCKStockBundle:Lignebonreception')->findByBonreception($id);

            return $this->render('STOCKStockBundle:bonreception:detail_bonreception.html.twig',array('ceslignes'=>$ceslignes,'reception'=>$reception)); 

        }
    public function ceslignesAction($id){
             $em=$this->getDoctrine()->getManager();
             $cesligne=$em->getRepository('STOCKStockBundle:Lignebonreception')->findByBonreception($id);

            return $this->render('STOCKStockBundle:bonreception:ceslignes.html.twig',
              array('cesligne'=>$cesligne));
       
                      }            
    public function supp_lignebonAction(){
        if (isset($_POST['id'])) {
        $id=$_POST['id'];
        $em=$this->getDoctrine()->getManager();
        $cesligne=$em->getRepository('STOCKStockBundle:Lignebonreception')->find($id);
       
        if (!$cesligne) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $em->remove($cesligne);
        $em->flush();
        $response = new JsonResponse();
        return $response;
    
        # code...
      }
          }

}
