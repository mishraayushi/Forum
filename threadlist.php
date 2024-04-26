<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iForum -Lets code here..</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
</head>

<body>
<?php 
    include 'partials/db_connect.php';

    ?>
    <?php
    include 'partials/_header.php';
    ?>
   
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id = $id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname=$row['category_name'];
        $catdesc=$row['category_description'];
    }
    ?>
    <?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    // echo $method;
    if($method=='POST'){
        // Insert thread into database
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];
        $th_title=str_replace("<","&lt;",$th_title);
        $th_title=str_replace(">","&gt;",$th_title);

        $th_desc=str_replace("<","&lt;",$th_desc);
        $th_desc=str_replace(">","&gt;",$th_desc);
        $sno=$_POST['sno'];
        $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', '2024-03-31 09:27:52.000000')";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added!.Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }


?>

    <div class="container my-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to <?php  echo $catname;?></h1>

                <p class="col-md-8 fs-4"><?php echo $catdesc;?></p>
                <hr class="my-4">
                <p>This is to peer fourm is for sharing knowledge with each other.Respect other participants: Be
                    constructive, and treat other members with respect.
                    Keep the dialogue positive: Participate in constructive discussions, and continue a conversation.
                    Be factual and friendly: Be cautious with humor and irony, and provide feedback.
                    Stay on topic: Avoid straying from the thread.
                </p>
                <button class="btn btn-success btn-lg" type="button">Example button</button>
            </div>
        </div>

    </div>
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'
    <div class="container">
        <h1>Start Discussion here</h1>
        <form action="'. $_SERVER["REQUEST_URI"].'" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="title" class="form-text">Keep your title as short as possible.</div>
            </div>
            <input type="hidden" name="sno" value=" '.$_SESSION["sno"].'">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Elaborate your problem here</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    ';
    }
    else{
        echo'
        <div class="container">
        <h1>Start Discussion here</h1>
        <p class="lead">You are not logged in. Please login to be able to start the discussion.</p>
    </div>';
    }
    ?>
    
    <div class="container mb-5" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id = $id";
    $result=mysqli_query($conn,$sql);
    $noResult=true;
    while($row=mysqli_fetch_assoc($result)){
        $noResult=false;
        $id=$row['thread_id'];
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_time=$row['timestamp'];
        $thread_user_id=$row['thread_user_id'];
        $sql2="SELECT user_email  FROM `users` WHERE sno ='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);





       echo ' <div class="media my-3">
            <img src="img/user1.avif" width="54px" class="mr-3" alt="...">
            <div class="media-body">'.
           
                '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.' "> '.$title.'</a></h5>
                '.$desc.'</div>'. '<div class="fw-bold my-0 float-end">Asked by '.$row2['user_email'].' at '.$thread_time.'</div>'.
        '</div>';
    }
        // echo var_dump($noResult);
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container ">
              <p class="display-5">No Threads found</p>
              <p class="lead">Be the first person to ask the question.</p>
            </div>
          </div>';
        }
     
    ?>

    </div>




    <?php
    include 'partials/_footer.php';
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
