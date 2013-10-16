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
 * Class RepositoryInterface
 *
 * @package Black\Bundle\MenuBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface RepositoryInterface
{
    /**
     * @param $key
     *
     * @return mixed
     */
    function getMenuByIdOrSlug($key);

    /**
     * @param $key
     *
     * @return mixed
     */
    function getMenuWhereItem($key);
}
