<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 24.08.18
 * Time: 10:22
 */

namespace AppBundle\Controller;

use AppBundle\Model\User\UserProcess;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */

class UserController extends Controller
{
    /**
     * @var Route $route
     */
    protected $route;

    /**
     * @Route("/", name="user_videos")
     * @param UserProcess $userProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listVideoAction(UserProcess $userProcess)
    {
        $userProcess->setUser($this->get('security.token_storage')->getToken()->getUser());
        $responseValues = [
            'subscription' => $userProcess->getUserSubscription(),
            'videos' => $userProcess->getUserVideos(),
            'user' => $userProcess->getUser()
        ];
        return $this->render('AppBundle:Video:user_list.html.twig', $responseValues);
    }

    /**
     * @Route("/subscription", name="user_subscription")
     * @param UserProcess $userProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscriptionAction(UserProcess $userProcess)
    {
        $userProcess->setUser($this->get('security.token_storage')->getToken()->getUser());
        $userProcess->subscriptionChange();
        return $this->render(
            'AppBundle:Subscription:user_list.html.twig',
            [
                'variables' =>
                    $userProcess->getSubscriptionsForUser(),
                'user' => $userProcess->getUser(),
            ]
        );
    }

    /**
     * @Route("/video/{id}", name="user_video")
     * @param UserProcess $userProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function videoAction(UserProcess $userProcess, $id)
    {
        $userProcess->setUser($this->get('security.token_storage')->getToken()->getUser());
        $responseValues = [
            'video' => $userProcess->getUserVideo($id),
            'user' => $userProcess->getUser()
        ];
        return $this->render('AppBundle:Video:user_video.html.twig', $responseValues);
    }
}
