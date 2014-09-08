<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jbnahan\Domain\School\Event;

use Broadway\Serializer\SerializableInterface;
use Jbnahan\Domain\School\Model\StudentIdentity;

/**
 * Description of StudentRegistred
 *
 * @author jb
 */
class StudentRegistred implements SerializableInterface {
    public $identity;
    
    public $id;
    
    public static function deserialize(array $data){
    	$e = new StudentRegistred();
    	$e->id = $data['id'];
        //$date = \DateTime::createFromFormat('Y-m-d H:i:s', $data['bornOn']);
    	$e->identity = new StudentIdentity($data['firstName'], $data['lastName'], $data['bornOn']);
		return $e; 
	}

    /**
     * @return array
     */
    public function serialize(){
        //$date = $this->identity->bornOn->format('Y-m-d H:i:s');
    	return array("firstName"=>$this->identity->firstName,"lastName"=>$this->identity->lastName,"bornOn"=>$this->identity->bornOn, "id"=>$this->id);
    }
}
