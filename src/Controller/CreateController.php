<?php


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
     * @Route("/gameshow/create/quiz/{quiz_id}/create", name="create_question", requirements={"quiz_id"="\d+"})
     */
    public function createQuestion(int $quiz_id, Request $request, QuizRepository $quizRepository)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $answer = new Answer();
        $form_answer = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        $form_answer->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();
            $answer = $form_answer->getData();
            $answer->setIsCorrect(true);
            $question->addAnswer($answer);
            $quiz = $quizRepository->find($quiz_id);
            $question->addQuiz($quiz);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('show_admin_quizzes');
        }
        return $this->render(
            'creater/question.html.twig',
            ['form' => $form->createView(), 'answer' => $form_answer->createView()]);
    }

    /**
     * @Route("/gameshow/create/quiz/{quiz_id}/question/{question_id}/create", name="create_answer",
     *  requirements={"quiz_id"="\d+", "question_id"="\d+"})
     */
    public function createAnswer(int $quiz_id, int $question_id, Request $request, QuestionRepository $questionRepository)
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();
            $answer->setIsCorrect(false);
            $question = $questionRepository->find($question_id);
            $answer->setQuestion($question);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();
            return $this->redirect('success');
        }
        return $this->render(
            'creater/answer.html.twig',
            array('form' => $form->createView())
        );
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