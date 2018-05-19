<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EmployeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->remove('roles')
	        ->remove('username')
	        ->remove('email')
	        ->remove('typeAttestation')
        ;

    }
    public function getParent() {
	    return UserType::class;
    }
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Employee::class,
		));
	}



}
