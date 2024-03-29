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
 * Class MenuRepositoryInterface
 *
 * @package Black\Bundle\MenuBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface MenuRepositoryInterface
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function getMenuByIdOrSlug($key);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getMenuWhereItem($key);
}
