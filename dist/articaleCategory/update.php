<?php 
   include '../operations/fun.php';
   //include '../operations/checkLogin.php';
   //include '../operations/checkpermission.php';
   include '../operations/connections.php';
   include '../header.php';
            
   
  # Handle Get Request ..... 
  $errors  = array();
  $message = ""; 


  if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    if(isset($_GET['id'])){

        $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

        if(filter_var($id,FILTER_VALIDATE_INT)){
            // CODE ....... 
    
            $sql = "select * from articalescategory where id  =".$id;
        
            $op  = mysqli_query($con,$sql);

            $count = mysqli_num_rows($op);
    
            if($op){
                $message = "Item deleted";
            }else{
                $message = "Error in Delete";  
                $erros['id'] = 1 ;
            }



      if($count == 0){
        $message = "Invalid Id";  
        $errors['id'] = 1 ;

      }


    
        }else{
            $message = "InValid id value";
            $erros['id'] = 1 ;
        }


    }else{
      $message     = "Id Not Founded";  
      $erros['id'] = 1 ;
    }

    
  

      if(count($errors) > 0 ){
          $_SESSION['message'] = $message;
          header("Location: display.php");
      }else{
          $data = mysqli_fetch_assoc($op);
      }




  }










   # Logic ...

   if($_SERVER['REQUEST_METHOD'] == "POST"){
   
    $title = Clean($_POST['title']);
    $id    =  filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);

    if(empty($title)){
        $errors['title'] = "Empty Field";
    }elseif(strlen($title) <= 1){
        $errors['title'] = "Length must be > 1";

    }else{

        $pattern = "/^[a-zA-Z\s*]+$/";

        if(!preg_match($pattern,$title)){
           $errors['title'] = "Invalid Char";

        }
    }


    if(empty($id))
    {
        $errors['id'] = "Empty Field";
    
    }elseif(!filter_var($id,FILTER_VALIDATE_INT))
    {
        $errors['id'] = "Invalid Id";
    }




     if(count($errors) == 0){

     $sql = "update articalescategory set title = '$title' where id=".$id; 

      $op = mysqli_query($con,$sql);

      if($op){
          $message = "Updated";
      }else{
          $message = "Try Again";
      }
      $_SESSION["message"] = $message;
      header("Location: display.php");
     }else{

        $_SESSION["error_message"] = $errors;
        header("Location: edit.php?id=".$id);
  
     }


   }   




?>

<body class="sb-nav-fixed">


    <?php   
       include '../nav.php';
    ?>


    <div id="layoutSidenav">

        <?php   
       include '../sideNav.php';
    ?>



        <div id="layoutSidenav_content">
            <main>


                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard >> (Edit)</li>
                    </ol>



                    <?php
            
     if(isset($_SESSION['error_message']) ){

        foreach($_SESSION['error_message'] as $key => $value){
            echo '* '.$value;
        }
     }

   ?>




                    <!-- form  -->


                    <div class="card-body">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Title</label>
                                <input class="form-control py-4" value="<?php echo $data['title'] ; ?>" name="title"
                                    id="inputEmailAddress" type="text" placeholder="Enter Articale title" required />
                            </div>
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">

                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </form>
                    </div>


                </div>
        </div>






        </main>














        <?php 
            
            include '../footer.php';
            
            ?>