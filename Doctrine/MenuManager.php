<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Doctrine;

use Black\Bundle\MenuBundle\Model\MenuManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class MenuManager
 *
 * @package Black\Bundle\MenuBundle\Doctrine
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuManager implements MenuManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param ObjectManager $dm
     * @param string        $class
     */
    public function __construct(ObjectManager $dm, $class)
    {
        $this->manager     = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
    }

    /**
     * @return ObjectManager|mixed
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function persist($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }

        $this->getManager()->persist($model);
    }

    /**
     *
     */
    public function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function remove($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }
        $this->getManager()->remove($model);
    }

    /**
     * @param mixed $model
     */
    public function persistAndFlush($model)
    {
        $this->persist($model);
        $this->flush();
    }

    /**
     * @param mixed $model
     */
    public function removeAndFlush($model)
    {
        $this->getManager()->remove($model);
        $this->getManager()->flush();
    }

    /**
     * @return mixed
     */
    public function createInstance()
    {
        $class  = $this->getClass();
        $model = new $class;

        return $model;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * @param integer $id
     * 
     * @return Menu
     */
    public function findMenuById($id)
    {
        return $this->getRepository()->findOneById($id);
    }

    /**
     * @param string $slug
     * 
     * @return Menu
     */
    public function findMenuBySlug($slug)
    {
        return $this->getRepository()->findOneBySlug($slug);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function findMenuByIdOrSlug($key)
    {
        return $this->getRepository()->getMenuByIdOrSlug($key);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function findMenuWhereItem($key)
    {
        return $this->getRepository()->getMenuWhereItem($key);
    }

    public function countMenus()
    {
        return $this->getRepository()->countMenus();
    }
}
