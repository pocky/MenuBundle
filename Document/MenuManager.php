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

use Black\Bundle\EngineBundle\Document\BaseManager;

class MenuManager extends BaseManager
{
    public function findMenuById($id)
    {
        return $this->repository->findOneById($id);
    }

    public function findMenuBySlug($slug)
    {
        return $this->repository->findOneBySlug($slug);
    }
}
