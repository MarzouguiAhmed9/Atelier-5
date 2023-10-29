<?php

namespace App\Repository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }


    public function findByAuthorUsernameOrdered(){
        return $this->createQueryBuilder('b')
        ->join('b.Auther', 'a')
        ->orderBy('a.username', 'ASC')
        ->getQuery()
        ->getResult();}

        public function search($ref){
            $em=$this->getEntityManager();
            $query = $em->createQuery('Select p from App\Entity\Book p where p.ref=:ref')
            ->setParameter('ref',$ref);
            return $query->getResult();
        }


        public function searchplus35()
        {
            $queryBuilder = $this->createQueryBuilder('p')
                ->join('p.Auther', 'a')
                ->where('p.publicationDate < :publicationDate')
                ->andWhere('a.nb_books > :nbBooks')
                ->setParameter('publicationDate', new \DateTime('2023-01-01'))
                ->setParameter('nbBooks', 35);
        
            $query = $queryBuilder->getQuery();
            
            return $query->getResult();
        }
        public function sf(){
            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT COUNT(p) FROM App\Entity\Book p WHERE p.category = :sc')
                ->setParameter('sc', 'science_fiction');
            return $query->getSingleScalarResult();
        }

        public function livreentredeuxdate(){
            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT p FROM App\Entity\Book p WHERE p.publicationDate< :maxdate AND p.publicationDate> :mindate') 
                ->setParameter('mindate', new \DateTime('2014-01-01'))
                ->setParameter('maxdate', new \DateTime('2018-12-31'));
            return $query->getResult();
        }
        

        
        

        
    
    
    

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
