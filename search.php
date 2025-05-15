<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forum</title>
    <style>
      .container{
        min-height: 100vh;
      }
    </style>
  </head>
  <body>
  <?php include "partials/_header.php"; ?>
  <?php include "partials/_dbconnect.php"; ?>
      <div class="container my-3 mb-5">
          <h2>Search Results for "<em><?php echo $_GET['search']; ?></em>"</h2>
          <div class="result">
          <?php
          $noresults = true;
          $query = $_GET['search'];
          $sql = "SELECT * FROM `threads` WHERE MATCH(`thread_title`, `thread_description`) AGAINST('$query')";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $description = $row['thread_description'];
            $id = $row['thread_id'];
            $url = "thread.php?threadid=" . $row['thread_id'];
            $noresults = false;

            echo '<a href="' . $url . '" class="text-dark"><h3>'. $title . '</h3></a>
            <p>' . $description . '</p>';
          }
          if($noresults == true){
            echo '<div class="jumbotron bg-light p-4 m-4 rounded">
            <h1 class="display-4">No Results Found</h1>
            <p class="lead">Make sure you have enter the correct keyword</p>.
        </div>';
          }
          ?>
            
          </div>
      </div>
  <?php include "partials/_footer.php"; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>