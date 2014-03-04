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

use Black\Bundle\CommonBundle\Controller\CommonController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class MenuController
 *
 * @Route("/menu", service="black_menu.controller.menu")
 *
 * @package Black\Bundle\MenuBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuController extends CommonController
{
    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="menu_create")
     * @Template()
     *
     * @return array
     */
    public function createAction()
    {
        return parent::createAction();
    }

    /**
     * @Method({"POST", "GET"})
     * @Route("/{value}/delete", name="menu_delete")
     *
     * @param $value
     *
     * @return mixed
     */
    public function deleteAction($value)
    {
        return parent::deleteAction($value);
    }

    /**
     * @Method("GET")
     * @Route("/index.html", name="menu_index")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return parent::indexAction();
    }

    /**
     * @param string $value
     *
     * @Method("GET")
     * @Route("/where/{value}", name="_find_where_menu")
     * @Template()
     *
     * @return Template
     */
    public function internalMenuAction($value)
    {
        $documentManager    = $this->configuration->getManager();
        $document           = $documentManager->findMenuWhereItem($value);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document'  => $document,
            'path'      => $this->configuration->getRequest()->get('path')
        );
    }

    /**
     * @param string $value
     *
     * @Method("GET")
     * @Route("/{value}", name="_find_menu")
     * @Template()
     *
     * @return Template
     */
    public function menuAction($value)
    {
        $documentManager    = $this->configuration->getManager();
        $document           = $documentManager->findDocument($value);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document'  => $document,
            'path'      => $this->configuration->getRequest()->get('path')
        );
    }

    /**
     * @Method("GET")
     * @Route("/{value}.html", name="menu_read")
     * @Template()
     *
     * @param string $slug
     *
     * @return Template
     */
    public function readAction($value)
    {
        return parent::readAction($value);
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/{value}/update", name="menu_update")
     * @Template()
     *
     * @param $value
     *
     * @return mixed
     */
    public function updateAction($value)
    {
        return parent::updateAction($value);
    }
}
