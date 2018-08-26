<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 19:38
 */

namespace AppBundle\Model;

use AppBundle\Model\Subscription\SubscriptionHelper;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractProcess
{
    /**
     * @var EntityManager $entityManager
     */
    public $entityManager;

    /**
     * @var RequestStack $request
     */
    public $request;

    /**
     * @var ProcessResponseObject $response
     */
    public $response;

    /**
     * @var HelperInterface $helper
     */
    public $helper;

    /**
     * @var bool
     */
    public $isTest = false;

    /**
     * AbstractProcess constructor.
     * @param EntityManager $entityManager
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->response = new ProcessResponseObject();
    }
    /**
     * @return ProcessResponseObject
     */
    public function getItems() : ProcessResponseObject
    {
        $this->response = new ProcessResponseObject();
        $this->response->setStatus(true);
        $this->response->setData(['items' => $this->addKeys($this->helper->getItems($this->entityManager))]);
        return $this->response;
    }


    /**
     * @return ProcessResponseObject
     */
    public function addItem() : ProcessResponseObject
    {
        $this->checkTest();
        if ($this->request->isMethod('post')) {
            if ($this->helper::validatePostData($this->request)) {
                if ($this->isTest or $this->helper::addItem($this->entityManager, $this->request)) {
                    $this->response->setStatus(true);
                    $this->response->setMsg('Item was added succesfull');
                }
            } else {
                $this->response->setMsg('Input data are not correct');
            }
        }

        return $this->response;
    }

    /**
     * @return ProcessResponseObject
     */
    public function editItem() : ProcessResponseObject
    {
        $this->checkTest();
        $this->response = new ProcessResponseObject();
        if ($this->request->isMethod('post') or $this->request->isMethod('put')) {
            if ($this->helper::validateEditPostData($this->request)) {
                if ($this->isTest or $this->helper::updateItem($this->entityManager, $this->request)) {
                    $this->response->setStatus(true);
                    $this->response->setMsg('Item was updated succesfull');
                }
            } else {
                $this->response->setMsg('Input data are not correct');
            }
        }
        $this->response->updateData(
            [
                'item' => $this->helper::getItem($this->entityManager, $this->request->get('id')),
                'subscriptions' => SubscriptionHelper::getItems($this->entityManager)
            ]
        );

        return $this->response;
    }

    /**
     * @return ProcessResponseObject
     */
    public function deleteItem() : ProcessResponseObject
    {
        if (($this->request->isMethod('get') or $this->request->isMethod('delete')) and
            !empty($this->request->get('id'))) {
            if($this->isTest or $this->helper::deleteItem($this->entityManager, $this->request->get('id'))) {
                $this->response->setStatus(true);
                $this->response->setMsg('Item was deleted succesfull');
            } else {
                $this->response->setMsg('Error while deleting item');
            }
        }

        return $this->response;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param array $items
     * @return array
     */
    public function addKeys(array $items)
    {
        $results = [];
        foreach ($items as $item) {
            $results[$item->getId()] = $item;
        }

        return $results;
    }

    private  function checkTest()
    {
        if (!empty($this->request->get('test'))) {
            $this->isTest = true;
        }
    }
}