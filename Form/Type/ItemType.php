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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
    /**
     * @var
     */
    private $class;

    /**
     * @param $class
     */
    public function __construct($class)
    {
        $this->class    = $class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label'         => 'menu.admin.item.name.text',
                    'required'      => true
                )
            )
            ->add('url', 'url', array(
                    'label'         => 'menu.admin.item.url.text',
                    'required'      => true
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'    => $this->class,
                'intention'     => 'item_form'
            )
        );
    }

    public function getName()
    {
        return 'black_menu_item';
    }
}
