<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CertificateController extends Controller
{
    /**
     * @Route("new-certificate" ,name="new_certificate")
     */
    public function indexAction()
    {
    	$token = $this->get('security.token_storage')->getToken();
    	$user = $token->getUser();
    	$em = $this->getDoctrine()->getManager();
    	$employee = $em->getRepository('AppBundle:Employee')->findOneBy(array('matricule' => '75756765'));

        return $this->render('Certificate/index.html.twig', array(
           'user' => $user,
	        'employee' => $employee
        ));
    }

}
