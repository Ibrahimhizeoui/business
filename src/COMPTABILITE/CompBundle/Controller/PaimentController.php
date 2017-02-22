<?php

namespace COMPTABILITE\CompBundle\Controller;
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
use COMPTABILITE\CompBundle\Entity\Paiment;





class PaimentController extends Controller
{
	public function paimentfournisseurAction(){
		$em=$this->getDoctrine()->getManager();
		$paimentfournisseur=$em->getRepository('COMPTABILITECompBundle:Paiment')->findByStatus('depence_fournisseur');
		return $this->render('COMPTABILITECompBundle:paimentfournisseur:paimentfournisseur.html.twig'
			,array('paimentfournisseur'=>$paimentfournisseur));
	}

	public function ajouter_paimentfournisseurAction(Request $request){
		$paiment=new Paiment;
		$form=$this->createFormBuilder($paiment)
                   ->add('typepaiement', TextType::class)
                   ->add('montant',TextType::class)
                  
                  	->add('datepayment', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   /*->add('status',ChoiceType::class, array(
                         'choices'  => array('Paiment' => 'paiment','Depence' => 'depence'), ))*/
                   
                   
                   
                    ->add('fournisseur', EntityType::class, array(
                     'class' => 'STOCKStockBundle:Fournisseur',
                     'choice_label' => 'nom',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($paiment);
              $paiment->setStatus('depence_fournisseur');
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('paimentfournisseur');}
		return $this->render('COMPTABILITECompBundle:paimentfournisseur:ajouter_paimentfournisseur.html.twig',
			array('form'=>$form->createView()) );
	}

	public function modif_paimentfournisseurAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
		$paiment=$em->getRepository('COMPTABILITECompBundle:Paiment')->find($id);
		if (!$paiment) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		$form=$this->createFormBuilder($paiment)
                   ->add('typepaiement', TextType::class)
                   ->add('montant',TextType::class)
                  
                  	->add('datepayment', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   /*->add('status',ChoiceType::class, array(
                         'choices'  => array('Paiment' => 'paiment','Depence' => 'depence'), ))*/
                   
                   
                   
                    ->add('fournisseur', EntityType::class, array(
                     'class' => 'STOCKStockBundle:Fournisseur',
                     'choice_label' => 'nom',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($paiment);
              $paiment->setStatus('depence_fournisseur');
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('paimentfournisseur');}
		return $this->render('COMPTABILITECompBundle:paimentfournisseur:modif_paimentfournisseur.html.twig',
			array('form'=>$form->createView()) );
	}

	public function supp_paimentfournisseurAction($id){
		$em = $this->getDoctrine()->getManager();
		$paiment=$em->getRepository('COMPTABILITECompBundle:Paiment')->find($id);
		if (!$paiment) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $em->remove($paiment);
        $em->flush();
        return $this->redirectToRoute('paimentfournisseur');
	}


	/****************************************** PAIMENT DE CLIENT *******************************************************************/
	public function paimentclientAction(){
		$em=$this->getDoctrine()->getManager();
		$paimentclient=$em->getRepository('COMPTABILITECompBundle:Paiment')->findByStatus('paiment_client');
		return $this->render('COMPTABILITECompBundle:paimentclient:paimentclient.html.twig'
			,array('paimentclient'=>$paimentclient));
	}

	public function ajouter_paimentclientAction(Request $request){
		$paiment=new Paiment;
		$form=$this->createFormBuilder($paiment)
                   ->add('typepaiement', TextType::class)
                   ->add('montant',TextType::class)
                  
                  	->add('datepayment', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   /*->add('status',ChoiceType::class, array(
                         'choices'  => array('Paiment' => 'paiment','Depence' => 'depence'), ))*/
                   
                   
                   
                    ->add('client', EntityType::class, array(
                     'class' => 'CRMCrmBundle:Client',
                     'choice_label' => 'nom',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              
              $paiment->setStatus('paiment_client');
              $em->persist($paiment);
              $em->flush();
              //var_dump($employe);
             $response = new JsonResponse();
                  return $response;}
		return $this->render('COMPTABILITECompBundle:paimentclient:ajouter_paimentclient.html.twig',
			array('form'=>$form->createView()) );
	}

	public function modif_paimentclientAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
		$paiment=$em->getRepository('COMPTABILITECompBundle:Paiment')->find($id);
		if (!$paiment) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
		$form=$this->createFormBuilder($paiment)
                   ->add('typepaiement', TextType::class)
                   ->add('montant',TextType::class)
                  
                  	->add('datepayment', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   /*->add('status',ChoiceType::class, array(
                         'choices'  => array('Paiment' => 'paiment','Depence' => 'depence'), ))*/
                   
                   
                   
                    ->add('client', EntityType::class, array(
                     'class' => 'CRMCrmBundle:Client',
                     'choice_label' => 'nom',
                     'attr' => array(
                     'class' => 'js-example-basic-single js-states form-control',
                     'tabindex'=>'-1')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
             $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          	  $em = $this->getDoctrine()->getManager();
              $em->persist($paiment);
              $paiment->setStatus('paiment_client');
              $em->flush();
              //var_dump($employe);
             return $this->redirectToRoute('paimentclient');}
		return $this->render('COMPTABILITECompBundle:paimentclient:modif_paimentclient.html.twig',
			array('form'=>$form->createView()) );
	}

	public function supp_paimentclientAction($id){
		$em = $this->getDoctrine()->getManager();
		$paiment=$em->getRepository('COMPTABILITECompBundle:Paiment')->find($id);
		if (!$paiment) {
            throw $this->createNotFoundException('No guest found for id '.$id);}
        $em->remove($paiment);
        $em->flush();
        return $this->redirectToRoute('paimentclient');
	}
}