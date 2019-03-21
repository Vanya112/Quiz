<?php


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

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}", name="show_admin_answers",
     *     requirements={"quiz_id"="\d+", "question_id"="\d+"}))
     */
    public function showAnswers(int $quiz_id, int $question_id,
                                Request $request, QuizRepository $quizRepository, QuestionRepository $questionRepository,
                                AnswerRepository $answerRepository)
    {
        $answers = $answerRepository->findBy(['question' => $question_id]);
        return $this->render('show/answer.html.twig', ['answers' => $answers, 'quiz_id' => $quiz_id,
            'question_id' => $question_id]);
    }


}