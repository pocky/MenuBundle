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
     * @param int $id
     * 
     * @Method("GET")
     * @Route("/{id}", name="_find_menu")
     * @Template()
     * 
     * @return Template
     */
    public function menuAction($id)
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->findMenuById($id);

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
    protected function getManager()
    {
        return $this->get('black_menu.manager.menu');
    }
}
