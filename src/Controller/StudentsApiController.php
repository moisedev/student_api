<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\Service\StudentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentsApiController extends AbstractController
{
    private $studentManager;
    private $studentRepository;

    public function __construct(StudentManager $studentManager, StudentRepository $studentRepository)
    {
        $this->studentManager    = $studentManager;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/api/student/list", name="list_student")
     */
    public function index(): Response
    {
        $students = $this->studentRepository->findAll();
        return $this->json($students);
    }

    /**
     * @Route("/api/student/insert", name="create_student")
     */
    public function insert(): Response
    {
        $results = $this->studentManager->fetchStudentFromApi();
        return $this->json($results);
    }
}