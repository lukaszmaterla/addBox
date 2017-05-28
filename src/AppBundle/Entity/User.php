<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 12.05.17
 * Time: 09:52
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */

    protected $firstName;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $city;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $phoneNumber;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Offer", mappedBy="user")
     *
     */
    private $offers;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="sender")
     */
    private $sentMessages;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="receiver")
     */
    private $receivedMessages;

    public function __construct()
    {
        parent::__construct();
        $this->offers = new ArrayCollection();
        $this->sentMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();

    }

    /**
     * Add offers
     *
     * @param \AppBundle\Entity\Offer $offers
     * @return User
     */
    public function addOffer(\AppBundle\Entity\Offer $offers)
    {
        $this->offers[] = $offers;

        return $this;
    }

    /**
     * Remove offers
     *
     * @param \AppBundle\Entity\Offer $offers
     */
    public function removeOffer(\AppBundle\Entity\Offer $offers)
    {
        $this->offers->removeElement($offers);
    }

    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOffers()
    {
        return $this->offers;
    }




    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Add sentMessages
     *
     * @param \AppBundle\Entity\Message $sentMessages
     * @return User
     */
    public function addSentMessage(\AppBundle\Entity\Message $sentMessages)
    {
        $this->sentMessages[] = $sentMessages;

        return $this;
    }

    /**
     * Remove sentMessages
     *
     * @param \AppBundle\Entity\Message $sentMessages
     */
    public function removeSentMessage(\AppBundle\Entity\Message $sentMessages)
    {
        $this->sentMessages->removeElement($sentMessages);
    }

    /**
     * Get sentMessages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSentMessages()
    {
        return $this->sentMessages;
    }

    /**
     * Add receivedMessages
     *
     * @param \AppBundle\Entity\Message $receivedMessages
     * @return User
     */
    public function addReceivedMessage(\AppBundle\Entity\Message $receivedMessages)
    {
        $this->receivedMessages[] = $receivedMessages;

        return $this;
    }

    /**
     * Remove receivedMessages
     *
     * @param \AppBundle\Entity\Message $receivedMessages
     */
    public function removeReceivedMessage(\AppBundle\Entity\Message $receivedMessages)
    {
        $this->receivedMessages->removeElement($receivedMessages);
    }

    /**
     * Get receivedMessages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceivedMessages()
    {
        return $this->receivedMessages;
    }
}
