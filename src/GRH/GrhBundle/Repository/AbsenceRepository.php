<?php

namespace GRH\GrhBundle\Repository;

/**
 * AbsenceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbsenceRepository extends \Doctrine\ORM\EntityRepository
{
	public function nbabsences($id){
		$query = $this->_em->createQuery("SELECT SUM(a.nbjours) FROM GRHGrhBundle:Absence a where a.employe =$id AND  
			MONTH(a.debut) = MONTH(CURRENT_DATE()) AND MONTH(a.fin) = MONTH(CURRENT_DATE()) ");
          $resultats = $query->getSingleScalarResult();
          return $resultats;
	}
	public function nbabsencesmois($id){
		$query = $this->_em->createQuery("SELECT a FROM GRHGrhBundle:Absence a where a.employe =$id AND  
			MONTH(a.debut) = MONTH(CURRENT_DATE()) AND MONTH(a.fin) = MONTH(CURRENT_DATE()) ");
          $resultats = $query->getResult();
          return $resultats;
	}
}
