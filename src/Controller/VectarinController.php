<?php


namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\GameRepository;
use App\Entity\Game;
use App\Repository\UserRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Question\AnswerType;
use App\Entity\Answer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

class VectarinController extends AbstractController
{

    /**
     * @Route("/gameshow/quiz/{quiz_id}/number/{question_id}/questions/{realnumber}",name="questionshow",
     *     requirements={"question_id"="\d+", "quiz_id"="\d+", "realnumber_id"="\d+"})
     *
     */

    public function goToQuestion(int $quiz_id, int $question_id,
                                 int $realnumber,
                                 AnswerRepository $answerRepository,
                                 GameRepository $gameRepository,
                                 QuizRepository $quizRepository,
                                 UserRepository $userRepository,
                                 QuestionRepository $questionRepository,
                                 Request $request,
                                 UserInterface $user): Response
    {
        $userId = $this->get('security.token_storage')->getToken()->getUser();
        $testgame = $gameRepository->findOneBy(['quiz' => $quiz_id, 'user' => $userId]);
        if ($question_id === 0 && $testgame === null) {
            $game = new Game();
            $game->setCorrectQuestionsAmount(0);
            $game->setNumberOfQuestionsAnswered(0);
            $game->setTime(0);
            $game->setStartTime(time());
            $user = $userRepository->find($userId);
            $game->setUser($user);
            $quiz = $quizRepository->find($quiz_id);
            $game->setQuiz($quiz);
            $questions = $quiz->getQuestions();
            $question = $questions[$question_id];
            $game->setCurrentQuestion($question);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();
            $realnumber = count($questions);
            $question_id = 0;
        } else {
            $question_id = $testgame->getNumberOfQuestionsAnswered();
            $my_quiz = $quizRepository->find($quiz_id);
            $realnumber = count($my_quiz->getQuestions());
        }

        if ($realnumber == $question_id) {
            $game = $gameRepository->findOneBy(['quiz' => $quiz_id, 'user' => $userId]);
            $game1 = $game;
            $time = time() - $game1->getStartTime();
            $game1->setTime($time);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($game);
            $entityManager->flush();
            $entityManager->persist($game1);
            $entityManager->flush();
            return $this->redirect('configuration/quiz');
        } else {
            $game = $gameRepository->findOneBy(['quiz' => $quiz_id, 'user' => $userId]);
            $answer = new Answer();
            $questions = $quizRepository->find($quiz_id)->getQuestions();
            $question = $questions[$question_id]->getId();
            $quest = $questions[$question_id];
            $form = $this->createForm(AnswerType::class, $answer);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $answer = $form->getData();
                $text = $answer->getText();
                $my_answer = $answerRepository->findOneBy(['text' => $text, 'question' => $question]);
                if ($my_answer != null) {
                    $game->setCurrentQuestion($quest);
                    $game->setNumberOfQuestionsAnswered($question_id + 1);
                    if ($my_answer->getIsCorrect() === true) {
                        $game->setCorrectQuestionsAmount($question_id + 1);
                        $game1 = $game;
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($game);
                        $entityManager->flush();
                        $entityManager->persist($game1);
                        $entityManager->flush();
                        return $this->render('result/success.html.twig', ['answers' => $answerRepository->findBy(
                            ['question' => $question]
                        ), 'question' => $questionRepository->find($question),
                            'question_id' => $question_id,
                            'quiz' => $quizRepository->find($quiz_id), 'form' => $form->createView(),
                            'number' => $realnumber]);
                    } else {
                        $game1 = $game;
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($game);
                        $entityManager->flush();
                        $entityManager->persist($game1);
                        $entityManager->flush();
                        return $this->render('result/fail.html.twig', ['answers' => $answerRepository->findBy(
                            ['question' => $question]
                        ), 'question' => $questionRepository->find($question),
                            'question_id' => $question_id,
                            'quiz' => $quizRepository->find($quiz_id), 'form' => $form->createView(),
                            'number' => $realnumber]);
                    }

                }

            }
            return $this->render('vectarin/test.html.twig', ['answers' => $answerRepository->findBy(
                ['question' => $question]
            ), 'question' => $questionRepository->find($question),
                'question_id' => $question_id,
                'quiz' => $quizRepository->find($quiz_id), 'form' => $form->createView(),
                'number' => $realnumber]);
        }

    }

    /**
     * @Route("/gameshow/quiz/{quiz_id}/number/{question_id}/questions/configuration/quiz",name="question_configuration",
     *     requirements={"question_id"="\d+", "quiz_id"="\d+", "realnumber_id"="\d+"})
     *
     */
    public function configuration(int $quiz_id, int $question_id, QuizRepository $quizRepository, GameRepository $gameRepository)
    {
        $quiz = $quizRepository->find($quiz_id);
        return $this->render('vectarin/configuration.html.twig', ['quiz_id' => $quiz_id]);
    }

    /**
     * @Route("/gameshow/rate/{quiz_id}/quiz/",name="quiz_rate",
     *     requirements={"quiz_id"="\d+"})
     *
     */
    public function rate(int $quiz_id, QuizRepository $quizRepository, GameRepository $gameRepository)
    {
        $quiz = $quizRepository->find($quiz_id);
        return $this->render('game/rate.html.twig', ['quiz_id' => $quiz_id,
            'games' => $gameRepository->findBy(['quiz' => $quiz])]);
    }

    /**
     * @Route("/gameshow/quiz/{quiz_id}/number/{question_id}/questions/{realnumber}/success",name="question_success",
     *     requirements={"question_id"="\d+", "quiz_id"="\d+", "realnumber_id"="\d+"})
     *
     */
    public function success()
    {
        return $this->render('result/success.html.twig');
    }

    /**
     * @Route("/gameshow/quiz/{quiz_id}/number/{question_id}/questions/{realnumber}/fail",name="question_fail",
     *     requirements={"question_id"="\d+", "quiz_id"="\d+", "realnumber_id"="\d+"})
     *
     */
    public function fail()
    {
        return $this->render('result/fail.html.twig');
    }

}