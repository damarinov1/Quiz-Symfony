<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Session\SessionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MultipleController extends Controller
{

    /**
     * @Route("/multiple", name="multipleMode")
     */
    public function indexAction()
    {
        $session = $this->get("session");

        if (!$session->get("isStarted")) {
            $this->getSessionManager()->init();
        }

        $qRepo = $this->getDoctrine()->getRepository(Question::class);
        $questionIds = $qRepo->findRandomList();

        $this->get("app.questions_list")->excluded($questionIds);
        $excluded = $session->get("excluded");

        foreach ($excluded as $key => $id) {
            $questionArray[$key] = $qRepo->find($id);
        }

        $ansQuestionsCount = $session->get("answeredQuestionsCount");
        $excludedList = $session->get("excluded");
        $correctAnswerId = $qRepo->find($excludedList[$ansQuestionsCount])->getAnswer()->getId();

        $aRepo = $this->getDoctrine()->getRepository(Answer::class);
        $answerList = $aRepo->findRandomAnsList($correctAnswerId);
                
        return $this->render("layouts/multiple.html.twig", [
                "questions" => $questionArray,
                "answerList" => $answerList
        ]);
    }

    /**
     * @Route("/multiple/check-answer", name="checkAnswerMc")
     * @Method("POST")
     */
    public function answerCheckAction(Request $r)
    {
        $session = $this->get("session");
        $sessionManager = $this->getSessionManager();

        $data = $r->request->all();
        $postData = $data['answer'];

        $ansQuestionsCount = $session->get("answeredQuestionsCount");
        $excludedList = $session->get("excluded");
        $correctAnswerIndex = $this->getDoctrine()->getRepository(Question::class)
                ->find($excludedList[$ansQuestionsCount])->getAnswer()->getId();

        $answerCheck = $this->get("app.answer_check");
        $answerCheck->checkAnswerMc($correctAnswerIndex, $postData);
        
        if ($sessionManager->isFinished()) {
            return $this->render("layouts/results.html.twig");
        } else {
            return $this->redirectToRoute("multipleMode");
        }
    }

    /**
     * 
     * @return SessionManager
     */
    public function getSessionManager()
    {
        return $this->get('app.session_manager');
    }
}
