<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jbnahan\Domain\School\Listener;

use Jbnahan\Domain\School\Event\StudentRegistred;
use Jbnahan\Bundle\SchoolBundle\Entity\Student;

use Broadway\EventHandling\EventListenerInterface;
use Broadway\Domain\DomainMessageInterface;
use Doctrine\ORM\EntityManager;
/**
 * Description of StudentViewListener
 *
 * @author jb
 */
class StudentViewListener {
    
    private $em;


    public function __construct(EntityManager $em) {
        $this->em = $em;
    }


    public function handle(DomainMessageInterface $domainMessage)
    {
        
        //print_r($domainMessage);
        $evt = $domainMessage->getPayload();
        $class = explode("\\",get_class($evt));
        $method = 'on' . end($class);
        if (! method_exists($this, $method)) {

            return;
        }

        $this->$method($evt, $domainMessage->getPlayhead());
    }
    
    public function onStudentRegistred(StudentRegistred $event, $version) {
        $student = new Student();
        
        $student->setId($event->id);
        $student->setLastName($event->identity->lastName);
        $student->setFirstName($event->identity->firstName);
        $student->setBornOn($event->identity->bornOn);
        $student->setVersion($version);
        
        $this->em->persist($student);
        $this->em->flush();
    }
}
