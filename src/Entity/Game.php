<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $current_question;

    /**
     * @ORM\Column(type="integer")
     */
    private $correct_questions_amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_questions_answered;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $start_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getCurrentQuestion(): ?Question
    {
        return $this->current_question;
    }

    public function setCurrentQuestion(?Question $current_question): self
    {
        $this->current_question = $current_question;

        return $this;
    }

    public function getCorrectQuestionsAmount(): ?int
    {
        return $this->correct_questions_amount;
    }

    public function setCorrectQuestionsAmount(int $correct_questions_amount): self
    {
        $this->correct_questions_amount = $correct_questions_amount;

        return $this;
    }

    public function getNumberOfQuestionsAnswered(): ?int
    {
        return $this->number_of_questions_answered;
    }

    public function setNumberOfQuestionsAnswered(int $number_of_questions_answered): self
    {
        $this->number_of_questions_answered = $number_of_questions_answered;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->start_time;
    }

    public function setStartTime(int $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }
}
