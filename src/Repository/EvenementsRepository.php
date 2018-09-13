<?php

namespace App\Repository;

use App\Entity\Evenements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evenements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenements[]    findAll()
 * @method Evenements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementsRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evenements::class);
    }

//    /**
//     * @return Evenements[] Returns an array of Evenements objects
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

    public function findByMonth($value)
    {

        $bdd = new \PDO('mysql:host=localhost;dbname=yeah;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION));
        $req = $bdd->prepare('SELECT evenements.start_date, evenements.end_date, evenements.titre, evenements.description, evenements.total, evenements.id AS evenement_id,'
                . ' entreprise.id AS entreprise_id, entreprise.nom AS entreprise_nom, entreprise.siret_siren, entreprise.adresse AS entreprise_adresse, entreprise.code_postal AS entreprise_CP, entreprise.ville AS entreprise_ville,'
                . ' tva.id AS tva_id,'
                . ' tarif.id AS tarif_id,'
                . ' clients.id AS client_id , clients.nom AS clients_nom, clients.prenom, clients.adresse, clients.code_postal, clients.date_naissance, clients.ville,'
                . ' MONTH( NOW() ) FROM evenements  '
                . 'LEFT JOIN tarif ON evenements.fk_tarif_id = tarif.id '
                . 'LEFT JOIN tva ON evenements.fk_tva_id = tva.id '
                . 'LEFT JOIN clients on evenements.fk_client_id = clients.id  '
                . 'LEFT JOIN entreprise on evenements.fk_entreprise_id = entreprise.id WHERE entreprise.id ='.$value.' AND MONTH( evenements.start_date ) = MONTH( NOW() )');

        $req->execute();


        // returns an array of arrays (i.e. a raw data set)
        return $req->fetchAll();
    }
    
    
    public function findTotalByMonth($value)
    {
        $bdd = new \PDO('mysql:host=localhost;dbname=yeah;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION));
        $req = $bdd->prepare('SELECT SUM(evenements.total)'
                . 'FROM evenements  '
                . 'LEFT JOIN entreprise on evenements.fk_entreprise_id = entreprise.id WHERE entreprise.id = 7 '
                . 'AND MONTH( evenements.start_date ) = MONTH( NOW() )');
        $req->execute();
        return $req->fetchAll();
         }

    /*
      public function findOneBySomeField($value): ?Evenements
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
