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
 * Class Menu
 *
 * @package Black\Bundle\MenuBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Menu extends AbstractMenu
{
    use ThingEntityTrait;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="menu", cascade={"persist", "remove"})
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
