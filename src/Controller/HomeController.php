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

class HomeController extends AbstractController
{
    /**
     * @Route("/student", name="student_home")
     */
    public function index(StudentRepository $repo)
    {
        $students = $repo->findAll();

        return $this->render('index.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * @Route("student/{id}", name="student_show")
     */
    public function show(Student $student)
    {
        return $this->render('show.html.twig', [
            'student' => $student
        ]);
    }

    /**
     * @Route("/admin/new", name="student_new")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(StudentType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newStudent = $form->getData();

            $manager->persist($newStudent);
            $manager->flush();

            return $this->redirectToRoute('student_show', ['id' => $newStudent->getId()]);
        }

        return $this->render('new.html.twig', [
            'studentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="student_edit")
     */
    public function edit(Student $student, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $manager->flush();
            return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
        }

        return $this->render('edit.html.twig', [
            'studentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/delete/{id}", name="student_delete")
     */
    public function delete(Student $student, EntityManagerInterface $manager)
    {
        $manager->remove($student);
        $manager->flush();

        return $this->redirectToRoute('student_home');
    }
}