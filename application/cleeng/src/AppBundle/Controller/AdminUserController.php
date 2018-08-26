<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 16.08.18
 * Time: 21:59
 */

namespace AppBundle\Controller;

use AppBundle\Model\Subscription\SubscriptionHelper;
use AppBundle\Model\User\UserProcess;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/user")
 */

class AdminUserController extends Controller
{
    /**
     * @var Route $route
     */
    protected $route;

    /**
     * @Route("/", name="user_list")
     * @param UserProcess $userProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listUsersAction(UserProcess $userProcess)
    {
        return $this->render('AppBundle:User:list.html.twig', [
            'variables' => $userProcess->getItems(),
            'subscriptions' => $userProcess->addKeys(SubscriptionHelper::getItems($userProcess->getEntityManager()))
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit")
     * @param UserProcess $userProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editUserAction(UserProcess $userProcess)
    {
        return $this->render('AppBundle:User:edit.html.twig',  ['variables' => $userProcess->editItem()]);
    }

    /**
     * @Route("/delete/{id}", name="user_delete")
     * @param UserProcess $userProcess
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteUserAction(UserProcess $userProcess)
    {
        return new JsonResponse(['variables' => $userProcess->deleteItem()->toArray()]);
    }

}