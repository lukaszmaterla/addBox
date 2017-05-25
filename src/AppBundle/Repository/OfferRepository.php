<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OfferRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OfferRepository extends EntityRepository
{

    public function findActiveOfferByDate()
    {
        $date = new \DateTime();
        $date->modify('-14 days');
        $date->format("Y-m-d H:i:s");
        return $this->getEntityManager()
            ->createQuery('
                    SELECT o FROM AppBundle:Offer o 
                    WHERE o.expiredAt > :active 
                    ORDER BY o.expiredAt DESC')
            ->setParameter('active', $date)
            ->getResult();

    }

    public function findActiveOfferByCategory($id)
    {
        $date = new \DateTime();
        $date->modify('-14 days');
        $date->format("Y-m-d H:i:s");
        return $this->getEntityManager()
            ->createQuery('
                    SELECT o FROM AppBundle:Offer o 
                    WHERE o.expiredAt > :active
                    AND o.category = :id
                    ORDER BY o.expiredAt DESC')
            ->setParameter('active', $date)->setParameter('id', $id)
            ->getResult();
    }

    public function findArchivesOfferByUserId($userId)
    {

        $date = new \DateTime();
        $date->modify('-7 days');
        $date->format("Y-m-d H:i:s");
        return $this->getEntityManager()
            ->createQuery('
                    SELECT o FROM AppBundle:Offer o 
                    WHERE o.expiredAt < :active
                    AND o.user = :id
                    ORDER BY o.expiredAt DESC')
            ->setParameter('active', $date)->setParameter('id', $userId)
            ->getResult();
    }

    public function findActiveOfferByUserId($userId)
    {

        $date = new \DateTime();
        $date->modify('-7 days');
        $date->format("Y-m-d H:i:s");
        return $this->getEntityManager()
            ->createQuery('
                    SELECT o FROM AppBundle:Offer o 
                    WHERE o.expiredAt > :active
                    AND o.user = :id
                    ORDER BY o.expiredAt DESC')
            ->setParameter('active', $date)->setParameter('id', $userId)
            ->getResult();
    }


}
