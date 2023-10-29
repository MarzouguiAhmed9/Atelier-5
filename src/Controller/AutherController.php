<?php

namespace App\Controller;

use App\Entity\Auther;
use App\Repository\AutherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AutherType ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutherController extends AbstractController
{
    #[Route('/auther', name: 'app_auther')]
    public function index(): Response
    {
        return $this->render('auther/index.html.twig', [
            'controller_name' => 'AutherController',
        ]);
    }

    #[Route('/auther/showauther/{name}',name:"showauther")]
    public function showauther ($name): Response{
        return $this->render("auther/show.html.twig", ["name" => $name]);
    }

    #[Route('auther/list',name:"show_list")]
    public function show_list(): Response{
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            $nombreauthor=count($authors);
            $nombredelivre=0;

            foreach($authors as $author){
                $nombredelivre+=$author['nb_books'];
            }
            
        return $this->render('auther/list.html.twig',["authers"=>$authors,"nombreauther"=>$nombreauthor,"nombredelivre"=>$nombredelivre]);
    }

    #[Route('auther/detail/{id}',name:"detail_control")]
    public function showdetails($id):Response{
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            $autherdata=null;
        foreach($authors as $auther) {
            if($auther['id']==$id){$autherdata=$auther;}
            
    }
    return $this->render('auther/details.html.twig',["auther"=>$autherdata]);
}
#[Route("/auther/afficher_auther",name:"auther_details")]
public function affiche_auher(AutherRepository $autherRepository){

    $authers=$autherRepository->findAll();
    
    return $this->render('auther/index.html.twig',["authers"=>$authers]);


}
#[Route("/auther/ajouter",name:"ajouter_auther")]
public function addwithform(ManagerRegistry $doctrine,Request $request):Response{
    $auther=new Auther();
    $form=$this->createForm(AutherType::class,$auther);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->persist($auther);
        $em->flush();
        return $this->redirectToRoute('auther_details');
    }
    return $this->render('auther/addauther.html.twig',["forms"=>$form]);


}

#[Route('/auther/addstatique',name:"auther_addstatique")]
public function addstatique(AutherRepository $autherRepository,ManagerRegistry $doctrine):Response{
    $auther=new Auther();
    $auther->setUsername("test");
    $auther->setEmail("test@gmail.com");
    $em=$doctrine->getManager();
    $em->persist($auther);
    $em->flush();
    return $this->redirectToRoute('auther_details'); 

}





#[Route('auther/editauther/{id}',name:"edit_auther")]
public function edit_auther(AutherRepository $autherRepository,$id,Request $request,ManagerRegistry $doctrine):Response{
    $auther=$autherRepository->find($id);
    
    $form=$this->createForm(AutherType::class,$auther);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->persist($auther);
        $em->flush();
        return $this->redirectToRoute('auther_details');
    }
    return $this->render('auther/editauther.html.twig',["form"=>$form]);


    }

    #[Route('auther/deleteauther/{id}',name:"delete_auther")]
    public function delete_auther(AutherRepository $autherRepository,ManagerRegistry $doctrine,$id){
        $auther=$autherRepository->find($id);
        $em=$doctrine->getManager();
        $em->remove($auther);
        $em->flush();
        return $this->redirectToRoute('auther_details');
        
    }
    #[Route("/auther/afficher_auther_book/{id}",name:"listbook")]
public function affiche_book(AutherRepository $autherRepository,$id){
//var_dump($id).die();
    $authers=$autherRepository->listbook($id);
    
    return $this->render('auther/indexbook.html.twig',["authers"=>$authers]);


}

#[Route('/auther/count', name: 'app_auther')]
public function count( AutherRepository $autherRepository,ManagerRegistry $doctrine): Response
{
    $number=$autherRepository->countauther();
    return $this->render('auther/count.html.twig', [
        'number' => $number
    ]);
}
#[Route('/autherbybook/{id}', name: 'autherbybook')]
public function autherbybook(AutherRepository $autherRepository,$id): Response
{
    $auther=$autherRepository->listbookbyauther($id);
    return $this->render('auther/autherbybook.html.twig', [
        'auther' => $auther,
    ]);
}
#[Route('/autherbybook/{max}/{min}', name: 'autherbybookmaxmin')]
public function authersearchbybook(AutherRepository $autherRepository, $max, $min,Request $request): Response
{
    $min = $request->query->get('min', 'default_value');
$max = $request->query->get('max', 'default_value');

    $auth=$autherRepository->searchautherwithbook($max,$min);
    return $this->render('auther/indexaftersearch.html.twig', [
        'auth' => $auth,
    ]);
}
#[Route('/auther/delete0books', name: 'delete0books')]
public function deletewith0books(AutherRepository $autherRepository, ManagerRegistry $doctrine ): Response
{
    $em=$doctrine->getManager();
    $authersWith0Books=$autherRepository->delete();
    foreach ($authersWith0Books as $auther) {
        $em->remove($auther);
    }
        
        $em->remove($auther);
        $em->flush();
        return $this->redirectToRoute('auther_details');
}


}


