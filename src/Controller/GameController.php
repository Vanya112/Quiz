<?php


namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class GameController extends AbstractController
{
    /**
     * @Route("/gameshow", name="show_quizzes")
     */
    public function showQuizzes(Request $request, QuizRepository $quizRepository)
    {
        return $this->render('game/quizzes.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }

    /**
     * @Route("/gameshow/quiz/{quiz_id}", name="welcome_to_quiz", requirements={"quiz_id"="\d+"})
     */

    public function showStartPage(int $quiz_id, Request $request, QuizRepository $quizRepository,
                                  QuestionRepository $questionRepository, GameRepository $gameRepository)
    {
        $real_number = count($quizRepository->find($quiz_id)->getQuestions());
        return $this->render('game/start_page.html.twig', ['realnumber' => $real_number, 'quiz_id' => $quiz_id]);
    }

    /**
     * @Route("gameshow/create/quiz/{quiz_id}/change", name="changeeee_status", requirements={"quiz_id"="\d+"})
     */
    public function changeStatus(int $quiz_id, Request $request, QuizRepository $quizRepository,
                                 GameRepository $gameRepository)
    {
        $quiz = $quizRepository->find($quiz_id);
        $quiz->setIsActive(!$quiz->getIsActive());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($quiz);
        $entityManager->flush();
        return $this->redirectToRoute('show_admin_quizzes');
    }


}