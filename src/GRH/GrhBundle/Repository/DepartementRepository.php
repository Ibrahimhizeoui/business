<?php

namespace GRH\GrhBundle\Repository;

/**
 * DepartementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DepartementRepository extends \Doctrine\ORM\EntityRepository
{
	public function nbempl($id){
          $query = $this->_em->createQuery("SELECT COUNT(d.id) FROM GRHGrhBundle:Departement d where d.id =$id");
          $resultats = $query->getSingleScalarResult();
          return $resultats;		
	}
	public function employes($id){
          $query = $this->_em->createQuery("SELECT e FROM GRHGrhBundle:Employe e where e.departement =$id");
          $resultats = $query->getResult();
          return $resultats;		
	}
}
