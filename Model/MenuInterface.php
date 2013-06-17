<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Model;

interface MenuInterface
{
    function getId();
    
    function setName($name);
    function getName();
    
    function getSlug();
    
    function setDescription($description);
    function getDescription();
    
    function setItems($items);
    function addItem($item);
    function removeItem($item);
    function getItems();
}