<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 24.08.18
 * Time: 10:32
 */

namespace AppBundle\Model\User;

use AppBundle\Entity\User;
use AppBundle\Model\AbstractHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class UserHelper extends AbstractHelper
{
    public static $entityName = 'User';
    public static $validateFields = [
        'user-email',
        'user-subscription',
        'user-username'
    ];

    public static function updateItem(EntityManager $entityManager, Request $request) : bool
    {
        /**
         * @var User $user
         */
        $user = $entityManager->getRepository('AppBundle:User')
            ->findOneBy(['id' => $request->get('id')]);

        if (!empty($user)) {
            try {
                $user->setEmail($request->get('user-email'));
                $user->setUsername($request->get('user-username'));
                $user->setSubscriptionType($request->get('user-subscription'));
                $entityManager->flush();
                return true;
            } catch (ORMException $e) {
                return false;
            }
        }
        return false;
    }
}