<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 24.08.18
 * Time: 10:35
 */

namespace AppBundle\Model\User;


use AppBundle\Entity\Subscription;
use AppBundle\Entity\User;
use AppBundle\Entity\Video;
use AppBundle\Model\AbstractProcess;
use AppBundle\Model\ProcessResponseObject;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UserProcess extends AbstractProcess
{
    public $response;

    /**
     * @var Request $request
     */
    public $request;
    public $helper;
    /**
     * @var User $user
     */
    protected $user;

    protected $subscriptionsAll = [];

    public function __construct(EntityManager $entityManager, RequestStack $requestStack)
    {
        parent::__construct($entityManager, $requestStack);
        $this->helper = new UserHelper();
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $id
     * @return ProcessResponseObject
     */
    public function getUserVideo(int $id) : ProcessResponseObject
    {
        $this->response = new ProcessResponseObject();
        if ($this->getUser()->isSubscriptionAvailable()) {
            if ($this->isVideoInVideos($this->getUserVideos(), $id)) {
                $this->response->setStatus(true);
                $this->response->setData(
                    ['items' => $this->entityManager->getRepository('AppBundle:Video')->findBy(['id' => $id])]
                );
            } else {
                $this->response->setStatus(false);
            }
        }

        return $this->response;
    }

    /**
     * @return ProcessResponseObject
     */
    public function getUserVideos() : ProcessResponseObject
    {
        $this->response = new ProcessResponseObject();
        if ($this->getUser()->isSubscriptionAvailable()) {
            $this->response->setStatus(true);
            $this->response->setData(
                ['items' => $this->entityManager->getRepository('AppBundle:Video')->findBy(['subscription' => $this->findAllSubscriptionInTree()])]
            );

        }

        return $this->response;
    }


    /**
     * @return ProcessResponseObject
     */
    public function getUserSubscription() : ProcessResponseObject
    {
        $this->response = new ProcessResponseObject();
        if ($this->getUser()->isSubscriptionAvailable()) {
            $this->response->setStatus(true);
            $this->response->setData(
                $this->entityManager->getRepository('AppBundle:Subscription')->findBy(['id' => [$this->getUser()->getSubscriptionType()]])
            );

        }

        return $this->response;
    }


    /**
     * @return ProcessResponseObject
     */
    public function getSubscriptionsForUser() : ProcessResponseObject
    {
        $this->response = new ProcessResponseObject();
//        if (UserHelper::isSubscriptionDateValid($user)) {
            $this->response->setStatus(true);
            $this->response->setData(
                ['items' => $this->entityManager->getRepository('AppBundle:Subscription')->findAll(
                    ['id' => $this->findAllSubscriptionInTree()]
                )]
            );

//        }


        return $this->response;
    }

    /**
     * @return bool
     */
    public function subscriptionChange()
    {
        if ($this->request->isMethod('post')) {
            /**
             * @var User $user
             */
            $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['id' => $this->user->getId()]);

            if (!empty($user)) {
                try {
                    $user->setSubscriptionType($this->request->get('subscription-id'));
                    $time = new \DateTime();
                    $time->add(new \DateInterval('PT5M'));
                    $user->setSubscriptionEndTime($time);
                    $this->entityManager->flush();
                    return true;
                } catch (ORMException $e) {
                    return false;
                }
            }
        }
        
        return false;
    }

    /**
     * @return array
     */
    protected function findAllSubscriptionInTree()
    {
        /**
         * @var Subscription $subscription
         */
        $subscription = $this->entityManager->getRepository('AppBundle:Subscription')
            ->findOneBy(['id' => [$this->getUser()->getSubscriptionType()]]);
        $this->findInTree($subscription);
        $result = $this->getIdsFromSubscriptions();

        return $result;
    }

    /**
     * @param Subscription $subscription
     */
    protected function findInTree(Subscription $subscription)
    {
        array_push($this->subscriptionsAll, $subscription);
        /**
         * @var Subscription $subscriptionsBelow
         */
        $subscriptionsBelow = $this->entityManager->getRepository('AppBundle:Subscription')
            ->findBy(['parent' => [$subscription->getId()]]);
        if (!empty($subscriptionsBelow)) {
            foreach($subscriptionsBelow as $subscription) {
                $this->findInTree($subscription);
            }
        }
    }

    /**
     * @return array
     */
    protected function getIdsFromSubscriptions() : array
    {
        $result = [];
        /**
         * @var Subscription $subscription
         */
        foreach ($this->subscriptionsAll as $subscription) {
            array_push($result, $subscription->getId());
        }
        return $result;
    }

    protected function isVideoInVideos(ProcessResponseObject $videos, int $videoId)
    {
        $videos = $videos->getData();
        if (!empty($videos['items'])) {
            /**
             * @var Video $video
             */
            foreach ($videos['items'] as $video) {
                if ($video->getId() === $videoId) {
                    return true;
                }
            }
        }
        return false;
    }
}

