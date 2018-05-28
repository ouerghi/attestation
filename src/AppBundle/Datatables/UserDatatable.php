<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;

/**
 * Class UserDatatable
 *
 * @package AppBundle\Datatables
 */
class UserDatatable extends AbstractDatatable
{
	/**
	 * {@inheritdoc}
	 * @throws \Exception
	 */
    public function buildDatatable(array $options = array())
    {
        $this->language->set(array(
            'cdn_language_by_locale' => true
            //'language' => 'de'
        ));

        $this->ajax->set(array(
        ));

        $this->options->set(array(
//            'individual_filtering' => true,
//            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        ));

        $this->features->set(array(
        ));

        $this->columnBuilder
            ->add('id', Column::class, array(
                'title' => '#',
                ))
            ->add('username', Column::class, array(
                'title' => 'Username',
                ))
            ->add('email', Column::class, array(
                'title' => 'Email',
                ))
            ->add('roles', Column::class, array(
                'title' => 'Roles',
                ))
            ->add('lastName', Column::class, array(
                'title' => 'Prénom',
                ))
            ->add('matricule', Column::class, array(
                'title' => 'Matricule',
                ))
            ->add('cin', Column::class, array(
                'title' => 'Cin',
                ))

            ->add('typeAttestation.name', Column::class, array(
                'title' => 'Attestation',
                ))

            ->add('service.name', Column::class, array(
                'title' => 'Service ',
                ))

            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'user_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'user_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\User';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_datatable';
    }
}
