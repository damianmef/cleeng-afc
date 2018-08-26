<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 22.08.18
 * Time: 20:12
 */

namespace AppBundle\Controller;


use AppBundle\Model\Subscription\SubscriptionHelper;
use AppBundle\Model\Subscription\SubscriptionProcess;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ApiSubscriptionController
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
     * @Rest\Get("/api/subscription")
     * @param SubscriptionProcess $subscriptionProcess
     * @return JsonResponse
     */
    public function getAction(SubscriptionProcess $subscriptionProcess)
    {
        $result = $subscriptionProcess->getItems();
        $result->setData(SubscriptionHelper::convertObjectsToArray($subscriptionProcess->getItems()->getData()));
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Post("/api/subscription")
     * @param SubscriptionProcess $subscriptionProcess
     * @return JsonResponse
     */
    public function addAction(SubscriptionProcess $subscriptionProcess)
    {
        $result = $subscriptionProcess->addItem();
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Put("/api/subscription/{id}")
     * @param SubscriptionProcess $subscriptionProcess
     * @return JsonResponse
     */
    public function editAction(SubscriptionProcess $subscriptionProcess)
    {
        $result = $subscriptionProcess->editItem();
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Delete("/api/subscription/{id}")
     * @param SubscriptionProcess $subscriptionProcess
     * @return JsonResponse
     */
    public function deleteAction(SubscriptionProcess $subscriptionProcess)
    {
        $result = $subscriptionProcess->deleteItem();
        return new JsonResponse($result->toArray());
    }
}