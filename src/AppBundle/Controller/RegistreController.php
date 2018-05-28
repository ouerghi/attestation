<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\EmployeeType;
use AppBundle\Entity\Employee;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

/**
 * Class RegistreController
 * @package AppBundle\Controller
 * @Security("is_fully_authenticated()")
 */
class RegistreController extends Controller
{
	/**
	 * @Route("/register", name="register")
	 * @param Request $request
	 * @param UserPasswordEncoderInterface $password
	 * @param \Swift_Mailer $mailer
	 * @Security("has_role('ROLE_ADMIN')")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function register( Request $request, UserPasswordEncoderInterface $password, \Swift_Mailer $mailer)
    {
	    $generator = new ComputerPasswordGenerator();
	    $generator
		    ->setUppercase()
		    ->setLowercase()
		    ->setNumbers()
		    ->setSymbols(false)
		    ->setLength(12);

	    $password_generated = $generator->generatePasswords(1);


        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted() )
        {
          $passwordEncrypted = $password->encodePassword($user,$password_generated[0]);
          $user->setPassword($passwordEncrypted);
          $email = $user->getEmail();
	        $message = (new \Swift_Message('Donées Confidentiel'))
		        ->setFrom('attestation.isi@gmail.com')
		        ->setTo($email)
		        ->setBody(
			        $this->renderView(
			        // app/Resources/views/Emails/registration.html.twig
				        'Emails/registration.html.twig',
				        array('password_generated' => $password_generated[0],'email' => $email)
			        ),
			        'text/html'
		        );
	        $mailer->send($message);

          // enregistrer l'utilisateur
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('default/register.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));

    }

	/**
	 * @Route("/personnel", name="personnel")
	 * @param Request $request *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @return Response
	 */
    public function registerPersonnel( Request $request)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
       $em = $this->getDoctrine()->getManager();
       $employee = new Employee();
       $form = $this->createForm(EmployeeType::class, $employee);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid())
       {
       	$employee->setUser($user);
       	$em->persist($employee);
       	$em->flush();
	       $this->get('session')->getFlashBag()->add(
		       'notice',
		       'le personnel est enregistré avec succés '
	       );
	       return $this->redirectToRoute('personnel');
       }
       return $this->render('default/add-personnel.html.twig', array(
       	'personnel' => $employee,
        'form' => $form->createView()
       ));
    }

    /**
     * @Route("/list-users", name="users")
     *@Security("has_role('ROLE_ADMIN')")
     */
    public function listAction()
    {
        $users = $this->getDoctrine()->getRepository("AppBundle:Employee")->findAll();
        return $this->render("default/list-users.html.twig",[
            'users' => $users,
        ]);
    }



}
