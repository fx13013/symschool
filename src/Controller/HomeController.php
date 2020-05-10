<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/students", name="student_home")
     */
    public function index(StudentRepository $repo)
    {
        $students = $repo->findAll();

        return $this->render('index.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * @Route("/student/new", name="student_new")
     */
    public function create(Request $request)
    {
        $newStudent = new Student();

        $form = $this->createForm(StudentType::class, $newStudent);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $newStudent = $form->getData();
        }

        return $this->render('new.html.twig', [
            'studentForm' => $form->createView()
        ]);
    }
}