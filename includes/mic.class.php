<?php
/***
 * //This all the specifiers in the php.
 * public
 * private
 * protected
 */

class mic
{
    private $brand;
    public $color;
    public $model;
    public $usb_port;
    public $price;
    private $light;
  public function __call($name,$arguments){
  print("name <br>");
  print_r($arguments);
  print("<br>");
}

    public static function testFunction(){

      printf("this is a function. it works without object");
    }

   public function __construct($brand){
      print("\n"."constructing model"."\n");
      $this->brand = ucwords($brand);
   }
   public function getbrand(){
      return $this->brand;
   }

    public function setlight($light)
    {
      $this->light = $light;
      echo $light;
    }
    private function getmodel(){
      return $this-> model;
    }
    public function setmodel($model){
      $this->model = ucwords($model);
    }

    public function getmodelproxy(){
      return $this->getmodel();
    }

    public function __destruct(){
      print("destructing");
    }

}
function test(){

}


