<?php
/**
 * Created by PhpStorm.
 * User: Vanek
 * Date: 25.08.2018
 * Time: 11:39
 */

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Question\AnswerType;
use App\Form\QuizType;
use App\Entity\Answer;
use App\Form\Question\QuestionType;
use App\Entity\Question;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    /**
     * @Route("/gameshow/create/create", name="create_quiz")
     */
    public function createQuiz(Request $request, QuizRepository $quizRepository)
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->getData();
            $quiz->setIsActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quiz);
            $entityManager->flush();
            return $this->redirectToRoute('show_admin_quizzes');
        }
        return $this->render(
            'creater/quiz.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/gameshow/create/success", name="success_create_quiz")
     */
    public function success(Request $request, QuizRepository $quizRepository)
    {
        return $this->render('show/quiz.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    
    /**
     * @Route("/gameshow/create/success", name="success_create_quiz")
     */
    public function successQuiz(Request $request, QuizRepository $quizRepository)
    {
        return $this->render('show/quiz.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/success", name="success_create_question",
     *      requirements={"quiz_id"="\d+"})
     */
    public function successQuestion(int $quiz_id, Request $request, QuizRepository $quizRepository)
    {
        return $this->render('show/quiz.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/success", name="success_create_answer",
     *      requirements={"quiz_id"="\d+", "question_id"="\d+"})
     */
    public function successAnswer(int $quiz_id, int $question_id, Request $request, QuizRepository $quizRepository)
    {
        return $this->render('show/quiz.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/answer/{answer_id}/success", name="success_updateee_answer",
     *      requirements={"quiz_id"="\d+", "question_id"="\d+", "answer_id"="\d+"})
     */
    public function successUpdate(int $quiz_id, int $question_id, Request $request, QuizRepository $quizRepository)
    {
        return $this->render('show/quiz.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    /**
     * @Route("/gameshow/create", name="create1")
     */
    public function creater(Request $request)
    {
        return $this->render(
            'creater/creater.html.twig'
        );
    }
}