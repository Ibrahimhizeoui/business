<?php

namespace GRH\GrhBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GRH\GrhBundle\Entity\Departement;
use GRH\GrhBundle\Form\DepartementType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Departement controller.
 *
 * @Route("/departement")
 */
class DepartementController extends Controller
{
    /**
     * Lists all Departement entities.
     *
     * @Route("/", name="departement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $departements = $em->getRepository('GRHGrhBundle:Departement')->findAll();
        $employes=$this->getDoctrine()->getRepository('GRHGrhBundle:Employe')->findAll();
        return $this->render('departement/index.html.twig', array(
            'departements' => $departements,
            'employes' => $employes,
        ));
    }

    /**
     * Finds and displays a Departement entity.
     *
     * @Route("/{id}", name="departement_show")
     * @Method("GET")
     */
    public function showAction(Departement $departement)
    {

        return $this->render('departement/show.html.twig', array(
            'departement' => $departement,
        ));
    }

    public function ajouterdepartementAction(Request $request){
        $departement= new Departement;
       // $form=$this->createForm( new DepartementType,$departement);
        $form = $this->createFormBuilder($departement)
         ->add('nom',TextType::class)
         ->add('responsable', EntityType::class, array(
               'class' => 'GRHGrhBundle:Employe',
               'choice_label' => 'nom',
               
               'required'    => false,
                'placeholder' => 'Choisir le responsable',
                'empty_data'  => null
               ))
           
            ->add('description',TextType::class)
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))->getForm();
            $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // ... perform some action, such as saving the task to the database
         $em = $this->getDoctrine()->getManager();
              $em->persist($departement);
              $em->flush();

        return $this->redirectToRoute('departement');
    }
        return $this->render('GRHGrhBundle:departement:ajouterdepartement.html.twig',array('form' => $form->createView(),));

    }


    /***************************** REMOVE DEPARTEMENT ******************************/
   
     public function supp_departementAction($id){
      $em=$this->getDoctrine()->getManager();
      $departement=$this->getDoctrine()->getRepository('GRHGrhBundle:Departement')->find($id);
      if (!$departement) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }

        $em->remove($departement);
        $em->flush();
        return $this->redirectToRoute('departement');
    }
   /***************************** END REMOVE ******************************/



   /***************************** EDIT DEPARTEMENT ******************************/

    public function modif_departementAction(Request $request ,$id){
      $em=$this->getDoctrine()->getManager();
      $departement=$this->getDoctrine()->getRepository('GRHGrhBundle:Departement')->find($id);
      if (!$departement) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $form = $this->createFormBuilder($departement)
         ->add('nom',TextType::class)
           ->add('responsable', EntityType::class, array(
               'class' => 'GRHGrhBundle:Employe',
               'choice_label' => 'nom',
               'placeholder' => 'Choisir le responsable',
               ))
            ->add('description',TextType::class)
             ->add('save', SubmitType::class, array('label' => 'Enregistrer'))->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
              // ... perform some action, such as saving the task to the database
              $em = $this->getDoctrine()->getManager();
              $em->flush();

        return $this->redirectToRoute('departement');
    }
    
      return $this->render('GRHGrhBundle:departement:modif_departement.html.twig',array('form' => $form->createView(),));

    }
   /***************************** END EDIT ******************************/


   public function detail_departementAction(Request $request,$id){
      $em=$this->getDoctrine()->getManager();
      $departement=$this->getDoctrine()->getRepository('GRHGrhBundle:Departement')->find($id);
      if (!$departement) {
            throw $this->createNotFoundException('No guest found for id '.$id);
        }
        $nbempl=$this->getDoctrine()->getRepository('GRHGrhBundle:Departement')->nbempl($id);
        $employes=$this->getDoctrine()->getRepository('GRHGrhBundle:Departement')->employes($id);

        //   var_dump($nbempl);
    return $this->render('GRHGrhBundle:departement:detail_departement.html.twig',array('departement' => $departement,'nbempl'=>$nbempl,'employes'=>$employes));
       
   }
}
