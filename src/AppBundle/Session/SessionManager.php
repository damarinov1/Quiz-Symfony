<?php
namespace AppBundle\Session;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

/**
 * Description of Session
 *
 * @author denis
 */
class SessionManager
{

    /**
     *
     * @var SymfonySession
     */
    protected $session;

    /**
     * 
     * @param SymfonySession $session
     */
    function __construct(SymfonySession $session)
    {
        $this->session = $session;
        //$session->start();
    }

    public function init()
    {
        $this->session->set("totalQuestionsCount", 10);
        $this->session->set("answeredQuestionsCount", 0);
        $this->session->set("correctQuestionsCount", 0);
        $this->session->set("isStarted", true);
        $this->session->set("mode", "tf");
        $this->session->set("excluded", []);
    }

    public function read()
    {
        return dump($this->session->all());
    }

    public function getTotalQuestions()
    {
        return $this->session->get("totalQuestionsCount");
    }
    
    public function getAnsweredQuestions()
    {
        return $this->session->get("answeredQuestionsCount");
    }

    public function getCorrectAnswers()
    {
        return $this->session->get("correctQuestionsCount");
    }

    public function getExcluded()
    {
        return $this->session->get("excluded");
    }

    public function incrementAnsweredQuestion()
    {
        $this->incrementValue("answeredQuestionsCount");
    }

    public function incrementCorrectAnswer()
    {
        $this->incrementValue("correctQuestionsCount");
    }

    public function addToExcluded($id)
    {
        $array = $this->session->get("excluded");
        $this->session->set("excluded", [$array, $id]);
    }

    public function resetExcluded()
    {
        $this->session->set("excluded", []);
    }

    public function destroy()
    {
        $this->session->clear();

        return $this->redirectToRoute("singleMode");
    }
    
    public function isFinished()
    {
        if ($this->getTotalQuestions() == $this->getAnsweredQuestions()) {
            return true;
        } else {
            return false;
        }
    }

    public function incrementValue($key)
    {
        $i = $this->session->get($key, 0);
        $this->session->set($key, $i + 1);
    }
}
