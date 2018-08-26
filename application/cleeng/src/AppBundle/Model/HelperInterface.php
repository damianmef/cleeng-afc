<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 19:47
 */

namespace AppBundle\Model;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

interface HelperInterface
{
    public static function getItem(EntityManager $entityManager, int $itemId) : ?object;
    public static function getItems(EntityManager $entityManager) : array;
    public static function deleteItem(EntityManager $entityManager, int $videoId) : bool;
    public static function validatePostData(Request $request) : bool;
    public static function validateEditPostData(Request $request) : bool;
    public static function addItem(EntityManager $entityManager, Request $request) : bool;
    public static function updateItem(EntityManager $entityManager, Request $request) : bool;
}