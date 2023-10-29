<?php

namespace App\Controller;
use App\Entity\Car;
use App\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }
    #[Route('car/add',name:"caradd")]
    public function addwithform(ManagerRegistry $doctrine,Request $request):Response{
        $car=new Car();
        $form=$this->createForm(CarType::class,$car);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($car);
            $em->flush();
            
        }
        return $this->render('car/addcar.html.twig',["form"=>$form]);
        
    }
}
