<?php         
include '../operations/fun.php';
include '../operations/checkLogin.php';
include '../operations/checkpermission.php';
include '../operations/connections.php';
include '../header.php';
    
   $sql="select * from roles ";
   $op=mysqli_query($con, $sql);
   
   # Logic 
   
   $errors  = array();
   $message = ""; 
   if($_SERVER['REQUEST_METHOD'] == "POST"){
   
  
 
 

    $name = Clean($_POST['name']);
    $password= Clean($_POST['pwd']);
    $email= Clean( $_POST['email']);
    $phone= Clean( $_POST['phone']);
    $address= Clean( $_POST['address']);
    $role=  $_POST['role'];
  



 // validate email

 if( empty($email) )
 {
    $errors['email']= "Email field is required";
}
else 
{
    if(filter_var($email,FILTER_VALIDATE_EMAIL)==false)
    {
        $errors['email'] ="Invaild email";
    }
   
}



// validate password
if (empty($password))
{
    $errors['password']= "password feild requid";
}
else
 {
    if(strlen($password)<8)
   {
    $errors['password'] ="Nmae must be >8 char !";
   }
  
}






//validate name

    if(empty($name)){
        $errors['name'] = "Empty Field";
    }elseif(strlen($name) < 3){
        $errors['name'] = "Length must be > 3";

    }else{

        $pattern = "/^[a-zA-Z\s*]+$/";

        if(!preg_match($pattern,$name)){
            $errors['name'] = "Invalid Input";

        }

    }

// validate address
    if(empty($address)){
        $errors['address'] = "Empty Field";
    }elseif(strlen($address) < 10){
        $errors['address'] = "Length must be > 10";

    }else{

        $pattern = "/^[a-zA-Z\s*]+$/";

        if(!preg_match($pattern,$address)){
            $errors['address'] = "Invalid Input";

        }

    }

// validate phone number 
    if(empty($phone)){
        $errors['phone'] = "Empty Field";
    }elseif(strlen($phone) != 11){
        $errors['phone'] = "Length must be 11";

    }else{

        $patternNum = "/^\d{11}$/";

        if(!preg_match($patternNum,$phone)){
            $errors['phone'] = "Invalid Input";

        }

    }





//validate role 

if(empty($role)){
    $errors['role'] = "Empty Field";
}


     if(count($errors) == 0){
       $password = md5($password);
      $sql = "insert admins(`name`, `email`, `password`, `phone`, `address`, `role_id`)
       values ('$name','$email','$password','$phone','$address','$role')";
      
      
       

      $op = mysqli_query($con,$sql);

      if($op){
          $message = "Inserted";
      }else{
          $message = "Try Again";
      }
      $_SESSION['message']= $message;
      header("Location: dispalyAdmins.php");
  
      }
    else{
        $_SESSION['errors']= $errors;
        header("Location: add.php");
     }








   }




?>
<body class="sb-nav-fixed">
    <?php include '../nav.php';?>

 <div id="layoutSidenav">    
  <?php  include '../sideNav.php'; ?>
  
<div id="layoutSidenav_content">
               
  <div class="container">


  <div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <?php
            
            if(isset($_SESSION['errors'])){
       
               foreach( $_SESSION['errors'] as $key => $value){
                   echo '* '.$value;
               }
            }
                    
            
          echo $message;
       unset($_SESSION['errors']);
       
       
          ?>
   <h2>Register Form</h2>
   <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
   <div class="form-group">
      <label for="name">Name:</label>
      <input type="name"  class="form-control" id="name" placeholder="Enter name" name="name">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" required class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password"  required class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="number"  required  class="form-control" id="phone" placeholder="Enter phone" name="phone">
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" required  class="form-control" id="address" placeholder="Enter address" name="address">
    </div>
    <div class="form-group">
      <label for="role">Role:</label>
      <select class="form-control py-4" name ="role" required>
      <?php   while($data = mysqli_fetch_assoc($op)){ ?>
      <option value = "<?php echo $data['id']; ?>"> <?php echo $data['title'];  ?> </option>
    <?php } ?>
      </select>
     </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
 </div>

                  
 </div>
                        
 <?php include '../footer.php';?>