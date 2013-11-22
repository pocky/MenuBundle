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

use Black\Bundle\CommonBundle\Controller\ControllerInterface;
use Black\Bundle\CommonBundle\Doctrine\ManagerInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class MenuController
 *
 * @Route("/menu", service="black_menu.controller.menu")
 *
 * @package Black\Bundle\MenuBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuController implements ControllerInterface
{
    /**
     * @var \Black\Bundle\CommonBundle\Controller\ControllerInterface
     */
    protected $controller;
    /**
     * @var \Black\Bundle\CommonBundle\Form\Handler\HandlerInterface
     */
    protected $handler;
    /**
     * @var \Black\Bundle\CommonBundle\Doctrine\ManagerInterface
     */
    protected $manager;

    /**
     * @param ControllerInterface    $controller
     * @param HttpExceptionInterface $exception
     * @param ManagerInterface       $manager
     * @param HandlerInterface       $handler
     */
    public function __construct(
        ControllerInterface $controller,
        HttpExceptionInterface $exception,
        ManagerInterface $manager,
        HandlerInterface $handler
    )
    {
        $this->controller   = $controller;
        $this->manager      = $manager;
        $this->handler      = $handler;

        $controller->setException($exception);
        $controller->setManager($manager);
        $controller->setHandler($handler);
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/new", name="menu_create")
     * @Template()
     *
     * @return array
     */
    public function createAction()
    {
        return $this->controller->createAction();
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
        return $this->controller->deleteAction($value);
    }

    /**
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return HandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return ManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
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
        return $this->controller->indexAction();
    }

    /**
     * @param string $key
     *
     * @Method("GET")
     * @Route("/where/{value}", name="_find_where_menu")
     * @Template()
     *
     * @return Template
     */
    public function internalMenuAction($value)
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->findMenuWhereItem($value);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document'  => $document,
            'path'      => $this->controller->getRequest()->get('path')
        );
    }

    /**
     * @param string $key
     *
     * @Method("GET")
     * @Route("/{value}", name="_find_menu")
     * @Template()
     *
     * @return Template
     */
    public function menuAction($value)
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->findDocument($value);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document'  => $document,
            'path'      => $this->controller->getRequest()->get('path')
        );
    }

    /**
     * @Method("GET")
     * @Route("/{value}.html", name="menu_show")
     * @Template()
     *
     * @param string $slug
     *
     * @return Template
     */
    public function showAction($value)
    {
        return $this->controller->showAction($value);
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
        return $this->controller->updateAction($value);
    }
}
