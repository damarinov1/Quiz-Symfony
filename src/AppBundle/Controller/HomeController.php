<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->redirectToRoute("singleMode");
    }

    /**
     * @Route("/session/destroy", name="destroySession")
     */
    public function destroySessionAction()
    {
        $session = new Session();

        $session->clear();
        $session->getFlashBag()->clear();

        return $this->redirectToRoute("singleMode");
    }

    /**
     * @Route("/mode/change", name="changeMode")
     * @Method("POST")
     */
    public function changeModeAction(Request $r)
    {
        $session = new Session();
        
        $data = $r->request->all();
        $mode = $data["mode"];
        $session->set("mode", $mode);
        
        if ($session->get("answeredQuestionsCount") > 0) {
            $session->clear();
            $session->getFlashBag()->clear();
        }

        $map = [
            "tf" => "singleMode",
            "mc" => "multipleMode"
        ];

        return $this->redirectToRoute($map[$mode]);
    }
}
