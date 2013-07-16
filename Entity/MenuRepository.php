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

use Doctrine\ORM\EntityRepository;

/**
 * MenuRepository
 */
class MenuRepository extends EntityRepository
{
    protected function getQueryBuilder($alias = 'm')
    {
        return $this->createQueryBuilder($alias);
    }
}
