<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class MenuRepository
 *
 * @package Black\Bundle\MenuBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuRepository extends DocumentRepository
{
    protected function getQueryBuilder($alias = '')
    {
        return $this->createQueryBuilder($alias);
    }
}
