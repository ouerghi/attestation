<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
	/**
	 * @Route("/users" ,  name= "users_index", options={"expose"=true} )
	 * @Method("GET")
	 * @param Request $request
	 *
	 * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
	 * @throws \Exception
	 */
	public function indexAction(Request $request)
	{
		$isAjax = $request->isXmlHttpRequest();

		// Get your Datatable ...
		$datatable = $this->get('app.datatable.employee');
		$datatable->buildDatatable();


		// or use the DatatableFactory
		/** @var DatatableInterface $datatable */
//		$datatable = $this->get('sg_datatables.factory')->create(EmployeeDatatable::class);
//		$datatable->buildDatatable();

		if ($isAjax) {
			$responseService = $this->get('sg_datatables.response');
			$responseService->setDatatable($datatable);
			$responseService->getDatatableQueryBuilder();

			return $responseService->getResponse();
		}

		return $this->render('default/users.html.twig', array(
			'datatable' => $datatable,
		));
	}

	/**
	 * Finds and displays a Post entity.
	 *
	 * @param Employee $employee
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Route("/{_locale}/{id}.{_format}", name = "post_show", options = {"expose" = true})
	 * @Method("GET")
	 * @Security("has_role('ROLE_USER')")
	 *
	 */
	public function showAction(Employee $employee)
	{
		return $this->render('default/show.html.twig', array(
			'employee' => $employee
		));
	}
}
