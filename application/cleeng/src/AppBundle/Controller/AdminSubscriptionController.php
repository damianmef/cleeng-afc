<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 16.08.18
 * Time: 22:00
 */

namespace AppBundle\Controller;

use AppBundle\Model\Subscription\SubscriptionProcess;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/subscription")
 */

class AdminSubscriptionController extends Controller
{
    /**
     * @var Route $route
     */
    protected $route;

    /**
     * @Route("/", name="subscription_list")
     * @param SubscriptionProcess $subscriptionProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listSubscriptionAction(SubscriptionProcess $subscriptionProcess)
    {
        return $this->render('AppBundle:Subscription:list.html.twig', ['variables' => $subscriptionProcess->getItems()]);
    }

    /**
     * @Route("/add/", name="subscription_add")
     * @param SubscriptionProcess $subscriptionProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addSubscriptionAction(SubscriptionProcess $subscriptionProcess)
    {


        return $this->render('AppBundle:Subscription:add.html.twig',  [
            'variables' =>[
                'add' =>$subscriptionProcess->addItem(),
                'items' => $subscriptionProcess->getItems()
            ]
        ]);
    }

    /**
     * @Route("/edit/{id}", name="subscription_edit")
     * @param SubscriptionProcess $subscriptionProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editSubscriptionAction(SubscriptionProcess $subscriptionProcess)
    {
        return $this->render('AppBundle:Subscription:edit.html.twig', [
            'variables' =>[
                'edit' =>$subscriptionProcess->editItem(),
                'items' => $subscriptionProcess->getItems()
            ]
        ]);
    }

    /**
     * @Route("/delete/{id}", name="subscription_delete")
     * @param SubscriptionProcess $subscriptionProcess
     * @return JsonResponse
     */
    public function deleteSubscriptionAction(SubscriptionProcess $subscriptionProcess)
    {
        return new JsonResponse(['variables' => $subscriptionProcess->deleteItem()->toArray()]);
    }
}
