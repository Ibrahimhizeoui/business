<?php

namespace COMPTABILITE\CompBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use COMPTABILITE\CompBundle\Entity\Facture;
use CRM\CrmBundle\Entity\Client;
use COMPTABILITE\CompBundle\Entity\Lignefacture;
use STOCK\StockBundle\Entity\Commande;
use STOCK\StockBundle\Entity\Produit;

use STOCK\StockBundle\Entity\FPDF;
use STOCK\StockBundle\Entity\PDF_Invoice;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class FactureController extends Controller
{

     /* This funtion is for creating an invoice format  PDF . I used FPDF Library */
     public function pdf_factureAction($id){
        $em=$this->getDoctrine()->getManager();
        $facture=$em->getRepository('COMPTABILITECompBundle:Facture')->find($id);
        if (!$facture) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $cesligne=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->findByFacture($id);
        $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
        $pdf->AddPage();
        $pdf->addSociete( "MaSociete",
                  "MonAdresse\n" .
                  "75000 PARIS\n".
                  "R.C.S. PARIS B 000 000 007\n" .
                  "Capital : 18000 " . EURO );
        $pdf->fact_dev( "Facture ", "TEMPO" );
       //$pdf->temporaire( "Devis temporaire" );
        $pdf->addDate(date('d M Y'));
        $pdf->addClient($facture->getClient()->getNom());
        $pdf->addPageNumber("1");
        $pdf->addClientAdresse($facture->getClient()->getAdress());
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
                $y   += $size + 2;}



               $pdf->addCadreTVAs();
                       
               $tot_prods = array( array ( "px_unit" => $facture->getTotal(), "qte" => 1, "tva" => 1 ),
                                   );
               $tab_tva = array( "1"       => 18,
                                 "2"       => 5.5);
               $params  = array( "RemiseGlobale" => 1,
                                  "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                                  "remise"         => 0,       // {montant de la remise}
                                  "remise_percent" => $facture->getRemise(),      // {pourcentage de remise sur ce montant de TVA}
                              "FraisPort"     => 1,
                                  "portTTC"        => 0,      // montant des frais de ports TTC
                                                                        // par defaut la TVA = 19.6 %
                                           "portHT"         => 0,       // montant des frais de ports HT
                               "portTVA"        =>  $facture->getTaxe()->getValeur(),    // valeur de la TVA a appliquer sur le montant HT
                           "AccompteExige" => 1,
                               "accompte"         => 0,     // montant de l'acompte (TTC)
                               "accompte_percent" => 0,    // pourcentage d'acompte (TTC)
                           "Remarque" => "Avec un acompte, svp..." );

               $pdf->addTVAs( $params, $tab_tva, $tot_prods);
               //$pdf->addCadreEurosFrancs();
               
               $filename="./pdf/facture/test5.pdf";
               $pdf->Output($filename,'F');
               $response = new Response(
                       $pdf->Output(),
                       Response::HTTP_OK,
                       array('content-type' => 'application/pdf')
                   );

                   $d = $response->headers->makeDisposition(
                       ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                       'facture.pdf'
                   );

                $response->headers->set('Content-Disposition', $d);

               return $response; }
   
     /* This function is for generating THE LISTE OF INVOICES */
     public function facturesAction(){
         $em=$this->getDoctrine()->getManager();
         $factures=$em->getRepository('COMPTABILITECompBundle:Facture')->findAll();
         return $this->render('COMPTABILITECompBundle:facture:factures.html.twig',array('factures'=>$factures));}
 
     /* This function is for saving an invoices in the data base */
   public function create_factureAction(){
    	$facture= new Facture;
    	$facture->setTypepaiment('non_payer');
    	
    	$facture->setTotal('0');
    	$facture->setDescription(' ');
    	$facture->setStatus('brouillon');
    	$facture->setEtat('non_destocker');
    	$em=$this->getDoctrine()->getManager();
		  $em->persist($facture);
		  $em->flush();
		  return $this->redirectToRoute('ajouter_facture',array('id'=>$facture->getId()));}
    
    /* This function is for sending an invoices to a client */
    public function detail_factureAction($id){
      $em=$this->getDoctrine()->getManager();
        $facture=$em->getRepository('COMPTABILITECompBundle:Facture')->find($id);
        if (!$facture) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $ceslignes=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->findByFacture($id);
        $mess= \Swift_Message::newInstance()
                     ->setSubject('Votre facture')
                     ->setFrom(array('ibrahimhizeoui@gmail.com'=>'Mkd_company'))
                     ->setTo('b-love-h@live.fr')
                     ->setCharset('utf-8')
                     ->setContentType('text/html')
                     ->setBody($this->renderView('COMPTABILITECompBundle:facture:detail_facture.html.twig',
                array('id'=>$id,'facture'=>$facture,'ceslignes'=>$ceslignes)));    
                $this->get('mailer')->send($mess);
        
        return $this->render('COMPTABILITECompBundle:facture:detail_facture.html.twig',
                array('id'=>$id,'facture'=>$facture,'ceslignes'=>$ceslignes));}
	  
    /* This function is for generating the json response  */
    public function ajouter_factureAction(Request $request,$id){
		    $em=$this->getDoctrine()->getManager();
		    $facture=$em->getRepository('COMPTABILITECompBundle:Facture')->find($id);
		    if (!$facture) {
            throw $this->createNotFoundException('No guest found for id '.$id);}

        $form=$this->createFormBuilder($facture)
                   ->add('datefacture', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   ->add('total',TextType::class)
                   ->add('remise',TextType::class)
                   ->add('description',TextType::class)
                   ->add('status',ChoiceType::class, array(
                         'choices'  => array('Brouillon' => 'brouillon','Facture' => 'facture'), ))
                   ->add('etat',ChoiceType::class, array(
                         'choices'  => array('Destockage' => 'destockage','Non destocker' => 'non_destocker'),'expanded'=>true,
                         'multiple'=>false	 ))
                   ->add('typepaiment',ChoiceType::class, array(
                         'choices'  => array('Par chéque' => 'cheque','Virement bancaire' => 'virement','Espèce' => 'espece'
                    	,'Non payer' => 'non_payer'), ))
                   ->add('client', EntityType::class, array(
                     'class' => 'CRMCrmBundle:Client',
                     'choice_label' => 'nom',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('taxe', EntityType::class, array(
                     'class' => 'COMPTABILITECompBundle:Taxe',
                     'choice_label' => 'nom',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                  $em->persist($facture);
                  $em->flush();
                 return $this->redirectToRoute('detail_facture',array('id'=>$id));}
        $lignefacture = new Lignefacture;
        $form2=$this->createFormBuilder($lignefacture)
                    ->add('quantite',TextType::class)
                    ->add('produit', EntityType::class, array(
                     'class' => 'STOCKStockBundle:Produit',
                     'choice_label' => 'intitule',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en1')))
            ->getForm();
            $form2->handleRequest($request); 
        if ($form2->isSubmitted() && $form2->isValid()) {
        	      $lignefacture->setFacture($facture);
        	      $x=$lignefacture->getQuantite() * $lignefacture->getProduit()->getPrixunitaire();
        	      $lignefacture->setTotal($x);
        	      $lignefacture->setPstock('non_destocker');
        	      

                  $em->persist($lignefacture);
                  $em->flush();
                  $response = new JsonResponse();
                  return $response;
              
                 }
             return $this->render('COMPTABILITECompBundle:facture:ajouter_facture.html.twig',
             	array('form'=>$form->createView(),'form2'=>$form2->createView(),'id'=>$id,'facture'=>$facture));}

	  /* This function is for generating THE LISTE OF PRODUCTS OF INVOICES */
     public function ceslignesfAction($id){
		   $em=$this->getDoctrine()->getManager();
		   $cesligne=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->findByFacture($id);
		       if (isset($_POST['xid'])) {
        	     $cesligne=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->find($id);
        	     if (!$cesligne) {
                    throw $this->createNotFoundException('No guest found for id '.$id);}
                    $em->remove($cesligne);
                    $em->flush();
		                $response = new JsonResponse(); }             
                    return $this->render('COMPTABILITECompBundle:facture:ceslignes.html.twig',
                  	array('cesligne'=>$cesligne));}

    /* This function is for deleting  A PRODUCTS OF INVOICES */
		public function supp_lignefactureAction(){
			if (isset($_POST['id'])) {
				$id=$_POST['id'];
				$em=$this->getDoctrine()->getManager();
		    $cesligne=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->find($id);
		    if (!$cesligne) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $em->remove($cesligne);
        $em->flush();
		    $response = new JsonResponse();
        return $response;
		
				# code...
			}}
    

    public function valider_factureAction($id){
        $em=$this->getDoctrine()->getManager();
        $facture=$em->getRepository('COMPTABILITECompBundle:Facture')->find($id);
        if (!$facture) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $ceslignes=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->findByFacture($id);
         foreach ($ceslignes as $ligne) {
                  if ($ligne->getPstock()!='destocker') {
                     $prod=$ligne->getProduit();
                  $x=$prod->getQuantite();
                  $prod->setQuantite($x-$ligne->getQuantite());
                  $ligne->setPstock('destocker');
                  $em->flush();
                 
                    # code...
                  }
                  //var_dump($prod);
                  # code...
                }
                
        $facture->setStatus('facture');
        $facture->setEtat('destockage');
        $em->flush($facture);
        return $this->redirectToRoute('factures');}

 public function envoi_facture($id){
            $em=$this->getDoctrine()->getManager();
             $cesligne=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->find($id);
            if (!$cesligne) {
                throw $this->createNotFoundException('No guest found for id '.$id);}
                $ceslignes=$em->getRepository('COMPTABILITECompBundle:Lignefacture')->findByFacture($id);
                $mess= \Swift_Message::newInstance()
                     ->setSubject('Votre facture')
                     ->setFrom(array('ibrahimhizeoui@gmail.com'=>'Mkd_company'))
                     ->setTo('b-love-h@live.fr')
                     ->setCharset('utf-8')
                     ->setContentType('text/html')
                     ->setBody($this->renderView('COMPTABILITECompBundle:facture:detail_facture.html.twig',
                array('id'=>$id,'facture'=>$facture,'ceslignes'=>$ceslignes)));    
                $this->get('mailer')->send($mess);
        
             return $this->render('COMPTABILITECompBundle:facture:detail_facture.html.twig',
                array('id'=>$id,'facture'=>$facture,'ceslignes'=>$ceslignes));}

    

}