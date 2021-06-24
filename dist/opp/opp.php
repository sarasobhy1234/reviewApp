<?php
class lib 
{
    public $desc;
    private $title;
    //private $price;
    public $pages;
    
  
    public function settitle($titleValue)
    {
       $this->title=$titleValue;
    }
    public function gettitle()
    {
      return $this->title;
    }
   
    function buy()
    {
        return "buy";
    }

}
class novel extends lib
{
   function write()
   {
       return 'write ';
   }
}

class books extends lib
{
   public $auther;
   private $price; 
 
   public function setprice($priceValue)
   {
      $this->price=$priceValue;
   }
   public function getprice()
   {
      return $this->price;
   }



}


?>