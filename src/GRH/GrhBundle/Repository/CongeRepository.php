<?php

namespace GRH\GrhBundle\Repository;

/**
 * CongeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CongeRepository extends \Doctrine\ORM\EntityRepository
{
	public function demandeconge(){
		  $query = $this->_em->createQuery("SELECT c FROM GRHGrhBundle:Conge c where c.status ='non verfier'");
          $resultats = $query->getResult();
          return $resultats;		
	}
}
