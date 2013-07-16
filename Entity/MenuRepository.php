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

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentNotFoundException;

class MenuRepository extends DocumentRepository
{
    private function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}
