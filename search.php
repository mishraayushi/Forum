<?php
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iForum -Lets code here..</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    #maincontainer{
        min-height:86vh;
    }
</style>


<body>

    <?php
     include 'partials/db_connect.php';
    include 'partials/_header.php';
   

    ?>
 <!-- Search results here -->
    <div class="container my-3" id="maincontainer">
        <h1>Search results for <em>"<?php echo $_GET['search']?>"</em></h1>
        <?php
        $noresults=true;
        $query=$_GET["search"];
        $sql="SELECT * from threads where match (thread_title,thread_desc) against ('$query')";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_id=$row['thread_id'];
            $url="thread.php?threadid=".$thread_id;
            $noresults=false;
            // display the search results for
            echo ' <div class="result">
            <h3 class="py-3"><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
            <p>'.$desc.'</p>
            </div>';
        }
        if($noresults){
            // Copy the code of jumpotron
           echo '
        <div class="jumbotron jumbotron-fluid">
            <div class="container ">
              <p class="display-5">No Results found</p>
              <p class="lead">Suggestions.<ul>
              <li>Make sure that all words are spelled correctly.</li>
              <li>Try different keywords..</li>
              <li>Try more general keywords..</li>
              </ul>
              
              </p>
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