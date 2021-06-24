  
<?php  
session_start();
// clean inputs function  
function Clean($input){
   
   $input = trim($input);
   $input = htmlspecialchars($input); 
   $input = stripcslashes($input);

   return $input;
  }



  function url($url)
  {
    return   "http://".$_SERVER['HTTP_HOST']."/dashb/dist/".$url;
}



?>