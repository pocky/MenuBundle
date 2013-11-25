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

use Black\Bundle\MenuBundle\Model\MenuRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class MenuRepository
 *
 * @package Black\Bundle\MenuBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuRepository extends DocumentRepository implements MenuRepositoryInterface
{
    /**
     * @param $key
     *
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getMenuByIdOrSlug($key)
    {
        $qb     = $this->getQueryBuilder();

        $qb = $qb
            ->addOr($qb->expr()->field('id')->equals($key))
            ->addOr($qb->expr()->field('slug')->equals($key))
            ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @param $key
     *
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getMenuWhereItem($key)
    {
        $qb     = $this->getQueryBuilder();

        $qb = $qb
            ->addOr($qb->expr()->field('items.id')->equals($key))
            ->addOr($qb->expr()->field('items.slug')->equals($key))
            ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }

    /**
     * @todo to test
     * @return string
     */
    public function countMenus()
    {
        return $qb = $this->getQueryBuilder()->getQuery()->execute()->count();
    }
}
