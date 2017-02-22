<?php

namespace CRM\CrmBundle\Controller;

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

use CRM\CrmBundle\Entity\Client;





class ClientController extends Controller
{
    public function clientsAction(){
		$em=$this->getDoctrine()->getManager();
		$clients=$em->getRepository('CRMCrmBundle:Client')->findAll();
		return $this->render('CRMCrmBundle:client:clients.html.twig',array('clients'=>$clients));
	}
	public function ajouter_clientAction(Request $request){
		    $userManager = $this->get('fos_user.user_manager'); 
            $user = $userManager->createUser();  
         
		    $client= new Client;
		    $form=$this->createFormBuilder($client)
		           ->add('nom', TextType::class)
                   ->add('adress',TextareaType::class)
                   ->add('tel',TextType::class)
                   ->add('fax',TextType::class)
                   ->add('tel',TextType::class)
                   ->add('email',TextType::class)
                   ->add('siteweb',TextType::class)
                   ->add('username',TextType::class)

                   ->add('type',ChoiceType::class, array(
                         'choices'  => array('type1' => 'type1','type2' => 'type2'), ))
                  ->add('dateinscrit', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   
                    ->add('save', SubmitType::class, array('label' => 'Ajouter','attr'=>array('class'=>'en')))
            ->getForm();
            
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
          	          $user->setEmail($client->getEmail()) ;
                       $user->setUsername($client->getUsername()) ;
                       $user->setPlainPassword($client->getUsername()) ;
                       $role = array('ROLE_CLIENT');
                       $user->setRoles($role) ;
                       $user->setEnabled(true) ;
                       $user->setSuperAdmin(false) ;
                       $em = $this->getDoctrine()->getManager();
                       $em->persist($client);
                       $em->persist($user);
                       $em->flush();
              //var_dump($client);
                       return $this->redirectToRoute('clients');
    }
		return $this->render('CRMCrmBundle:client:ajouter_client.html.twig',array('form'=>$form->createView()));
	}

	public function modif_clientAction(Request $request,$id){
		    $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        $client = $em->getRepository('CRMCrmBundle:Client')->find($id);
        if (!$client) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $user=$em->getRepository('UserUserBundle:User')->findOneByEmail($client->getEmail());
         
		    
		    $form=$this->createFormBuilder($client)
		           ->add('nom', TextType::class)
                   ->add('adress',TextareaType::class)
                   ->add('tel',TextType::class)
                   ->add('fax',TextType::class)
                   ->add('tel',TextType::class)
                   ->add('email',TextType::class)
                   ->add('siteweb',TextType::class)
                   ->add('username',TextType::class)

                   ->add('type',ChoiceType::class, array(
                         'choices'  => array('type1' => 'type1','type2' => 'type2'), ))
                  ->add('dateinscrit', DateType::class, array(
                         'input'  => 'datetime',
                         'widget' => 'single_text',
                         'format' => 'yyyy-MM-dd'))
                   
                    ->add('save', SubmitType::class, array('label' => 'Modifier','attr'=>array('class'=>'en')))
            ->getForm();
            
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
          	          $user->setEmail($client->getEmail()) ;
                       $user->setUsername($client->getUsername()) ;
                       $user->setPlainPassword($client->getUsername()) ;
                       $role = array('ROLE_CLIENT');
                       $user->setRoles($role) ;
                       $user->setEnabled(true) ;
                       $user->setSuperAdmin(false) ;
                       $em = $this->getDoctrine()->getManager();
                       $em->persist($client);
                       $em->persist($user);
                       $em->flush();
              //var_dump($client);
                       return $this->redirectToRoute('clients');
    }
		return $this->render('CRMCrmBundle:client:modif_client.html.twig',array('form'=>$form->createView()));
	}


	public function supp_clientAction($id){
    	$em = $this->getDoctrine()->getManager();
      $userManager = $this->get('fos_user.user_manager');
        
        $client = $em->getRepository('CRMCrmBundle:Client')->find($id);
        if (!$client) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
         $user=$em->getRepository('UserUserBundle:User')->findOneByEmail($client->getEmail());
        $em->remove($user);
        
        $em->remove($client);
        $em->flush();
        return $this->redirectToRoute('clients');
    

    }
}
