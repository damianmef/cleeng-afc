<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 19:57
 */

namespace AppBundle\Model\Subscription;


use AppBundle\Entity\Subscription;
use AppBundle\Model\AbstractHelper;
use AppBundle\Model\HelperInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionHelper extends AbstractHelper implements HelperInterface
{
    public static $entityName = 'Subscription';
    public static $validateFields = [
        'subscription-title',
        'subscription-name',
        'subscription-parent'
    ];


    /**
     * @param EntityManager $entityManager
     * @param Request $request
     * @return bool
     * @throws ORMException
     */
    public static function addItem(EntityManager $entityManager, Request $request) : bool
    {
        $subscription = new Subscription();
        $subscription->setTitle($request->get('subscription-title'));
        $subscription->setName($request->get('subscription-name'));
        $subscription->setParent($request->get('subscription-parent'));
        try {
            $entityManager->persist($subscription);
            $entityManager->flush();
        } catch (OptimisticLockException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param EntityManager $entityManager
     * @param Request $request
     * @return bool
     * @throws ORMException
     */
    public static function updateItem(EntityManager $entityManager, Request $request) : bool
    {
        /**
         * @var Subscription $subscription
         */
        $subscription = $entityManager->getRepository('AppBundle:Subscription')
            ->findOneBy(['id' => $request->get('id')]);

        if (!empty($subscription)) {
            try {
                $subscription->setTitle($request->get('subscription-title'));
                $subscription->setName($request->get('subscription-name'));
                $subscription->setParent($request->get('subscription-parent'));
                $entityManager->flush();
                return true;
            } catch (OptimisticLockException $e) {
                return false;
            }
        }
        return false;
    }

}