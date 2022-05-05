<?php

namespace App\Controller;

use App\Entity\TestExam;
use App\Form\TestFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestExamController extends AbstractController
{
    #[Route('/test/exam', name: 'app_test_exam')]
    public function index(): Response
    {
        $test="anas";
        return $this->render('test_exam/index.html.twig', [
            'controller_name' => 'TestExamController',
        ]);
    }

    #[Route('/test/form', name: 'testForm')]
    public function testForm(Request $request,ManagerRegistry $doctrine): Response
    {
        $test = new TestExam();

        $form = $this->createForm(TestFormType::class, $test);
        $form->add('Submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager = $doctrine->getManager();
            $data=$form->getData();
            $entityManager->persist($test);
            $entityManager->flush();

        }
        return $this->render('test_exam/testForm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
