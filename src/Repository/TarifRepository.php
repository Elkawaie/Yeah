<?php

namespace App\Repository;

use App\Entity\Tarif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tarif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tarif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tarif[]    findAll()
 * @method Tarif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarifRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tarif::class);
    }

//    /**
//     * @return Tarif[] Returns an array of Tarif objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
      public function findByEntreprise($value)
    {
        
        $bdd = new \PDO('mysql:host=localhost;dbname=yeah;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION));
        $req = $bdd->prepare('SELECT * FROM tarif LEFT JOIN tarif_entreprise ON tarif_entreprise.tarif_id = tarif.id '
                . 'WHERE tarif_entreprise.entreprise_id ='.$value.'');
        //$conn = $this->getEntityManager()->getConnection();
        //$sql ="SELECT * FROM tarif "
        //        . "LEFT JOIN tarif_entreprise ON tarif_entreprise.tarif_id = tarif.id "
         //       . "WHERE tarif_entreprise.entreprise_id =".$value."";
        //$stmt = $conn->prepare($sql);
        //$stmt->execute();
        
        $req->execute();
       

        // returns an array of arrays (i.e. a raw data set)
        return $req->execute();
    }
    /*
    public function findOneBySomeField($value): ?Tarif
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    

            
}
