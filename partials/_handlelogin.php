<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include 'db_connect.php';
    $email=$_POST['loginEmail'];
    $pass=$_POST['loginPass'];

    $sql="Select * from `users` where user_email ='$email'";
    $result=mysqli_query($conn,$sql);
    $numRows=mysqli_num_rows($result);
    if($numRows==1){
    $row=mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['useremail']= $email;
            $_SESSION['sno']=$row['sno'];
            echo "loggedin".$email;
        }
        header("Location:/PHPFORUMPROJECT/index.php");
    }
    header("Location:/PHPFORUMPROJECT/index.php");
}
























    ?>