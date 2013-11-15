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

use Black\Bundle\MenuBundle\Exception\MenuNotFoundException;
use Psr\Log\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AdminMenuController
 *
 * @Route("/admin/menu")
 *
 * @package Black\Bundle\MenuBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class AdminMenuController extends Controller
{
    /**
     * Show lists of Menus
     *
     * @Method("GET")
     * @Route("/index.html", name="admin_menu_index")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     * @return Template
     */
    public function indexAction()
    {
        $documentManager    = $this->getManager();
        $repository         = $documentManager->getRepository();

        $rawDocuments       = $repository->findAll();
        $csrf               = $this->container->get('form.csrf_provider');

        $documents = array();

        foreach ($rawDocuments as $document) {

            $documents[] = array(
                'id'                        => $document->getId(),
                'black.bundle.menu.menu.name.text' => $document->getName()
            );
        }

        return array(
            'documents' => $documents,
            'csrf'      => $csrf
        );
    }

    /**
     * Displays a form to create a new menu document.
     *
     * @Method({"GET", "POST"})
     * @Route("/new", name="admin_menu_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     * @return Template
     */
    public function newAction()
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->createInstance();

        $formHandler    = $this->get('black_menu.menu.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {

            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'document'  => $document,
            'form'      => $formHandler->getForm()->createView()
        );
    }

    /**
     * Displays a form to edit an existing Menu document.
     *
     * @param string $id The document ID
     * 
     * @Method({"GET", "POST"})
     * @Route("/{id}/edit", name="admin_menu_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function editAction($id)
    {
        $documentManager = $this->getManager();
        $repository = $documentManager->getRepository();

        $document = $repository->findOneById($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Menu document.');
        }

        $formHandler    = $this->get('black_menu.menu.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'document'      => $document,
            'form'          => $formHandler->getForm()->createView()
        );
    }

    /**
     * Deletes a Menu document.
     * 
     * @param string $id    The document ID
     * @param string $token Token
     *
     * @Method({"POST", "GET"})
     * @Route("/{id}/delete/{token}", name="admin_menu_delete")
     * @Secure(roles="ROLE_ADMIN")
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function deleteAction($id, $token = null)
    {
        $form       = $this->createDeleteForm($id);
        $request    = $this->getRequest();

        $form->handleRequest($request);

        if (null !== $token) {
            $token = $this->get('form.csrf_provider')->isCsrfTokenValid('delete' . $id, $token);
        }

        if ($form->isValid() || true === $token) {

            $dm         = $this->getManager();
            $repository = $dm->getRepository();
            $document   = $repository->findOneById($id);

            if (!$document) {
                throw new MenuNotFoundException();
            }

            $dm->remove($document);
            $dm->flush();

            $this->get('session')->getFlashBag()->add('success', 'black.bundle.menu.success.menu.admin.delete');

        } else {
            $this->getFlashBag->add('error', 'black.bundle.menu.error.menu.admin.delete.not.valid');
        }

        return $this->redirect($this->generateUrl('admin_menu_index'));
    }

    /**
     * Batch actions for menu document.
     *
     * @Method({"POST"})
     * @Route("/batch", name="admin_menu_batch")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws InvalidArgumentException
     *
     * @throws \Symfony\Component\Serializer\Exception\InvalidArgumentException If method does not exist
     */
    public function batchAction()
    {
        $request    = $this->getRequest();
        $token      = $this->get('form.csrf_provider')->isCsrfTokenValid('batch', $request->get('token'));

        if (!$ids = $request->get('ids')) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.menu.error.menu.admin.batch.no.item');

            return $this->redirect($this->generateUrl('admin_menu_index'));
        }

        if (!$action = $request->get('batchAction')) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.menu.error.menu.admin.batch.no.action');

            return $this->redirect($this->generateUrl('admin_menu_index'));
        }

        if (!method_exists($this, $method = $action . 'Action')) {
            throw new InvalidArgumentException(
                sprintf('You must create a "%s" method for action "%s"', $method, $action)
            );
        }

        if (false === $token) {
            $this->get('session')->getFlashBag()->add('error', 'black.bundle.menu.error.menu.admin.batch.csrf');

            return $this->redirect($this->generateUrl('admin_menu_index'));
        }

        foreach ($ids as $id) {
            $this->$method($id, $token);
        }

        return $this->redirect($this->generateUrl('admin_menu_index'));

    }

    private function createDeleteForm($id)
    {
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();

        return $form;
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
