<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Offer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("profile/offer")
 * @Security("has_role('ROLE_USER')")
 */

class UserOfferController extends Controller
{
    /**
     * @Route("/")
     */
    public function showByUser()
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $offers = $this->getDoctrine()->getRepository('AppBundle:Offer')->findActiveOfferByUserId($userId);
        $archiveOffers = $this->getDoctrine()->getRepository('AppBundle:Offer')->findArchivesOfferByUserId($userId);

        return $this->render(':offer:show_by_user.html.twig', ['offers'=>$offers, 'user'=>$user, 'archiveOffers'=>$archiveOffers]);
    }
}
