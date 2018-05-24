<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Demand;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DemandController extends Controller
{
	/**
	 * @Route("/", name="demand")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction(Request $request)
    {
	    $form = $this->createFormBuilder()
	                 ->add('matricule', TextType::class, array(
		                 'label' => 'Matricule',
		                 'constraints' => array(
			                 new NotBlank(),
			                 new Length(array('min' => 8, 'max' => 8) )
		                 )
	                 ))
		             ->add('typeAttestation', EntityType::class, array(
		             	   'required' => true,
			               'class' => 'AppBundle\Entity\TypeAttestation',
			               'choice_label' => 'name',
			               'multiple' => false,
			               'constraints' => array(
			               	new  NotBlank()
			               ),
			               'attr' => array(
				               'placeholder' => 'Choisir un type d\'attestation',

			               )
		             ))
		             ->getForm();

	    $form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid())
	       {
	       	$em = $this->getDoctrine()->getManager();
	    	 $data = $form->getData();
	    	 $matricule = $data['matricule'];
	    	 $employee = $em->getRepository('AppBundle:Employee')->findOneBy(array('matricule' => $matricule));
	    	 if (null !== $employee)
		     {
		     	$demand = new Demand();
		     	$demand->setEmployee($employee);
		     	$demand->setTypeAttestation($data['typeAttestation']);
		     	$em->persist($demand);
		     	$em->flush();
		     	$this->get('session')->getFlashBag()->set('success', 'Votre demande d\'attestation est envoyé au service  '.$employee->getService()->getName());
			     return $this->redirectToRoute('demand');
		     }else{
			     $this->get('session')->getFlashBag()->set('danger', 'Merci de vérifier votre numéro de matricule   '.$matricule);
			     return $this->redirectToRoute('demand');
		     }

	       }
	       return $this->render('index.html.twig', array(
	        'form' => $form->createView()
        ));
    }

	/**
	 * @Route("/certificate", name="certificate")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listDemandEmployee(Request $request)
    {
	    $em = $this->getDoctrine()->getManager();
	    $certificate = $em->getRepository('AppBundle:Demand')->findAll();
    	$form = $this->createFormBuilder()
		    ->add('matricule', TextType::class, array(
			    'label' => 'Matricule',
			    'attr' => array('placeholder' => 'Matricule'),
			    'constraints' => array(
				    new NotBlank(),
				    new Length(array('min' => 8, 'max' => 8) )
			    )
		    ))
		    ->getForm()
		    ;
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid())
	    {
		    $data = $form->getData();
		    $matricule = $data['matricule'];
		    $certificate = $em->getRepository('AppBundle:Demand')->findByMatricule($matricule);
	    }
    	return $this->render('employee/certificate.html.twig', array(
    		'demand' => $certificate,
		    'form'   => $form->createView()
	    ));
    }

}
