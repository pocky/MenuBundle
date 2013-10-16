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

use Black\Bundle\MenuBundle\Model\RepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class MenuRepository
 *
 * @package Black\Bundle\MenuBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function getMenuByIdOrSlug($key)
    {
        $qb     = $this->getQueryBuilder();

        $qb = $qb
            ->where('m.id = :key')
            ->orWhere('m.slug = :key')
            ->setParameter('key', $key)
            ->getQuery();

        return $qb->execute();
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
            ->where('m.items.id = :key')
            ->orWhere('m.items.slug = :key')
            ->setParameter('key', $key)
            ->getQuery();

        return $qb->execute();
    }

    protected function getQueryBuilder($alias = 'm')
    {
        return $this->createQueryBuilder($alias);
    }
}
