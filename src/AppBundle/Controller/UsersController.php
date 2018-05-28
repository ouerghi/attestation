<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsersController
 * @package AppBundle\Controller
 * @Security("is_fully_authenticated()")
 * @Security("has_role('ROLE_ADMIN')")
 *
 */
class UsersController extends Controller
{
	/**
	 * @Route("/employees" ,  name= "employee_index", options={"expose"=true} )
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
			$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
			/** @var QueryBuilder $qb */
			$qb = $datatableQueryBuilder->getQb();
			$qb->where('employee  NOT INSTANCE OF AppBundle\Entity\User');
			return $responseService->getResponse();
		}

		return $this->render('default/employee.html.twig', array(
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

	/**
	 * Lists all Post entities.
	 *
	 * @param Request $request
	 *
	 * @Route("/users", name="user_index")
	 * @Method("GET")
	 *
	 * @return Response
	 * @throws \Exception
	 */
	public function listUsersAction(Request $request)
	{
		$isAjax = $request->isXmlHttpRequest();

		 //Get your Datatable ...
		$datatable = $this->get('app.datatable.user');
		$datatable->buildDatatable();

		if ($isAjax) {
			$responseService = $this->get('sg_datatables.response');
			$responseService->setDatatable($datatable);
			$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
			/** @var QueryBuilder $qb */
			$qb = $datatableQueryBuilder->getQb();
			$qb->where('user  INSTANCE OF AppBundle\Entity\User');
			return $responseService->getResponse();
		}

		return $this->render('default/users.html.twig', array(
			'datatable' => $datatable,
		));
	}

	/**
	 * Finds and displays a Post entity.
	 *
	 * @param User $user
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Route("/{_locale}/{id}.{_format}", name = "post_show", options = {"expose" = true})
	 * @Method("GET")
	 * @Security("has_role('ROLE_USER')")
	 *
	 */
	public function showEmployeeAction(User $user)
	{
		return $this->render('default/users.html.twig', array(
			'user' => $user
		));
	}

	/**
	 * Displays a form to edit an existing employee entity.
	 *
	 * @Route("user/{id}/edit", name="user_edit")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @param User $user
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_ADMIN')")
	 *
	 */
	public function editAction(Request $request, User $user)
	{
		$deleteForm = $this->createDeleteForm($user);
		$editForm = $this->createForm('AppBundle\Form\UserType', $user);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
		}

		return $this->render('user/edit.html.twig', array(
			'employee' => $user,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Creates a form to delete a employee entity.
	 *
	 * @param Employee $employee The employee entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Employee $employee)
	{
		$delete_form =  $this->createFormBuilder()
		            ->setAction($this->generateUrl('user_delete', array('id' => $employee->getId())))
		            ->setMethod('DELETE')
		            ->getForm()
			;
		return $delete_form;
	}

	/**
	 * Deletes a employee entity.
	 *
	 * @Route("user/{id}", name="user_delete")
	 * @Method("DELETE")
	 * @param Request $request
	 * @param User $user
	 *@Security("has_role('ROLE_ADMIN')")
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 *
	 */
	public function deleteAction(Request $request, User $user)
	{
		$form = $this->createDeleteForm($user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($user);
			$em->flush();
		}

		return $this->redirectToRoute('users');
	}

	/**
	 * Finds and displays a employee entity.
	 *
	 * @Route("user/{id}", name="user_show")
	 * @Method("GET")
	 * @param User $user
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Security("has_role('ROLE_ADMIN')")
	 *
	 */
	public function showUserAction(User $user)
	{
		$deleteForm = $this->createDeleteForm($user);

		return $this->render('user/show.html.twig', array(
			'employee' => $user,
			'delete_form' => $deleteForm->createView(),
		));
	}

}
