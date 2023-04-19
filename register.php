<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if($_SERVER['REQUEST_METHOD'] == "POST")
{

  //cheak if username is empty
  if(empty(trim($_POST["username"])))
  {
  $username_err = "Username cannot be blank";
  }
  else
  {
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt){

      mysqli_stmt_bind_param($stmt, "s" , $param_username);
      
      // set the value of param username
      $param_username = trim($_POST['username']);
    
      // try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);
       if(mysqli_stmt_num_rows($stmt) == 1){

        $username_err = "this username is already taken";
       }
       else
       {
        $username = trim($_POST['username']);
       }
       }
       else
       {
         echo "something went wrong";
       }
    }
  }
  
  mysqli_stmt_close($stmt);


 // try to  cheak for password
 if(empty(trim($_POST['password']))){
  
  $password_err = "Password cannot be blank";

 } 
 else if(strlen(trim($_POST['password'])) < 5)
 {
  $password_err = "Password cannot be less than 5 charecters";
 }
 else 
 {
  $password = ($_POST['password']);
 }

 // try to  cheak for confirm_password
 if(trim($_POST['password']) != trim($_POST['confirm_password']) )
 {
  $confirm_password_err = "Password should match";
 }


 // if there is no errors go ahead and insert into the databases

 if(empty($username_err) && empty($password_err) &&  empty($confirm_password_err))
{
  $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
 if($stmt){
  mysqli_stmt_bind_param($stmt, "ss" , $param_username, $param_password);

  // set these parameter
  $param_username = $username;
  $param_password = password_hash($password, PASSWORD_DEFAULT); 

  // try to execute query
  if(mysqli_stmt_execute($stmt)){

    header("location: login.php");
  }
  else
  {
    echo "something went wrong! -- redirect";
  }
 }
  mysqli_stmt_close($stmt);
 }
 mysqli_close($conn);
}
?>









<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  
  <body style="margin:30px">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PHP login</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled"></a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <form class="row g-3 mt-3" action="" method="post">
  <h1>Register Here</h1>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">username</label>
    <input type="text" class="form-control" name="username" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="inputPassword4">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">confirm_password</label>
    <input type="password" class="form-control" id="inputAddress" name="confirm_password" placeholder="confirm_password">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>