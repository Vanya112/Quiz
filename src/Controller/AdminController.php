<?php
/**
 * Created by PhpStorm.
 * User: Vanek
 * Date: 26.08.2018
 * Time: 13:52
 */

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/gameshow/create", name="show_admin_quizzes")
     */
    public function showQuizzes(Request $request, QuizRepository $quizRepository)
    {
        return $this->render('show/quiz.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}", name="show_admin_questions",
     *     requirements={"quiz_id"="\d+"})
     */
    public function showQuestions(int $quiz_id, Request $request,
                                  QuestionRepository $questionRepository, QuizRepository $quizRepository)
    {
        $quiz = $quizRepository->find($quiz_id);
        $questions = $quiz->getQuestions();
        $id = array();
        foreach ($questions as $value)
            $id[] = $value->getId();
        return $this->render('show/question.html.twig',
            ['questions' => $questionRepository->findBy(['id' => $id]),
                'quiz_id' => $quiz_id]);
    }

 


}