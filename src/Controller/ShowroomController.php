<?php

namespace App\Controller;

use App\Entity\Showroom;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ShowroomType ;
use App\Repository\ShowroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowroomController extends AbstractController
{
    #[Route('/showroom', name: 'app_showroom')]
    public function index(): Response
    {
        return $this->render('showroom/index.html.twig', [
            'controller_name' => 'ShowroomController',
        ]);
    }
    
    #[Route('showroom/add',name:"auther_addwithform")]
public function addwithform(ManagerRegistry $doctrine,Request $request):Response{
    $showroom=new Showroom();
    $form=$this->createForm(ShowroomType::class,$showroom);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->persist($showroom);
        $em->flush();
        return $this->redirectToRoute('showroom_details');
    }
    return $this->render('showroom/addshow.html.twig',["form"=>$form]);
    
}
#[Route("/showroom/afficher",name:"showroom_details")]
public function affiche_auher(ShowroomRepository $showroomRepository){
    $srooms=$showroomRepository->findAll();
    return $this->render('showroom/index.html.twig',["srooms"=>$srooms]);


}
#[Route('showroom/editsh/{id}',name:"edit_shu")]
public function edit_sh(ShowroomRepository $showroomRepository,$id,Request $request,ManagerRegistry $doctrine):Response{
    $sh=$showroomRepository->find($id);
    
    $form=$this->createForm(ShowroomType::class,$sh);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->persist($sh);
        $em->flush();
        return $this->redirectToRoute('showroom_details');
    }
    return $this->render('showroom/editshowroom.html.twig',["form"=>$form]);


    }
    #[Route('/showroom/delete/{id}', name: 'delete_shu')]
    public function delete($id, ShowroomRepository $showroomRepository, ManagerRegistry $doctrine): Response
    {
        $sh = $showroomRepository->find($id);
    
        // Check if the entity with the given ID exists
        if (!$sh) {
         
        }
    
        $em = $doctrine->getManager();
        $em->remove($sh);
        $em->flush();
    
        return $this->redirectToRoute('showroom_details');
    }
    
}
