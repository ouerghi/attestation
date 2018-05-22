<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Certificate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * Class CertificateController
 * @package AppBundle\Controller
 * @Security("is_fully_authenticated()")
 */
class CertificateController extends Controller
{
	/**
	 * @Route("new-certificate" ,name="new_certificate")
	 * @param Request $request
	 *@Security("has_role('ROLE_USER')")
	 * @return Response
	 */
    public function indexAction(Request $request)
    {
    	$token = $this->get('security.token_storage')->getToken();
    	$user = $token->getUser();
	    $em = $this->getDoctrine()->getManager();
	    $form = $this->createFormBuilder()
	                 ->add('matricule', TextType::class, array(
	                 	'label' => 'Matricule',
		                 'constraints' => array(
		                 	new NotBlank(),
			                 new Length(array('min' => 8, 'max' => 8) )
		                 )
	                 ))
	                 ->getForm();

	    $form->handleRequest($request);
	    if ($form->isSubmitted() && $form->isValid()) {
		    $data = $form->getData();
		    $matricule =  $data['matricule'];
		    $employee = $em->getRepository('AppBundle:Employee')->findOneBy(array('matricule' => $matricule));
		    if (null !== $employee)
		    {
		    	if ($employee->getService() === $user->getService())
			    {
			    	$certificate = new Certificate();
			    	$certificate->setUser($user);
			    	$certificate->setEmployee($employee);
			    	$em->persist($certificate);
			    	$em->flush();
			    	return $this->redirectToRoute('print_certificate', array('id' => $employee->getId()));
			    }else{

		    		$this->get('session')->getFlashBag()->set('error', 'Vous n\'appartient pas à notre service '.$user->getService()->getName());
		    		return $this->redirectToRoute('new_certificate');
			    }
		    } else{
			    $this->get('session')->getFlashBag()->set('error', 'Votre numéro de matricule est inéxistant ');
			    return $this->redirectToRoute('new_certificate');
		    }
	    }
        return $this->render('Certificate/index.html.twig', array(
           'user' => $user,
           'form' => $form->createView()
        ));
    }

	/**
	 * @Route("/print-certificate/{id}", name="print_certificate")
	 * @param $id
	 *@Security("has_role('ROLE_USER')")
	 * @return void
	 */
    public function domPDF($id)
    {
	    $token = $this->get('security.token_storage')->getToken();
	    $user = $token->getUser();
    	$em = $this->getDoctrine()->getManager();
    	$employee = $em->getRepository('AppBundle:Employee')->find($id);

	    if ($user->getTypeAttestation()->getId() === 1 )
	    {
		    $template = $this->renderView( 'Certificate/salaire.html.twig', array(
			    'employee' => $employee,
			    'user' => $user
		    ));
	    }
    	if ($user->getTypeAttestation()->getId() === 2 )
	    {
		    $template = $this->renderView('Certificate/presence.html.twig', array(
			    'employee' => $employee,
			    'user' => $user
		    ));
	    }
	    if ($user->getTypeAttestation()->getId() === 3 )
	    {
		    $template = $this->renderView('Certificate/travail.html.twig', array(
			    'employee' => $employee,
			    'user' => $user
		    ));
	    }
	    $options = new Options();
	    $options->setIsRemoteEnabled(true);
	    $options->set('defaultFont', 'Courier');
	    $options->setDpi(150);
	    $dompdf = new Dompdf();
	    $dompdf->setOptions($options);
	    $dompdf->loadHtml($template);
	    // (Optional) Setup the paper size and orientation
	    $dompdf->setPaper('A4', 'landscape');
	    // Render the HTML as PDF
	    $dompdf->render();
	    // Output the generated PDF to Browser
	    $dompdf->stream("attestation.pdf", array("Attachment" => false));
    }



}
