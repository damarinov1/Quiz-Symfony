<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionsRepository")
 */
class Question
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var Answer
     *
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="questions")
     * @ORM\JoinColumn(name="a_id", referencedColumnName="id", nullable=false)
     */
    private $answer;

    /**
     * 
     * @return Answer
     */
    function getAnswer()
    {
        return $this->answer;
    }

    /**
     * 
     * @param \AppBundle\Entity\Answer $answer
     */
    function setAnswer(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    public function __toString()
    {
        return $this->question;
    }
}
