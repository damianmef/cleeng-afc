<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 09:27
 */

namespace AppBundle\Model\Video;


use AppBundle\Entity\Video;
use AppBundle\Model\AbstractHelper;
use AppBundle\Model\HelperInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class VideoHelper extends AbstractHelper implements HelperInterface
{
    public static $entityName = 'Video';
    public static $validateFields = [
        'video-title',
        'video-url',
        'video-subscription'
    ];

    /**
     * @param EntityManager $entityManager
     * @param Request $request
     * @return bool
     * @throws ORMException
     */
    public static function addItem(EntityManager $entityManager, Request $request) : bool
    {
        $video = new Video();
        $video->setTitle($request->get('video-title'));
        $video->setUrl($request->get('video-url'));
        $video->setSubscription($request->get('video-subscription'));
        $video->setAddTime(new \DateTime(date('Y-m-d')));

        if (!$request->get('test')) {
            try {
                $entityManager->persist($video);
                $entityManager->flush();
            } catch (OptimisticLockException $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param EntityManager $entityManager
     * @param Request $request
     * @return bool
     */
    public static function updateItem(EntityManager $entityManager, Request $request) : bool
    {
        /**
         * @var Video $video
         */
        $video = $entityManager->getRepository('AppBundle:Video')
            ->findOneBy(['id' => $request->get('id')]);

        if (!empty($video)) {
            try {
                $video->setTitle($request->get('video-title'));
                $video->setUrl($request->get('video-url'));
                $video->setSubscription($request->get('video-subscription'));
                $entityManager->flush();
                return true;
            } catch (ORMException $e) {
                return false;
            }
        }
        return false;
    }
}