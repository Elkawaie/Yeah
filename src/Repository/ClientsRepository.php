<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clients[]    findAll()
 * @method Clients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clients::class);
    }

//    /**
//     * @return Clients[] Returns an array of Clients objects
//     */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('c.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */
    public function findByEntreprise($value)
    {

        $bdd = new \PDO('mysql:host=localhost;dbname=yeah;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION));
        $req = $bdd->prepare('SELECT * FROM clients'
                . '  LEFT JOIN evenements ON clients.id = evenements.fk_client_id  '
                . 'WHERE evenements.fk_entreprise_id = '.$value.' '
                . 'OR evenements.fk_client_id IS NULL '
                . 'GROUP BY clients.id');
        // $conn = $this->getEntityManager()->getConnection();
        // $sql ="'SELECT * FROM clients LEFT JOIN evenements ON clients.id = evenements.fk_client_id WHERE evenements.fk_entreprise_id ='.$value.' GROUP BY clients.id'")";
        //$stmt = $conn->prepare($sql);
        // $stmt->execute();

        $req->execute();


        // returns an array of arrays (i.e. a raw data set)
        return $req->fetchAll();
    }

    /*
      public function findOneBySomeField($value): ?Clients
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
