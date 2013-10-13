<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\MenuBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Black\Bundle\MenuBundle\Model\MenuInterface;
use Black\Bundle\MenuBundle\Model\MenuManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class MenuFormHandler
 *
 * @package Black\Bundle\MenuBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuFormHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var MenuManagerInteface|\Black\Bundle\MenuBundle\Model\MenuManagerInterface
     */
    protected $menuManager;

    /**
     * @var
     */
    protected $factory;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface $form
     * @param MenuManagerInterface $menuManager
     * @param Request $request
     * @param Router $router
     * @param SessionInterface $session
     */
    public function __construct(FormInterface $form, MenuManagerInterface $menuManager, Request $request, Router $router, SessionInterface $session)
    {
        $this->form         = $form;
        $this->menuManager  = $menuManager;
        $this->request      = $request;
        $this->router       = $router;
        $this->session      = $session;
    }

    /**
     * @param MenuInterface $menu
     *
     * @return bool
     */
    public function process(MenuInterface $menu)
    {
        $this->form->setData($menu);

        if ('POST' === $this->request->getMethod()) {

            $this->form->handleRequest($this->request);

            if ($this->form->has('delete') && $this->form->get('delete')->isClicked()) {
                return $this->onDelete($menu);
            }

            if ($this->form->isValid()) {
                return $this->onSave($menu);
            } else {
                return $this->onFailed();
            }
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $name
     * @param $msg
     * @return mixed
     */
    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }

    /**
     * @param PageInterface $menu
     *
     * @return mixed
     */
    protected function onSave(MenuInterface $menu)
    {
        var_dump($menu->getItems());
        die;

        $this->menuManager->persist($menu);

        if (!$menu->getId()) {
            $this->menuManager->flush();
        }

        if ($this->form->get('save')->isClicked()) {
            $this->setUrl($this->generateUrl('admin_menu_edit', array('id' => $menu->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setUrl($this->generateUrl('admin_menu_new'));

            return true;
        }
    }

    /**
     * @param $menu
     *
     * @return bool
     */
    protected function onDelete($menu)
    {
        $this->menuManager->remove($menu);
        $this->menuManager->flush();

        $this->setFlash('success', 'success.page.admin.page.delete');
        $this->setUrl($this->generateUrl('admin_menu_index'));

        return true;
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->setFlash('error', 'error.page.admin.page.not.valid');

        return false;
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param       $referenceType
     *
     * @return mixed
     */
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }
}
