<?php

namespace App\Repository;

use App\Entity\Dispenser;
use App\Entity\Matiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matiere>
 *
 * @method Matiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matiere[]    findAll()
 * @method Matiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatiereRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Matiere::class);
    }

    public function save(Matiere $entity, bool $flush = false): void {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Matiere $entity, bool $flush = false): void {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Matiere[] Returns an array of Matiere objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Matiere
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

//    public function getListeDispenserByMatiere($matiere) {
//        return $this->createQueryBuilder('g')
//                        // ->leftJoin('App\Entity\Dispenser', 'e' ,'where', 'g.dispenser = e.id')
//                      //  ->join('App\Entity\Dispenser', 'e', Join::WITH, 'g.dispensers = :id')
//                        //->andWhere('e.id = :val')
//                ->join('App\Entity\Dispenser', 'e' , Join::WITH, 'g.dispensers = :e.id')
//                        ->andWhere('g.deletedAt IS NULL')
//                        ->setParameter('val', $matiere)
//                        ->orderBy('g.id', 'ASC')
//                        ->getQuery()
//                        ->getResult()
//        ;
//    }

  
public function matieresGroupByCours()
    {
       return $this->createQueryBuilder('M')
            ->join(Dispenser::class, 'C', 'WITH', 'C.matiere = M.id')
            ->groupBy('M.id')
            ->getQuery()
            ->getResult()
       ;
    }
    
    
    
    
}
