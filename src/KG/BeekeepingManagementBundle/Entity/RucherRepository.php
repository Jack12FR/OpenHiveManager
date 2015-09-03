<?php

namespace KG\BeekeepingManagementBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * RucherRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RucherRepository extends EntityRepository
{
    public function getListByExploitation($page=1, $maxperpage=10, $exploitation)
    {
        $q = $this->createQueryBuilder('r')
                  ->leftJoin('r.exploitation','e')
                  ->addSelect('e')
                  ->where('e.id = :id')
                  ->andWhere('r.supprime = false')
                  ->setParameter('id',$exploitation);
        
        $q->setFirstResult(($page-1)*$maxperpage)
          ->setMaxResults($maxperpage);
        
        return new Paginator($q);
    }

    public function countByExploitation($exploitation)
    {
        return $this->createQueryBuilder('r')
                    ->select('COUNT(r)')
                    ->leftJoin('r.exploitation','e')
                    ->where('e.id = :id')
                    ->andWhere('r.supprime = false')                
                    ->setParameter('id',$exploitation)
                    ->getQuery()
                    ->getSingleScalarResult();
    }  
    
    public function getRucherByExploitation($id, $exploitation)
    {
        return $this->createQueryBuilder('r')
                    ->leftJoin('r.exploitation','e')
                    ->addSelect('e')
                    ->where('e.id = :exploitation')
                    ->andWhere('r.id = :id')
                    ->andWhere('r.supprime = false')
                    ->setParameter('exploitation',$exploitation)
                    ->setParameter('id',$id)
                    ->getQuery()
                    ->getSingleResult();
    }  

    public function queryfindByExploitationId($exploitation)
    {
        return $this->createQueryBuilder('rucher')
                    ->leftJoin('rucher.exploitation', 'exploitation')
                    ->addSelect('exploitation')
                    ->where('exploitation.id = :exploitation')
                    ->andWhere('rucher.supprime = false')                   
                    ->setParameter('exploitation',$exploitation);
    }
    
    public function findByExploitationId($exploitation)
    {
        return $this->queryfindByExploitationId($exploitation)
                    ->getQuery()
                    ->getArrayResult();
    }     
}
