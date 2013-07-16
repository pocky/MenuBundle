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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\MenuBundle\Model\Item as AbstractItem;

/**
 * Menu Entity
 *
 * @ORM\Table(name="item",indexes={
 *          @ORM\Index(name="name_idx", columns={"name"})
 *      })
 * @ORM\Entity()
 */
class Item extends AbstractItem
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Type(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     * @Assert\Url
     */
    protected $url;
}
