<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 17.08.18
 * Time: 00:32
 */

namespace AppBundle\Model\Video;

use AppBundle\Model\AbstractProcess;
use AppBundle\Model\ProcessInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class VideoProcess extends AbstractProcess implements ProcessInterface
{
    public function __construct(EntityManager $entityManager, RequestStack $requestStack)
    {
        parent::__construct($entityManager, $requestStack);
        $this->helper = new VideoHelper();
    }
}
