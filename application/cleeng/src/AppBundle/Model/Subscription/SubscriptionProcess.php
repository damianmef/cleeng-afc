<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 18:59
 */

namespace AppBundle\Model\Subscription;

use AppBundle\Model\AbstractProcess;
use AppBundle\Model\ProcessInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class SubscriptionProcess extends AbstractProcess implements ProcessInterface
{
    public function __construct(EntityManager $entityManager, RequestStack $requestStack)
    {
        parent::__construct($entityManager, $requestStack);
        $this->helper = new SubscriptionHelper();
    }
}
