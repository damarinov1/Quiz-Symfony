<?php

namespace AppBundle\Quiz;

use Symfony\Component\HttpFoundation\Session\Session;


class QuestionsList
{
    /**
     *
     * @var Session 
     */
    protected $session;

    /**
     * 
     * @param Session $session
     */
    function __construct(Session $session)
    {
        $this->session = $session;
    }
    /**
     * 
     * @param type $questionIds
     * @return type $excluded
     */
    public function excluded($questionIds) 
    {
        $excluded = $this->session->get("excluded");
        
        if ($excluded == null) {
            $excluded = $questionIds;
            $this->session->set("excluded", $questionIds);
        }

        return $excluded;
    }
}
