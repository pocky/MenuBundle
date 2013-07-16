<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Entity;

use Black\Bundle\MenuBundle\Model\Menu as AbstractMenu;
use Black\Bundle\EngineBundle\Traits\ThingEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu Entity
 *
 * @ORM\Table(name="menu",indexes={
 *          @ORM\Index(name="name_idx", columns={"name"})
 *      })
 * @ORM\Entity(repositoryClass="Black\Bundle\MenuBundle\Entity\MenuRepository")
 */
abstract class Menu extends AbstractMenu
{
    use ThingEntityTrait;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Item", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="menu_item",
     *      joinColumns={@ORM\JoinColumn(name="menu_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $items;
}
