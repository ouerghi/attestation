<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
            	'label' => 'Login',
	            'attr' => array(
	            	'placeholder' => 'Login'
	            )
            ))
	        ->add('email', EmailType::class, [
	        	'attr' => [
	        		'placeholder' => 'Email de l\'utilisateur ',
			        'data-error' => 'Le mail doit etre une adresse valide'
			        ]
	        ])
            ->remove('password')
	        ->add('cin', TextType::class, array(
	        	'attr' => array(
	        		'placeholder' => 'Numéro de carte d\'identité',
	        		'maxlength' => 8,
			        'minlength' => 8,
			        'pattern' => '^[0-9]*$' ,
			        'data-error' => 'numéro cin doit être de 8 caractères et ne contient que des nombres'
		        )
	        ))
	        ->add('matricule', TextType::class, array(
		        'attr' => array(
		        	'placeholder' => 'Matricule',
			        'maxlength' => 8,
			        'minlength' => 8,
			        'pattern' => '^[0-9a-zA-Z]*$' ,
			        'data-error' => 'numéro matricule doit être de 8 caractères et ne contient que des nombres ou des lettres'
		        )
	        ))
	        ->add('name', TextType::class, ['label' => 'Nom', 'attr' => ['placeholder'=> 'Nom de l\'employé' ]])
	        ->add('lastName', TextType::class, ['label' => 'Prénom', 'attr' => ['placeholder'=> 'Prénom de l\'employé' ]])
	        ->add('nationality', TextType::class, ['label' => 'Nationalité', 'attr' => ['placeholder'=> 'Nationalité de l\'employé' ]])
	        ->add('address', TextType::class, [ 'attr' => ['placeholder'=> 'Adresse de l\'employé' ]])
	        ->add('status', ChoiceType::class, array(
		        'multiple' => false,
		        'choices' => [
			        'Célébataire' => 'celebataire',
			        'Marié' => 'marie',
		        ],
	        ))
	        ->add('workingDuration', IntegerType::class, [
	        	'label' => 'Durée d\'heure  par année',
		       'attr' => array(
			       'placeholder' => 'Durée d\'heure  par année'
		       )
	        ])
	        ->add('mission', TextType::class, array(
	        	'attr' => array(
	        		'placeholder' => 'Mission de l\'utilisateur'
		        )
	        ))
	        ->add('numberOfChildren', IntegerType::class, [
	        	'label' => 'Nombres d\'enfant',
		       'attr' => array(
			       'placeholder' => 'Nombres d\'enfant'
		       )
	        ])
	        ->add('privilege', IntegerType::class,
		        [
	        	'label' => 'Priviléges',
			        'attr' => array(
				        'placeholder' => 'Priviléges'
			        )
		        ])
            ->add('roles', ChoiceType::class, array(
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Agent' => 'ROLE_USER',
                ],
            ))
	        ->add('revenuImposable', MoneyType::class, array(
	        	'label' => 'Revenu Imposable',
		        'divisor' => 100,
		        'currency' => 'TND',
		        'attr' => array(
		        	'placeholder' => 'Revenu Imposable'
		        )
	        ))
            ->add('grade',EntityType::class,[
                'class' => 'AppBundle:Grade',
                'choice_label' => 'libelleG',
                'placeholder' => 'Choisissez un grade'
            ])
	        ->add('typeAttestation', EntityType::class, array(
	        	'class' => 'AppBundle\Entity\TypeAttestation',
		        'choice_label' => 'name',
		        'multiple' => false,
		        'attr' => array(
		        	'placeholder' => 'Choisir un type d\'attestation'
		        )
	        ))
	        ->add('service', EntityType::class, array(
		        'class' => 'AppBundle\Entity\Service',
		        'choice_label' => 'name',
		        'multiple' => false,
		        'attr' => array(
			        'placeholder' => 'Choisir un service'
		        )
	        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}