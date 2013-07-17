<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\MenuBundle\Model;

/**
 * MenuManagerInterface
 */
interface MenuManagerInterface
{
    /**
     * @return mixed
     */
    public function getManager();

    /**
     * @return mixed
     */
    public function getRepository();

    /**
     * @return mixed
     */
    public function createInstance();
}
