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


<body>

    <?php
     include 'partials/db_connect.php';
    include 'partials/_header.php';
   

    ?>
    <!-- Slider starts here -->
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider-1.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-2.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-3.jpeg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<!-- Category conatiner contains here -->
    <div class="container my-4 ">
        <h2 class="text-center my-4">iForums- Browse Categories</h2>

      
        <div class="row my-4">
          <!-- Fetch all the categories here -->
           <!--use the for loops to iterate through the catgories  -->
          <?php
          $sql= "SELECT * FROM `categories`";
          $result=mysqli_query($conn,$sql);
          while($row=mysqli_fetch_assoc($result)){
            // echo $row['category_id'];
            // echo $row['category_name'];
            // we will put the cards code here
            $id=$row['category_id'];
            $cat=$row['category_name'];
            $desc=$row['category_description'];
            echo '<div class="col-md-4 my-2">
            <div class="card" style="width: 18rem;">
                 <img src="img/card-'.$id.'.jpeg" class="card-img-top" alt="image for this category">
                <div class="card-body">
                    <h5 class="card-title"><a href="threadlist.php?catid='.$id.'">'.$cat. '</a></h5>
                    <p class="card-title">'.substr($desc,0,90). '...</p>
                    <a href="threadlist.php?catid='.$id .'" class="btn btn-primary">View Threads</a>
                </div>
            </div>
        </div>';
          }
          ?>
          </div>
        </div>
          

<?php
    include 'partials/_footer.php';
?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>