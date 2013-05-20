<?php

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
 * Controller managing the person profile`
 *
 * @Route("/menu")
 */
class MenuController extends Controller
{
    /**
     * Get a menu (embed action)
     *
     * @Method("GET")
     * @Route("/{slug}", name="_find_menu")
     * @Template()
     */
    public function menuAction($slug)
    {
        $documentManager    = $this->getDocumentManager();
        $document           = $documentManager->findMenuBySlug($slug);

        if (!$document) {
            $document = array('items' => array());
        }

        return array(
            'document' => $document,
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->get('black_menu.manager.menu');
    }
}
