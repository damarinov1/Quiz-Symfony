<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Form\AnswerFormType;
use AppBundle\Session\SessionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SingleController extends Controller
{

    /**
     * @Route("/single", name="singleMode")
     */
    public function indexAction(Request $r)
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

        $aRepo = $this->getDoctrine()->getRepository(Answer::class);
        $answer = $aRepo->findRandom();

        $form = $this->createForm(AnswerFormType::class);
        $form->handleRequest($r);


        return $this->render("layouts/single.html.twig", [
                "questions" => $questionArray,
                "answer" => $answer,
                "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/single/check-answer", name="checkAnswerTf")
     * @Method("POST")
     */
    public function checkAnswerAction(Request $r)
    {
        $sessionManager = $this->getSessionManager();
        $data = $r->request->all();
        $postData = $data['answer_form'];

        $correctAnsIndex = $this->getDoctrine()->getRepository(Question::class)
                ->find($postData["question"])->getAnswer()->getId();

        $answerCheck = $this->get("app.answer_check");
        $answerCheck->checkAnswerTf($correctAnsIndex, $postData['answer'], $data['answer_input']);

        if ($sessionManager->isFinished()) {
            return $this->render("layouts/results.html.twig");
        } else {
            return $this->redirectToRoute("singleMode");
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
