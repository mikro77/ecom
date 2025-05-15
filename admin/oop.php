<?php 

/*
* this page for oop tutorials
*/

class Fruit { 

    //propertes
    public $name ;
    public $color ;
    //method 
    public function setname ($ne) {
     $this->name = $ne; 
    }
    public function getname () {
    return $this->name ; 
    }
    }

$apple  = new fruit() ; 
$apple->setname('Orange');
echo $apple->getname();
echo '<pre>';
echo var_dump($apple);
echo '</pre>';

/*
! The __construct Function
*/
class Ft {
 
 public $name ;
 public $color ;
 
 public function __construct($name){
   $this->name = $name ;
 }

 public function get_name () {
   return $this->name ;  
 }

}

$apple = new Ft("Apple");
echo $apple->get_name();

/*
! END __construct Function
*/

/*
! The Inheritance Function
*/

class device {
 
    public $name  ;
    public $color ;
    
    public function __construct($name){
     $this->name = $name;
    }
   
    public function get_name () {
     return $this->name ;  
    }
   
   }




class sony extends device {
 
 
   //Inheritance Function above function by using extend 
   // can we add new propertes or method  new name and use above method 
   
   }

$son = new sony ("rrrrrrrrr");
echo $son->get_name();

   
/*
! END Inheritance Function
*/

/*
! The Final Function & final class 
*/
class devices {
 
    public $name ;
    public $color ;  
    public function __construct($name){
     $this->name = $name;
    }
    final public function mycolor ($color){
        $this->color = $color;
        echo "the color of devices  " . $this->color ; 
    } 
    public function get_name () {
    return $this->name ;  
    }
   
   }


 class sonys extends devices { 

   }

$son = new sonys ("rrrrrrrrr");
echo $son->mycolor ("red"); 
echo $son->get_name();


// final class cant inhirits from this 
// final function can inhirits but not update it or use it another class
/*
! END Final Function
*/









































   


























?> 