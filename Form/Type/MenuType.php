<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
    private $class;

    /**
     * @param string $class The menu class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label'         => 'menu.admin.form.name'
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'menu.admin.form.description',
                    'required'      => false
                )
            )
            ->add('items', 'collection', array(
                'type'          => new ItemType(),
                'label'         => 'menu.admin.form.item.label',
                'allow_add'     => true,
                'allow_delete'  => true,
                'attr'          => array(
                    'class' => 'item-collection',
                    'add'   => 'add-another-item'
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'    => $this->class,
                'intention'     => 'menu_form'
            )
        );
    }

    public function getName()
    {
        return 'black_menu_menu';
    }
}
