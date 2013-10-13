<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MenuType
 *
 * @package Black\Bundle\MenuBundle\Form\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $class
     * @param mixed  $itemType
     */
    public function __construct($class, EventSubscriberInterface $eventSubscriber)
    {
        $this->class            = $class;
        $this->eventSubscriber  = $eventSubscriber;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->eventSubscriber);

        $builder
            ->add('name', 'text', array(
                    'label'         => 'menu.admin.menu.name.text'
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'menu.admin.menu.description.text',
                    'required'      => false
                )
            )
            ->add('items', 'collection', array(
                    'type'          => 'black_menu_item',
                    'label'         => 'menu.admin.menu.item.text',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'attr'          => array(
                        'class' => 'item-collection',
                        'add'   => 'add-another-item'
                    ),
                )
            );
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'            => $this->class,
                'intention'             => 'menu_form',
                'translation_domain'    => 'form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_menu_menu';
    }
}
