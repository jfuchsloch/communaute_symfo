<?php

namespace EyesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * utilisateursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class pannierarticleRepository extends EntityRepository
{
	  public function findAll()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT f  FROM  EyesBundle:pannierarticle f"

        );

        //die(var_dump($query->getResult()));
       //var_dump($query->getResult());
        return $query->getResult();
    }
}
