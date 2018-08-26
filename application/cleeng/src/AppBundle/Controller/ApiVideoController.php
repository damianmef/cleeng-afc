<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 21.08.18
 * Time: 20:50
 */

namespace AppBundle\Controller;


use AppBundle\Model\Video\VideoHelper;
use AppBundle\Model\Video\VideoProcess;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApiVideoController extends Controller
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
     * @Rest\Get("/api/video")
     * @param VideoProcess $videoProcess
     * @return JsonResponse
     */
    public function getAction(VideoProcess $videoProcess)
    {
        $result = $videoProcess->getItems();
        $result->setData(VideoHelper::convertObjectsToArray($videoProcess->getItems()->getData()));
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Post("/api/video")
     * @param VideoProcess $videoProcess
     * @return JsonResponse
     */
    public function addAction(VideoProcess $videoProcess)
    {
        $result = $videoProcess->addItem();
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Put("/api/video/{id}")
     * @param VideoProcess $videoProcess
     * @return JsonResponse
     */
    public function editAction(VideoProcess $videoProcess)
    {
        $result = $videoProcess->editItem();
        return new JsonResponse($result->toArray());
    }

    /**
     * @Rest\Delete("/api/video/{id}")
     * @param VideoProcess $videoProcess
     * @return JsonResponse
     */
    public function deleteAction(VideoProcess $videoProcess)
    {
        $result = $videoProcess->deleteItem();
        return new JsonResponse($result->toArray());
    }
}