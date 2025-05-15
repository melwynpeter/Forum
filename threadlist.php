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
      #ques{
        min-height: 344px;
      }
    </style>
  </head>
  <body>
  <?php include "partials/_header.php"; ?>
  <?php include "partials/_dbconnect.php"; ?>
    

  <?php
  $id = $_GET['catid'];
//   echo $id;
  $sql = "SELECT * FROM `categories` WHERE `category_id` = '$id'";
  $result = mysqli_query($conn, $sql);
  if(!$result){
      echo "Record not selected successfully" . mysqli_error($conn) . "<br>";
  }
  while($row = mysqli_fetch_assoc($result)){
      $catname = $row['category_name'];
      $catdescription = $row['category_description'];
  }
  ?>
  <?php
  $method = $_SERVER['REQUEST_METHOD'];
  echo $method;
  if($method == 'POST'){
    // Inserting a thread into the database
    $th_title = $_POST['title'];
    $th_description = $_POST['description'];

    $th_title = str_replace("<", "&lt;", $th_title);
    $th_title = str_replace(">", "&gt;", $th_title);

    $th_description = str_replace("<", "&lt;", $th_description);
    $th_description = str_replace(">", "&gt;", $th_description);

    $sno = $_POST['sno'];

    $sql = "INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_description', '$id', '$sno', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    // if(!$result){
    //   echo "Record not inserted successfully" . mysqli_error($conn) . "<br>";
    // }
  }
  ?>
  <div class="container">
        <div class="jumbotron bg-light p-4 m-4 rounded">
            <h1 class="display-4">This is <?php echo $catname; ?> Thread List</h1>
            <p class="lead"><?php echo $catdescription; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer Forum, Do not litter or say bad word around to any user in this forum, using offensive tone or speech is not alowed in this forum, and being quiet is also not allowed in this forum.
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
  </div>  

  <?php 

  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
  echo '<div class="container my-4">
    <h1 class="py-4">Start a Discussion</h1>
  <form action="' . $_SERVER["REQUEST_URI"] . '" method="POST">
  <div class="form-group">
    <label for="title">Problem Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as possible.</small>
  </div>
  <input type="hidden" name="sno" value="'. $_SESSION['sno'] . '">
  <div class="form-group">
    <label for="description">Elaborate your Concerns</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-success">Submit</button>
</form>
  </div>';
  }
  else{
    echo '<div class="container">
          <h1 class="py-4">Start a Discussion</h1>
          <p class="lead">You are not logged in, please login to start a discussion</p>
          </div>';
  }
  ?>
    <div class="container my-4" id="ques">
        <h1 class="py-4">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM  `threads` WHERE `thread_cat_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $noResult = true;

        while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $description = $row['thread_description'];
        $thread_user_id = $row['thread_user_id'];

        $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
        echo '<div class="media d-flex">
            <img src="img/user-default.jpg" width="34px" height="34px" class="me-3" alt="...">
            <div class="media-body">
              
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                <p>' . $description . '</p>
                </div>
                <div class="fw-bold my-0 align-items-end">Asked By: ' . $row2['user_email'] . ' at ' . $row['timestamp'] . '</div>
        </div>';
    }

    if($noResult == true){
      echo '<div class="jumbotron jumbotron-fluid bg-light p-4 m-4 rounded">
      <div class="container">
        <p class="display-4">No Threads Found</p>
        <p class="lead">Be the First one to ask a Question</p>
      </div>
    </div>';
    }
    ?>
        <!-- <div class="media">
            <img src="img/user-default.jpg" width="34px" class="me-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">Unable to install Pyaudio error in Windows</h5>
                <p>Will you do the same for me? It's time to face the music I'm no longer your muse. Heard it's beautiful, be the judge and my girls gonna take a vote. I can feel a phoenix inside of me. Heaven is jealous of our love, angels are crying from up above. Yeah, you take me to utopia.</p>
            </div>
        </div> -->

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