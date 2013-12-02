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
use Black\Bundle\CommonBundle\Configuration\Configuration;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Black\Bundle\CommonBundle\Form\Handler\HandlerInterface;
use Black\Bundle\MenuBundle\Model\MenuInterface;

/**
 * Class MenuFormHandler
 *
 * @package Black\Bundle\MenuBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class MenuFormHandler implements HandlerInterface
{
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;
    /**
     * @var
     */
    protected $configuration;
    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface $form
     * @param Configuration $configuration
     */
    public function __construct(
        FormInterface $form,
        Configuration $configuration
    )
    {
        $this->form             = $form;
        $this->configuration    = $configuration;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param MenuInterface $menu
     *
     * @return bool
     */
    public function process($menu)
    {
        $this->form->setData($menu);

        if ('POST' === $this->configuration->getRequest()->getMethod()) {

            $this->form->handleRequest($this->configuration->getRequest());

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
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param       $referenceType
     *
     * @return mixed
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->configuration->getRouter()->generate($route, $parameters, $referenceType);
    }

    /**
     * @param $menu
     *
     * @return bool
     */
    protected function onDelete(MenuInterface $menu)
    {
        $this->configuration->getManager()->remove($menu);
        $this->configuration->getManager()->flush();

        $this->configuration->setFlash('success', 'black.bundle.menu.success.menu.admin.delete');
        $this->setUrl($this->generateUrl($this->configuration->getParameter('route')['index']));

        return true;
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->configuration->setFlash('error', 'black.bundle.menu.error.menu.admin.edit.not.valid');

        return false;
    }

    /**
     * @param MenuInterface $menu
     *
     * @return bool
     */
    protected function onSave(MenuInterface $menu)
    {
        if (!$menu->getId()) {
            $this->configuration->getManager()->persist($menu);
        }

        $this->configuration->getManager()->flush();

        if ($this->form->get('save')->isClicked()) {
            $this->setUrl($this->generateUrl($this->configuration->getParameter('route')['update'], array('id' => $menu->getId())));
            $this->configuration->setFlash('success', 'black.bundle.menu.success.menu.admin.save');

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setUrl($this->generateUrl($this->configuration->getParameter('route')['create']));
            $this->configuration->setFlash('success', 'black.bundle.menu.success.menu.admin.saveAndAdd');

            return true;
        }
    }
}
