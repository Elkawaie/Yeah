<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }

//    /**
//     * @return Entreprise[] Returns an array of Entreprise objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
public function findByTarif($value)
    {
        
        $bdd = new \PDO('mysql:host=localhost;dbname=yeah;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION));
        $req = $bdd->prepare('SELECT * FROM entreprise WHERE entreprise.id IN (SELECT `entreprise_id` FROM `tarif_entreprise` WHERE `tarif_id` ='.$value.')');
       // $conn = $this->getEntityManager()->getConnection();
       // $sql ="SELECT * FROM tarif WHERE tarif.id IN (SELECT `tarif_id` FROM `tarif_entreprise` WHERE `entreprise_id` =" .$value.")";
        //$stmt = $conn->prepare($sql);
       // $stmt->execute();
        
        $req->execute();
       

        // returns an array of arrays (i.e. a raw data set)
        return $req->fetchAll();
    }
    /*
    public function findOneBySomeField($value): ?Entreprise
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
