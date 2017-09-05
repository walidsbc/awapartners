<?php

namespace SBC\AWAPartnersBundle\Repository;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder('client')
          ->orderBy('client.position', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('client')
            ->orderBy('client.position', 'asc')
            ->where('client.displayed = 1')
            ->getQuery()
            ->getResult();
    }


    public function getLastPosition()
    {

        return $this->createQueryBuilder('client')
            ->select('MAX( client.position )')
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function updatePositions($old, $new)
    {

//        $new++;
//        $old++;
        if ($old < $new) {
            $query = $this->getEntityManager()->createQuery('UPDATE SBC\AWAPartnersBundle\Entity\Client p SET p.position = p.position-1  WHERE   p.position >= ' . $old . ' AND p.position <= ' . $new);
            $results = $query->getResult();
        } else {
            $query = $this->getEntityManager()->createQuery('UPDATE SBC\AWAPartnersBundle\Entity\Client p SET p.position = p.position+1  WHERE p.position >= ' . $new . ' AND p.position <= ' . $old);

            $results = $query->getResult();
        }


        return $results;
    }
}
