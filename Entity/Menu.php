<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Black\Bundle\MenuBundle\Model\Menu as AbstractMenu;
use Black\Bundle\CommonBundle\Traits\ThingEntityTrait;

/**
 * Menu Entity
 */
abstract class Menu extends AbstractMenu
{
    use ThingEntityTrait;

    /**
     * @ORM\ManyToMany(targetEntity="Item", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="menu_item",
     *      joinColumns={@ORM\JoinColumn(name="menu_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
}
