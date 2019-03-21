<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
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

class UpdateController extends AbstractController
{
    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/update", name="update_quiz", requirements={"quiz_id"="\d+"}))
     */
    public function updateQuiz(int $quiz_id, QuizRepository $quizRepository, Request $request)
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->getData();
            $quiz_form = $quizRepository->find($quiz_id);
            $entityManager = $this->getDoctrine()->getManager();
            $quiz_form->setName($quiz->getName());
            $quiz_form->setDescription($quiz->getDescription());
            $entityManager->persist($quiz_form);
            $entityManager->flush();
            return $this->redirect('success');
        }
        return $this->render(
            'updater/quiz.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/update", name="update_question",
     *     requirements={"quiz_id"="\d+", "question_id"="\d+" })
     */
    public function updateQuestion(int $quiz_id, int $question_id, Request $request, QuestionRepository $questionRepository,
                                   QuizRepository $quizRepository)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $quest = $questionRepository->find($question_id);
            $quest->setText($question->getText());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quest);
            $entityManager->flush();
            return $this->redirect('success');
        }
        return $this->render(
            'updater/question.html.twig',
            ['form' => $form->createView(), 'answer' => $form->createView()]);
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/answer/{answer_id}/update", name="update_answer",
     *  requirements={"quiz_id"="\d+", "question_id"="\d+", "answer_id"="\d+"})
     */
    public function updateAnswer(int $quiz_id, int $question_id, int $answer_id, Request $request, AnswerRepository $answerRepository)
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();
            $current_answer = $answerRepository->find($answer_id);
            $isCorrect = $current_answer->getIsCorrect();
            if ($isCorrect == true) {
                return $this->redirect('success');
            }
            $current_answer->setText($answer->getText());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($current_answer);
            $entityManager->flush();
            return $this->redirect('success');
        }
        return $this->render(
            'updater/answer.html.twig',
            array('form' => $form->createView())
        );
    }

}