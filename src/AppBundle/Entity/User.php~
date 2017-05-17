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
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Offer", mappedBy="user")
     *
     */
    private $offers;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();
        $this->offers = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\Comment $comments
     */
    public function removeComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
