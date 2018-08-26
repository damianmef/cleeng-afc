<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 17.08.18
 * Time: 12:23
 */

namespace AppBundle\Controller\ForTwigView;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HeaderFooterController extends Controller
{
    public function getHeaderAction()
    {
        $headerResult = [
            'isAdmin' => $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'),
            'isUser' => $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'),
            'username' => is_object($this->get('security.token_storage')->getToken()->getUser()) ?
                $this->get('security.token_storage')->getToken()->getUser() ->getUsername()
                : null
        ];
        return $this->render('AppBundle:HeaderFooter:header.html.twig', $headerResult);
    }

    /**
     * @return Response
     */
    public function getFooterAction()
    {
        return $this->render('AppBundle:HeaderFooter:footer.html.twig', []);
    }
}