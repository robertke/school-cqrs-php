<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jbnahan\Domain\School\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Jbnahan\Domain\School\Event\ClassOpened;
use Jbnahan\Domain\School\Event\ClassRenamed;
use Jbnahan\Domain\School\Command\OpenClassCommand;

/**
 * Description of Class
 *
 * @author jb
 */
class StudentsClass extends EventSourcedAggregateRoot {
    
    protected $students;
    
    protected $identity;
	
	protected $id;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }
    
    public static function openClass(OpenClassCommand $command) {
        $identity = new ClassIdentity($command->name, $command->grade);
        $sc = new StudentsClass();

        $sc->apply(new ClassOpened($command->classId,$identity));
        return $sc;
    }


    public function renameClass($name) {
        
        $this->apply(new ClassRenamed($this->id, $name));
    }
    
    
    
    protected function applyClassOpened($event) {
        $this->identity = $event->identity;
        $this->id = $event->id;
    }
    
    protected function applyClassRenamed($event) {
        $this->identity->name = $event->name;
    }
}
