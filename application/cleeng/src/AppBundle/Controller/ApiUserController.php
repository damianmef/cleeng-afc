<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26.08.18
 * Time: 16:05
 */

namespace AppBundle\Controller;

use AppBundle\Model\User\UserHelper;
use AppBundle\Model\User\UserProcess;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApiUserController
{
    /**
     * @var Route $route
     */
    protected $route;

    /**
     * @var Rest\ $rest
     */
    protected $rest;

    /**
     * @Rest\Get("/api/user/videos/{id}")
     * @param UserProcess $userProcess
     * @return JsonResponse
     */
    public function getVideosAction(UserProcess $userProcess, $id)
    {
        $user = UserHelper::getItem($userProcess->entityManager, $id);
        $userProcess->setUser($user);
        $result = $userProcess->getUserVideos();
        $result->setData(UserHelper::convertObjectsToArray($result->getData()));
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Get("/api/user/subscription/{id}")
     * @param UserProcess $userProcess
     * @return JsonResponse
     */
    public function getSubscriptionAction(UserProcess $userProcess, $id)
    {
        $user = UserHelper::getItem($userProcess->entityManager, $id);
        $userProcess->setUser($user);
        $result = $userProcess->getUserSubscription();
        $result->setData(UserHelper::convertObjectsToArray($result->getData()));
        return new JsonResponse($result->toArray());
    }
}
