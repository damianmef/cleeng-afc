<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 16.08.18
 * Time: 21:10
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $subscriptionEndTime;

    /**
     * @ORM\Column(type="integer", length=100, nullable=true)
     */
    private $subscriptionType;



    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getSubscriptionEndTime(): string
    {
        return date('Y-m-d H:i:s', strtotime($this->subscriptionEndTime->format('Y-m-d H:i:s')));
    }

    /**
     * @param \DateTime $subscriptionEndTime
     */
    public function setSubscriptionEndTime(\DateTime $subscriptionEndTime): void
    {
        $this->subscriptionEndTime = $subscriptionEndTime;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionType()
    {
        return $this->subscriptionType;
    }

    /**
     * @param mixed $subscriptionType
     */
    public function setSubscriptionType($subscriptionType): void
    {
        $this->subscriptionType = $subscriptionType;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getSimpleValues() : array
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'subscriptionType' => $this->getSubscriptionType()
        ];
    }

    public function isSubscriptionAvailable()
    {
        if ($this->getSubscriptionEndTime() > date('Y-m-d H:i:s')) {
            return true;
        }

        return false;
    }
}