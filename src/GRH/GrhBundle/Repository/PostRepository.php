<?php

namespace GRH\GrhBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
	public function post(){
          $query = $this->_em->createQuery("SELECT p FROM GRHGrhBundle:Post p where MONTH(p.debut) =MONTH(CURRENT_DATE())");
          $resultats = $query->getResult();
          return $resultats;		
	}
}
