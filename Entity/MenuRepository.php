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

use Black\Bundle\MenuBundle\Model\MenuRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class MenuRepository
 *
 * @package Black\Bundle\MenuBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuRepository extends EntityRepository implements MenuRepositoryInterface
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
            ->where('m.items.id = :key')
            ->orWhere('m.items.slug = :key')
            ->setParameter('key', $key)
            ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder($alias = 'm')
    {
        return $this->createQueryBuilder($alias);
    }

    public function countMenus()
    {
        $qb = $this->getQueryBuilder()
            ->select('count(m)')
            ->getQuery();

        try {
            $menu = $qb->getSingleScalarResult();
        } catch (NoResultException $e) {
            throw new EntityNotFoundException(
                sprintf('No menu founded')
            );
        }

        return $menu;
    }
}
