<?php
namespace App\Controller;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\QueryBuilder;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Auther;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/addbook', name: 'addbook')]
    public function addbook(ManagerRegistry $doctrine ,Request $request): Response
    {
        $book = new Book();
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $book->setPublished(true);
            $auther=$book->getAuther();
            if($auther instanceof Auther){$auther->setNbBooks($auther->getNbBooks()+1);}
            
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('afficherbook');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/listbook', name: 'afficherbook')]
    public function afficherbook(BookRepository $bookRepository): Response
    {
        $books=$bookRepository->findAll();
        return $this->render('book/index.html.twig', [
            'books' =>$books,
        ]);
    }

    #[Route('/book/edit/{ref}', name: 'book_edit')]
    public function edit(BookRepository $bookRepository,$ref, Request $request,ManagerRegistry $doctrine): Response
    {
        $book=$bookRepository->find($ref);
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('afficherbook');
        }

        return $this->render('book/editbook.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/book/delete/{ref}', name: 'delete_book')]
    public function delete($ref,BookRepository $bookRepository,ManagerRegistry $doctrine): Response
    {
        $book=$bookRepository->find($ref);
        $em=$doctrine->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('afficherbook');
    }
    #[Route('/book/deletenobook', name: 'delete_nobook')]
    public function deletebookno(BookRepository $bookRepository, ManagerRegistry $doctrine): Response
    {
        $booksToDelete = $bookRepository->findBy(["nb_books" => 0]);
        $em = $doctrine->getManager();
    
        foreach ($booksToDelete as $book) {
            $em->remove($book);
        }
    
        $em->flush();
        return $this->redirectToRoute('afficherbook');
    }

    #[Route('/book/show/{ref}', name: 'show_book')]
    public function show($ref,BookRepository $bookRepository): Response
    {
        $book=$bookRepository->find($ref);
        return $this->render('book/showdetails.html.twig', [
            'book' => $book,
        ]);
    }
    #[Route('/listbookordre', name: 'afficherbookordre')]
    public function afficherbookordre(BookRepository $bookRepository): Response
    {
        $books=$bookRepository->findByAuthorUsernameOrdered();
        return $this->render('book/autherordrealpha.html.twig', [
            'books' =>$books,
        ]);
    }
    #[Route('/search/{ref}', name: 'search')]
    public function afficherbookafterseach($ref, BookRepository $bookRepository,Request $request): Response
    {   
        $ref = $request->query->get('ref', 'default_value');

        $books = $bookRepository->search($ref);
     
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
    #[Route('/bookplus35', name: 'plus35')]
    public function plus35( BookRepository $bookRepository): Response
    {
        $books = $bookRepository->searchplus35();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
    #[Route('/listbook/sc', name: 'afficherbooksc')]
    public function afficher(BookRepository $bookRepository): Response
    {
        $b=$bookRepository->sf();
        return $this->render('book/booksc.html.twig', [
            'b' =>$b,
        ]);
    }

    #[Route('/listbook1418', name: 'afficherbook1418')]
    public function afficherbook1418(BookRepository $bookRepository): Response
    {
        $books=$bookRepository->livreentredeuxdate();
        return $this->render('book/index.html.twig', [
            'books' =>$books,
        ]);
    }

    
}
