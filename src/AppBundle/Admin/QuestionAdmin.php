<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;


class QuestionAdmin extends AbstractAdmin
{
    //put your code here
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add("question", "text")->add("aid", "integer");
        
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add("question");
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier("question")->addIdentifier("aId");
    }
}
