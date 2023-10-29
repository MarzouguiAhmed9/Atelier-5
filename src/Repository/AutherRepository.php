<?php

namespace App\Repository;

use App\Entity\Auther;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auther>
 *
 * @method Auther|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auther|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auther[]    findAll()
 * @method Auther[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auther::class);
    }


    public function showAllStudentByFirstName(){
        return $this->createQueryBuilder("u")
        ->where('u.username like :username')
        ->setParameter('username', 'v%')
        ->getQuery()
        ->getResult();
    }
    public function listbook($id){
    
        return $this->createQueryBuilder("u")
        ->join('u.books','b')
        ->addSelect('b')
        ->where('b.Auther=:id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }

    public function afficherordername(){
        $em=$this->getEntityManager();
        $query=$em->createQuery("Select p from App\Entity\Auther p ORDER BY p.username ASC");
        return $query->getResult();

    }

    public function serachahmed(){
        $em=$this->getEntityManager();
        $query=$em->createQuery("Select p from App\Entity\Auther p WHERE p.username like :name")
        ->setParameter('name','ahmed');
         return $query->getResult();
    }

    public function countauther(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select COUNT(p) from App\Entity\Auther p');
        return $query->getSingleScalarResult();
    }

    public function listbookbyauther($id){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select p from App\Entity\Auther p join p.books c where c.Auther = :id')
        ->setParameter('id',$id);
        return $query->getResult();
    }
    public function searchautherwithbook($min,$max){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select p from App\Entity\Auther p where p.nb_books<= :min and p.nb_books>= :max ')
        ->setParameter('min',$min)
        ->setParameter('max',$max);
        return $query->getResult();
    }

    public function delete(){
        $em=$this->getEntityManager();
        $query=$em->createQuery("Select p from App\Entity\Auther p WHERE p.nb_books=0");
         return $query->getResult();
    }
      

//    /**
//     * @return Auther[] Returns an array of Auther objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Auther
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
