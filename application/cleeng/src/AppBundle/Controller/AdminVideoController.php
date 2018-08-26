<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 17.08.18
 * Time: 17:08
 */

namespace AppBundle\Controller;

use AppBundle\Model\Subscription\SubscriptionHelper;
use AppBundle\Model\Subscription\SubscriptionProcess;
use AppBundle\Model\Video\VideoProcess;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/video")
 */

class AdminVideoController extends Controller
{
    /**
     * @var Route $route
     */
    protected $route;

    /**
     * @Route("/", name="video_list")
     * @param VideoProcess $videoProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listVideosAction(VideoProcess $videoProcess)
    {
        return $this->render('AppBundle:Video:list.html.twig', [
            'variables' => $videoProcess->getItems(),
            'subscriptions' => SubscriptionHelper::getItems($videoProcess->getEntityManager())
        ]);
    }

    /**
     * @Route("/add/", name="video_add")
     * @param VideoProcess $videoProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addVideoAction(VideoProcess $videoProcess)
    {
        return $this->render('AppBundle:Video:add.html.twig',  [
            'variables' => $videoProcess->addItem(),
            'subscriptions' => SubscriptionHelper::getItems($videoProcess->getEntityManager())
        ]);
    }

    /**
     * @Route("/edit/{id}", name="video_edit")
     * @param VideoProcess $videoProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editVideoAction(VideoProcess $videoProcess)
    {
        return $this->render('AppBundle:Video:edit.html.twig',  [
            'variables' => $videoProcess->editItem(),
            'subscriptions' => SubscriptionHelper::getItems($videoProcess->getEntityManager())
        ]);
    }

    /**
     * @Route("/delete/{id}", name="video_delete")
     * @param VideoProcess $videoProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteVideoAction(VideoProcess $videoProcess)
    {
        return new JsonResponse(['variables' => $videoProcess->deleteItem()->toArray()]);
    }
}