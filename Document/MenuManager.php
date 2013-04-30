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

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;

class MenuManager extends DocumentManager
{
    protected $dm;
    protected $repository;
    protected $class;
    protected $properties = array();

    /**
     * Constructor
     *
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param \Doctrine\ODM\MongoDB\Configuration $class
     */
    public function __construct(DocumentManager $dm, $class)
    {
        $this->dm          = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
    }

    /**
     * Return the document manager
     *
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->_dm;
    }

    public function persist($document)
    {
        if (!is_object($document)) {
            throw new \InvalidArgumentException(gettype($document));
        }

        $this->dm->persist($document);
    }

    public function flush()
    {
        $this->dm->flush();
    }

    public function remove($document)
    {
        if (!is_object($document)) {
            throw new \InvalidArgumentException(gettype($document));
        }

        $this->dm->remove($document);
    }

    public function findMenuById($id)
    {
        return $this->repository->findOneById($id);
    }

    public function findMenuBySlug($slug)
    {
        return $this->repository->findOneBySlug($slug);
    }

    public function getDocumentRepository()
    {
        return $this->repository;
    }

    /**
     * Create a new Item Object
     *
     * @return $config object
     */
    public function createMenu()
    {
        $class  = $this->getClass();
        $item   = new $class;

        return $item;
    }

    protected function getClass()
    {
        return $this->class;
    }
}
