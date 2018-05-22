<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeAttestation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeattestation controller.
 * @Route("typeattestation")
 * @Security("is_fully_authenticated()")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TypeAttestationController extends Controller
{
    /**
     * Lists all typeAttestation entities.
     *
     * @Route("/", name="typeattestation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeAttestations = $em->getRepository('AppBundle:TypeAttestation')->findAll();

        return $this->render('typeattestation/index.html.twig', array(
            'typeAttestations' => $typeAttestations,
        ));
    }

	/**
	 * Creates a new typeAttestation entity.
	 *
	 * @Route("/new", name="typeattestation_new")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function newAction(Request $request)
    {
        $typeAttestation = new Typeattestation();
        $form = $this->createForm('AppBundle\Form\TypeAttestationType', $typeAttestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeAttestation);
            $em->flush();

            return $this->redirectToRoute('typeattestation_show', array('id' => $typeAttestation->getId()));
        }

        return $this->render('typeattestation/new.html.twig', array(
            'typeAttestation' => $typeAttestation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeAttestation entity.
     *
     * @Route("/{id}", name="typeattestation_show")
     * @Method("GET")
     */
    public function showAction(TypeAttestation $typeAttestation)
    {
        $deleteForm = $this->createDeleteForm($typeAttestation);

        return $this->render('typeattestation/show.html.twig', array(
            'typeAttestation' => $typeAttestation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeAttestation entity.
     *
     * @Route("/{id}/edit", name="typeattestation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeAttestation $typeAttestation)
    {
        $deleteForm = $this->createDeleteForm($typeAttestation);
        $editForm = $this->createForm('AppBundle\Form\TypeAttestationType', $typeAttestation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeattestation_edit', array('id' => $typeAttestation->getId()));
        }

        return $this->render('typeattestation/edit.html.twig', array(
            'typeAttestation' => $typeAttestation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeAttestation entity.
     *
     * @Route("/{id}", name="typeattestation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeAttestation $typeAttestation)
    {
        $form = $this->createDeleteForm($typeAttestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeAttestation);
            $em->flush();
        }

        return $this->redirectToRoute('typeattestation_index');
    }

    /**
     * Creates a form to delete a typeAttestation entity.
     *
     * @param TypeAttestation $typeAttestation The typeAttestation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeAttestation $typeAttestation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeattestation_delete', array('id' => $typeAttestation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
