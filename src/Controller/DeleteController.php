<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/delete", name="delete_quiz", requirements={"quiz_id"="\d+"})
     */
    public function deleteQuiz(int $quiz_id, QuizRepository $quizRepository, Request $request)
    {
        $quiz_form = $quizRepository->find($quiz_id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($quiz_form);
        $entityManager->flush();
        return $this->redirectToRoute('show_admin_quizzes');
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/delete", name="delete_question",
     *     requirements={"quiz_id"="\d+", "question_id"="\d+", })
     */
    public function deleteQuestion(int $quiz_id,
                                   int $question_id,
                                   Request $request,
                                   QuestionRepository $questionRepository)
    {
        $current_question = $questionRepository->find($question_id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($current_question);
        $entityManager->flush();
        return $this->redirect('success');
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/answer/{answer_id}/delete", name="delete_answer",
     *  requirements={"quiz_id"="\d+", "question_id"="\d+", "answer_id"="\d+"})
     */
    public function deleteAnswer(int $quiz_id,
                                 int $question_id,
                                 int $answer_id,
                                 Request $request,
                                 AnswerRepository $answerRepository)
    {
        $current_answer = $answerRepository->find($answer_id);
        $entityManager = $this->getDoctrine()->getManager();
        $isCorrect = $current_answer->getIsCorrect();
        if ($isCorrect == true) {
            return $this->redirect('success');
        }
        $entityManager->remove($current_answer);
        $entityManager->flush();
        return $this->redirect('success');
    }

}