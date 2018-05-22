<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Employee controller.
 *
 * @Route("employee")
 * @Security("is_fully_authenticated()")
 */
class EmployeeController extends Controller
{
	/**
	 * @Route("/list-demand", name="list_demand")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function listDemand()
	{
		$token = $this->get('security.token_storage')->getToken();
		$user = $token->getUser();
		$service = $user->getService()->getId();
		$attestation = $user->getTypeAttestation()->getId();
		$em = $this->getDoctrine()->getManager();
		$demand = $em->getRepository('AppBundle:Demand')->findByService($service, $attestation);

		return $this->render('employee/list-demand.html.twig', array(
			'demand' => $demand
		));
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @Route("/state/{id}", options={"expose":true} ,name="state")
	 * @Method("POST")
	 *
	 * @return JsonResponse
	 */
	public function setState(Request $request,$id)
	{
		$ok = false;
		if ($request->isXmlHttpRequest() && $request->isMethod('post'))
		{
			$token = $this->get('security.token_storage')->getToken();
			$user = $token->getUser();
			$em = $this->getDoctrine()->getManager();
			$demand = $em->getRepository('AppBundle:Demand')->find($id);
			$demand->setState(true);
			$demand->setUser($user);
			$demand->setOk();
			$em->persist($demand);
			$em->flush();
			$ok =true;
		}
			return new JsonResponse($ok);


	}

	/**
	 * Finds and displays a employee entity.
	 *
	 * @Route("/{id}", name="employee_show")
	 * @Method("GET")
	 * @param Employee $employee
	 * @Security("has_role('ROLE_ADMIN')")
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function showAction(Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee);

        return $this->render('employee/show.html.twig', array(
            'employee' => $employee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

	/**
	 * Displays a form to edit an existing employee entity.
	 *
	 * @Route("/{id}/edit", name="employee_edit")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @param Employee $employee
	 * @Security("has_role('ROLE_ADMIN')")
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function editAction(Request $request, Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee);
        $editForm = $this->createForm('AppBundle\Form\EmployeeType', $employee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_edit', array('id' => $employee->getId()));
        }

        return $this->render('employee/edit.html.twig', array(
            'employee' => $employee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

	/**
	 * Deletes a employee entity.
	 *
	 * @Route("/{id}", name="employee_delete")
	 * @Method("DELETE")
	 * @param Request $request
	 * @param Employee $employee
	 *@Security("has_role('ROLE_ADMIN')")
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
    public function deleteAction(Request $request, Employee $employee)
    {
        $form = $this->createDeleteForm($employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employee);
            $em->flush();
        }

        return $this->redirectToRoute('users');
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
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employee_delete', array('id' => $employee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

