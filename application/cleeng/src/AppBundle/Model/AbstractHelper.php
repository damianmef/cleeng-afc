<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 25.08.18
 * Time: 12:33
 */

namespace AppBundle\Model;


use AppBundle\Entity\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class AbstractHelper implements HelperInterface
{
    public static $entityName = '';
    public static $validateFields = [];

    /**
     * @param EntityManager $entityManager
     * @param int $itemId
     * @return mixed|null|object
     */
    public static function getItem(EntityManager $entityManager, int $itemId) : ?object
    {
        return $entityManager->getRepository('AppBundle:' . static::$entityName)
            ->findOneBy(['id' => $itemId]);
    }

    /**
     * @param EntityManager $entityManager
     * @return array
     */
    public static function getItems(EntityManager $entityManager) : array
    {
        return self::addKeysToItems(
            $entityManager->getRepository('AppBundle:'. static::$entityName)->findAll()
        );
    }

    /**
     * @param EntityManager $entityManager
     * @param int $itemId
     * @return bool
     */
    public static function deleteItem(EntityManager $entityManager, int $itemId) : bool
    {
        $result = false;
        try {
            if($item = $entityManager->getRepository('AppBundle:' . static::$entityName)->findOneBy(['id' => $itemId])) {
                $entityManager->remove($item);
                $entityManager->flush();
                $result = true;
            }
        } catch (ORMException $e) {
            return $result;
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function validatePostData(Request $request) : bool
    {
        $correct = 0;
        foreach (static::$validateFields as $field) {
            if (!empty($request->get($field))) {
                $correct++;
            }
        }
        return $correct == count(static::$validateFields) ? true : false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function validateEditPostData(Request $request) : bool
    {
        if (!empty($request->get('id')) and self::validatePostData($request)) {
            return true;
        }
        return false;
    }

    public static function convertObjectsToArray(array $items) : array
    {
        $result = [];
        if (!empty($items['items'])) {
            /**
             * @var Entity $item
             */
            foreach ($items['items'] as $item) {
                array_push($result, $item->getSimpleValues());
            }
        }

        return $result;
    }

    /**
     * @param array $items
     * @return array
     */
    public static function addKeysToItems(array $items) : array
    {
        $results = [];
        /**
         * @var Entity $item
         */
        foreach ($items as $item) {
            $results[$item->getId()] = $item;
        }

        return $results;
    }

    public static function addItem(EntityManager $entityManager, Request $request) : bool
    {

    }

    public static function updateItem(EntityManager $entityManager, Request $request) : bool
    {

    }
}