<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Quiz;

use AppBundle\Session\SessionManager;
use Symfony\Component\HttpFoundation\Session\Session;

class AnswerCheck
{

    protected $sessionManager;
    protected $session;

    function __construct(SessionManager $sessionManager, Session $session)
    {
        $this->sessionManager = $sessionManager;
        $this->session = $session;
    }

    public function checkAnswerTf($correctAnswerIndex, $answer, $answer_input)
    {

        if ($correctAnswerIndex == $answer) {
            if ($answer_input === "yes") {
                $this->sessionManager->incrementCorrectAnswer();
                $this->session->getFlashBag()->add("notice", ["type" => "success", "message" => "Correct!"]);
            } else {
                $this->session->getFlashBag()->add("notice", ["type" => "danger", "message" => "Not correct! But keep it going"]);
            }
        }

        if ($correctAnswerIndex != $answer) {
            if ($answer_input === "no") {
                $this->sessionManager->incrementCorrectAnswer();
                $this->session->getFlashBag()->add("notice", ["type" => "success", "message" => "Correct!"]);
            } else {
                $this->session->getFlashBag()->add("notice", ["type" => "danger", "message" => "Not correct. But keep it going!"]);
            }
        }

        $this->sessionManager->incrementAnsweredQuestion();
    }

    public function checkAnswerMc($correctAnswerIndex, $answer)
    {
        if ($answer == $correctAnswerIndex) {
            $this->sessionManager->incrementCorrectAnswer();
            $this->session->getFlashBag()->add("notice", ["type" => "success", "message" => "Correct!"]);
        } else {
            $this->session->getFlashBag()->add("notice", ["type" => "danger", "message" => "Not correct! But keep it going"]);
        }

        $this->sessionManager->incrementAnsweredQuestion();
    }
}
