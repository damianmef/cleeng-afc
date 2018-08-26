<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 17.08.18
 * Time: 16:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="videos")
 */
class Video implements Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $subscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addTime;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }
    

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription): void
    {
        $this->subscription = $subscription;
    }

    /**
     * @return \DateTime
     */
    public function getAddTime(): \DateTime
    {
        return $this->addTime;
    }

    /**
     * @param \DateTime $addTime
     */
    public function setAddTime(\DateTime $addTime): void
    {
        $this->addTime = $addTime;
    }

    /**
     * @return array
     */
    public function getSimpleValues() : array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
            'subscription' => $this->getSubscription(),
            'addTime' => !empty($this->hdDisplayedTime) ?
                date('d-m-Y', strtotime($this->getAddTime()->format('Y-m-d'))) : null,

        ];
    }
}