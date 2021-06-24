<?php             
  include '../operations/fun.php';
  include '../operations/checkLogin.php';
  include '../operations/checkpermission.php';
  include '../operations/connections.php';
  include '../header.php';
 
   
    $sql = "select * from articalesCategory";
    $op  = mysqli_query($con,$sql);


  
   
   $errorMessages  = array();
   $message = ""; 
   if($_SERVER['REQUEST_METHOD'] == "POST"){
 


    $title     = Clean($_POST['title']);
    $desc      = Clean($_POST['desc']);
    $cat_id    = filter_var($_POST['cat_id'],FILTER_SANITIZE_NUMBER_INT);
    $image     = '';


  
  if(empty($title)){
   
   $errorMessages['title'] = "Title Field Required";
      
   }else{
         if(strlen($title) < 3){
           $errorMessages['title']  = "title must be >= 3";
         }elseif (!preg_match("/^[a-zA-Z\s*']+$/",$title)) { 
            
             $errorMessages['title']  = "Only chars allowed";

         }    
   }





   if(empty($desc)){
   
    $errorMessages['desc'] = "desc Field Required";
       
    }else{
          if(strlen($desc) < 100){
            $errorMessages['desc']  = "desc must be >= 100";
          }
       
    }
 

        if(empty($cat_id)){
            $errorMessages['cat_id'] = "Category Field Required";   
            }
        


            if(!empty($_FILES['image']['name'])){

                $fileTempPath  = $_FILES['image']['tmp_name'];
                $fileName      = $_FILES['image']['name'];
                // $fileSize      = $_FILES['uploadedFiles']['size'];
                // $filetype      = $_FILES['uploadedFiles']['type'];
        
    
        
                $fileExtension =   explode(".",$fileName);
                
                $newName = rand().time().'.'.strtolower($fileExtension[1]);
        
                 $allowedExtensions = array('png','jpg');
        
                 if(in_array($fileExtension[1],$allowedExtensions)){
        
                  // code ....
                  
                  $uploaded_folder = "./uploads/";
        
                  $desPath = $uploaded_folder.$newName;
        
                 if(!move_uploaded_file($fileTempPath,$desPath)){
                    $errorMessages['image'] = "Error in Uplading file";  
                 }else{
                     $image =  $newName;
                 }
        
        
                 }else{
        
                    $errorMessages['image'] =  'Not Allowed Extension';
                 }
                }else{
        
                    $errorMessages['image'] =  'please upload File';
        
                }






     if(count($errorMessages) == 0){
      
        $addedBy = $_SESSION['id'];
    
      $sql = "insert into articales ( `title`, `descrip`, `added_by`, `cat_id`, `image`) values ('$title','$desc', $addedBy ,$cat_id,'$image')";

      $op = mysqli_query($con,$sql);

      if($op){
          $message = "Inserted";
      }else{
          $message = "Try Again";
      }
 
        $_SESSION['message'] = $message;
      header("Location: display.php");
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
                        <li class="breadcrumb-item active">Dashboard : (Add Articale)</li>
                    </ol>



                    <?php
            
     if(isset($_SESSION['error_messsage']) ){

        foreach($_SESSION['error_messsage'] as $key => $value){
            echo '* '.$key.' : '.$value.'<br>';
        }
     }
  echo $message;

   ?>




                    <!-- form  -->


                    <div class="card-body">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Title</label>
                                <input class="form-control py-4" name="title" id="inputEmailAddress" type="text"
                                    placeholder="Enter name " required />
                            </div>


                            


                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Description</label>
                                 <textarea class="form-control py-4" name="desc"></textarea>

                            </div>

                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Category</label>
                                <select class="form-control py-4" name="cat_id" required>
                                    <?php   while($data = mysqli_fetch_assoc($op)){ ?>
                                    <option value="<?php echo $data['id'];?>"> <?php echo $data['title'];?></option>
                                    <?php } ?>
                                </select>
                            </div>



                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Upload Image</label>
                                 <input type="file" class="form-control" name="image">
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