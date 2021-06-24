<?php    
include '../operations/fun.php';
include '../operations/checkLogin.php';
include '../operations/checkpermission.php';
include '../operations/connections.php';
include '../header.php';

   


    $errors = array();
   if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    if(isset($_GET['id'])){

        $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

        if(filter_var($id,FILTER_VALIDATE_INT)){
          
    
            $sql = "select * from admins where id  =".$id;
        
            $op  = mysqli_query($con,$sql);

            $count = mysqli_num_rows($op);



      if($count == 0){
        $message = "Invalid Id";  
        $errors['id'] = 1 ;

      }


    
        }else{
            $message = "InValid id value";
            $errors['id'] = 1 ;
        }


    }else{
      $message     = "Id Not Founded";  
      $errors['id'] = 1 ;
    }

    
  

      if(count($errors) > 0 ){
          $_SESSION['message'] = $message;
          header("Location: dispalyAdmins.php");
      }else{
          $data = mysqli_fetch_assoc($op);
      }




  }


















    # select role .. 
    $sql = "select * from roles";
    $op  = mysqli_query($con,$sql);


   # Logic ...
   
   $errorMessages  = array();
   $message = ""; 
   if($_SERVER['REQUEST_METHOD'] == "POST"){
 


    $name     = Clean($_POST['name']);
    $email    = Clean($_POST['email']);
    $address  = Clean($_POST['address']);
    $phone    = Clean($_POST['phone']);
    $role     = $_POST['role'];
    $id       =  filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);

   # METHOD 2 ... 

  if(empty($name)){
   
   $errorMessages['name'] = "Name Field Required";
      
   }else{
         if(strlen($name) < 3){
           $errorMessages['name']  = "Name must be >= 3";
         }elseif (!preg_match("/^[a-zA-Z\s*']+$/",$name)) { 
             # code...
             $errorMessages['name']  = "Only chars allowed";

         }    
   }



  // Validate email 
  if(empty($email)){
     $errorMessages['email'] = "Email Field Required";
  }else{
   
   // filter_var($email,FILTER_VALIDATE_EMAIL))) == flase || 0 
   if(!(filter_var($email,FILTER_VALIDATE_EMAIL))){    
       $errorMessages['email']  = "Invalid Email";
   }

  }










  if(empty($address)){
    $errorMessages['address'] = "address Field Required";
       
    }else{
          if(strlen($address) < 5){
            $errorMessages['address']  = "Address must be >= 5";
          }elseif (!preg_match("/^[a-zA-Z\s*']+$/",$address)) { 
              # code...
              $errorMessages['address']  = "Only chars allowed";
 
          }    
    }




    if(empty($phone)){
        $errorMessages['phone'] = "phone Field Required";
           
        }else{
              if(strlen($phone) < 10){
                $errorMessages['phone']  = "phone must be >= 10";
              }
              elseif (!preg_match("/^\d{11}$/",$phone)) { 
                  # code...
                  $errorMessages['phone']  = "Only Numbers allowed";
     
              }    
        }
    


   
        if(empty($role)){
            $errorMessages['role'] = "role Field Required";   
            }
        



            if(empty($id))
            {
                $errors['id'] = "Empty Field";
            
            }elseif(!filter_var($id,FILTER_VALIDATE_INT))
            {
                $errors['id'] = "Invalid Id";
            }




     if(count($errorMessages) == 0){

    
      $sql = "update admins set name='$name' , address='$address', email='$email',phone='$phone' , role_id=$role where id =".$id;
      
      $op = mysqli_query($con,$sql);

      if($op){
          $message = "Updated";
      }else{
          $message = "Try Again";
      }
 
        $_SESSION['message'] = $message;
       header("Location: dispalyAdmins.php");
     }else{
        $_SESSION['error_messsage'] = $errorMessages;
        header("Location: add.php");


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
                        <li class="breadcrumb-item active">Dashboard  :  (Edit Admin)</li>
                    </ol>



                    <?php
            
     if(isset($_SESSION['error_messsage']) ){

        foreach($_SESSION['error_messsage'] as $key => $value){
            echo '* '.$key.' : '.$value.'<br>';
        }
     }
  echo $message;

   ?>





                    <div class="card-body">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            
                        <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Name</label>
                                <input class="form-control py-4" name="name" value="<?php echo $data['name'];?>" id="inputEmailAddress" type="text"
                                    placeholder="Enter name " required />
                            </div>



                           <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                           
                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                <input class="form-control py-4" name="email"   value="<?php echo $data['email'];?>" id="inputEmailAddress" type="email"
                                    placeholder="Enter email" required />
                            </div>


                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Address</label>
                                <input class="form-control py-4" name="address" value="<?php echo $data['address'];?>"  id="inputEmailAddress" type="text"
                                    placeholder="Enter Address title" required />
                            </div>



                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Phone</label>
                                <input class="form-control py-4" name="phone"   value="<?php echo $data['phone'];?>" id="inputEmailAddress" type="text"
                                    placeholder="Enter Phone " required />
                            </div>




                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Role</label>
                              <select  class="form-control py-4" name="role" required>
                            <?php   while($fetchedData = mysqli_fetch_assoc($op)){ ?> 
                                <option value="<?php echo $fetchedData['id'];?>"    <?php if($data['role_id'] == $fetchedData['id'] ){echo 'selected';}?>  > <?php echo $fetchedData['title'];?></option>
                             <?php } ?>
                            </select>    
                            </div>


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