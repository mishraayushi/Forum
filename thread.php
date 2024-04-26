

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iForum -Lets code here..</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
    #ques{
        min-height:433px;
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
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id = $id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];
        // Query the users table to find out the name of original poster
        $sql2="SELECT user_email  FROM `users` WHERE sno ='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['user_email'];
    }
    ?>
     <?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    // echo $method;
    if($method=='POST'){
        // Insert comments into database
        $comment=$_POST['comment'];
        $comment=str_replace("<","&lt;",$comment);
        $comment=str_replace(">","&gt;",$comment);

        $sno=$_POST['sno'];
        $sql="INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id', '$sno', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }


?>

    <div class="container my-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to <?php  echo $title;?></h1>

                <p class="col-md-8 fs-4"><?php echo $desc;?></p>
                <hr class="my-4">
                <p>This is to peer fourm is for sharing knowledge with each other.Respect other participants: Be
                    constructive, and treat other members with respect.
                    Keep the dialogue positive: Participate in constructive discussions, and continue a conversation.
                    Be factual and friendly: Be cautious with humor and irony, and provide feedback.
                    Stay on topic: Avoid straying from the thread.
                </p>
                <p>Posted by <em><?php echo $posted_by; ?></em></p>
            </div>
        </div>

    </div>
    
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'
    <div class="container">
        <h1>Post Comments here</h1>
        <form action="'. $_SERVER['REQUEST_URI'].'" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Type your comment.</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value=" '.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }
    else{
        echo'
        <div class="container">
        <h1>Post Comments here</h1>
        <p class="lead">You are not logged in. Please login to be able to post the comments.</p>
    </div>';
    }
    ?>
   
    <div class="container mb-5" id="ques">
        <h1 class="py-2">Discussions</h1>
        <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `comments` WHERE thread_id = $id";
    $result=mysqli_query($conn,$sql);
    $noResult=true;
    while($row=mysqli_fetch_assoc($result)){
        $noResult=false;
        $id=$row['comment_id'];
        $content=$row['comment_content'];
        $comment_time=$row['comment_time'];
        $thread_user_id=$row['comment_by'];
        $sql2="SELECT user_email  FROM `users` WHERE sno ='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
    
       echo ' <div class="media my-3">
            <img src="img/user1.avif" width="54px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="fw-bold my-0">'.$row2['user_email'] .'at '.$comment_time.'.</p>
              '.$content.'
            </div>
        </div>';
     }
     // echo var_dump($noResult);
     if($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container ">
          <p class="display-5">No Comments found</p>
          <p class="lead">Be the first person to comment.</p>
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