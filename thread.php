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
  $id = $_GET['threadid'];
//   echo $id;
  $sql = "SELECT * FROM `threads` WHERE `thread_id` = '$id'";
  $result = mysqli_query($conn, $sql);
  if(!$result){
      echo "Record not selected successfully" . mysqli_error($conn) . "<br>";
  }
  while($row = mysqli_fetch_assoc($result)){
    $title = $row['thread_title'];
    $description = $row['thread_description'];

    $thread_user_id = $row['thread_user_id'];

    // Query the users table to find out the name of the OP
    $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$thread_user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $posted_by = $row2['user_email'];
  }
  ?>
  <?php
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "POST"){
      $comment = $_POST['comment'];
    $comment = str_replace("<", "&lt;", $comment);
    $comment = str_replace(">", "&gt;", $comment);
      $sno = $_POST['sno'];
      
      $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
      $result = mysqli_query($conn, $sql);
      if(!$result){
        echo "Record was not Inserted successfully" . mysqli_error($conn) . "<br>";
      }

    }
  ?>
  <div class="container">
        <div class="jumbotron bg-light p-4 m-4 rounded">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $description; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer Forum, Do not litter or say bad word around to any user in this forum, using offensive tone or speech is not alowed in this forum, and being quiet is also not allowed in this forum.
            </p>
            <p><strong>Posted By: <?php echo $posted_by; ?> </strong></p>
        </div>
  </div>
  
 <?php


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
 echo '<div class="container my-4">
    <h1 class="py-4">Post a Comment</h1>
  <form action="' . $_SERVER["REQUEST_URI"] . '" method="POST">
  <div class="form-group">
    <label for="comment">Comment</label>
    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
    <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
  </div>
  <button type="submit" class="btn btn-success">Post a Comment</button>
</form>  
</div>';
}
else{
  echo '<div class="container">
  <h1 class="py-4">Post a Comment</h1>
  <p class="lead">You are not logged in, please login to continue to post a comment</p>
  </div>';
}
?>

  
    <div class="container my-4" id="ques">
        <h1 class="py-4">Discussions</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM  `comments` WHERE `thread_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $noResult = true;

        while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['comment_id'];
        $content = $row['comment_content'];
        $comment_time = $row['comment_time'];
        $comment_by = $row['comment_by'];

        $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$comment_by'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
        echo '<div class="media d-flex my-2">
            <img src="img/user-default.jpg" width="34px" height="34px" class="me-3" alt="...">
            <div class="media-body">
                <p class="fw-bold my-0">' . $row2['user_email'] . ' at ' . $comment_time . '</p>
                <p>' . $content . '</p>
            </div>
        </div>';

    }
    if($noResult == true){
        echo '<div class="jumbotron jumbotron-fluid bg-light p-4 m-4 rounded">
        <div class="container">
          <h1 class="display-4">No Comment Found</h1>
          <p class="lead">Be the first one to comment on this question</p>
        </div>
      </div>';
    }
    ?>

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