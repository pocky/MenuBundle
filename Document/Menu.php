<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Document;

use Black\Bundle\MenuBundle\Model\Menu as AbstractMenu;
use Black\Bundle\CommonBundle\Traits\ThingDocumentTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Menu Document
 *
 * @ODM\MappedSuperclass()
 */
abstract class Menu extends AbstractMenu
{
    use ThingDocumentTrait;

    /**
     * @ODM\EmbedMany(targetDocument="Black\Bundle\MenuBundle\Document\Item")
     */
    protected $items;
}
