<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Controller;

use Psr\Log\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class MenuController
 *
 * @Route("/menu")
 *
 * @package Black\Bundle\MenuBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuController extends Controller
{
    /**
     * @param       $key
     *
     * @Method("GET")
     * @Route("/{key}", name="_find_menu")
     * @Template()
     *
     * @return Template
     */
    public function menuAction($key)
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->findMenuByIdOrSlug($key);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document'  => $document,
            'path'      => $this->getRequest()->get('path')
        );
    }

    /**
     * @param string $key
     *
     * @Method("GET")
     * @Route("/where/{key}", name="_find_where_menu")
     * @Template()
     *
     * @return Template
     */
    public function internalMenuAction($key)
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->findMenuWhereItem($key);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document'  => $document,
            'path'      => $this->getRequest()->get('path')
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_menu.manager.menu');
    }
}
