<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student/c')]
class StudentCController extends AbstractController
{
    #[Route('/', name: 'app_student_c_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('student_c/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_c_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('app_student_c_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_c/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_c_show', methods: ['GET'])]
    public function show(Student $student): Response
    {
        return $this->render('student_c/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_c_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_student_c_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_c/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_c_delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_student_c_index', [], Response::HTTP_SEE_OTHER);
    }
}
