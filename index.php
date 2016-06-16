<?php
    require("php/config.php");

    if(!empty($_POST))
    {
        // Ensure that the user fills out fields
        if(empty($_POST['firstName']))
        { die("Please enter your first name."); }
        if(empty($_POST['lastName']))
        { die("Please enter yout last name"); }
        if(empty($_POST['password']))
        { die("Please enter a password."); }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        { die("Invalid E-Mail Address"); }

        $query = "
            SELECT
                1
            FROM users
            WHERE
                email = :email
        ";
        $query_params = array(
            ':email' => $_POST['email']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());}
        $row = $stmt->fetch();
        if($row){ die("This email address is already registered"); }

        // Add row to database
        $query = "
            INSERT INTO users (
                firstName,
                lastName,
                password,
                salt,
                email
            ) VALUES (
                :firstName,
                :lastName,
                :password,
                :salt,
                :email
            )
        ";

        // Security measures
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); }
        $query_params = array(
            ':firstName' => $_POST['firstName'],
            ':lastName' => $_POST['lastName'],
            ':password' => $password,
            ':salt' => $salt,
            ':email' => $_POST['email']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        header("Location: index.php");
        die("Redirecting to index.php");
    }
?>

<!-------------------------- html -------------------------------------->

<!DOCTYPE html>
<html>
<head>
  <title>Fitly | welcome</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Jquery -->
  <script src="js/jquery/jquery-1.12.4.min.js"></script>
  <script src="js/jquery/color.min.js"></script>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
  <script src="js/bootstrap/bootstrap.min.js"></script>

  <!-- AnjularJs -->
  <script src="js/angular/angular.min.js"></script>

  <!-- Custom css -->
  <link rel="stylesheet" href="css/custom/general.css">
  <link rel="stylesheet" href="css/custom/popup.css">
  <link rel="stylesheet" href="css/custom/navBar.css">
  <link rel="stylesheet" href="css/custom/chapter1.css">
  <link rel="stylesheet" href="css/custom/chapter2.css">
  <link rel="stylesheet" href="css/custom/chapter3.css">
  <link rel="stylesheet" href="fonts/custom/fontFace.css">

  <!-- Custom Javascript -->
  <script src="js/custom/navAnimation.js"></script>

</head>
  <body>
    <!-- Navigation Bar -->
    <div class="row">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand"><img id="logo" src="/images/fitly.png"></a>
          <!-- Dropdown menu -->
          <ul class="nav navbar-nav" >
            <li class="dropdown">
              <a href="#" class="dropdown-toggle explore" data-toggle="dropdown">Explore<span class="caret"></span></a>
              <ul class="dropdown-menu list-inline" role="menu">
                <li><a href="#">News</a></li>
                <li><a href="#">Blogs</a></li>
                <li><a href="#">Activites</a></li>
                <li><a href="#">Location</a></li>
                <li><a href="#">About Us</a></li>
              </ul>
            </li>
          </ul>
          <!-- End of dropdown menu -->
          <ul class="nav navbar-nav navbar-right" >
            <li class="dropdown">
              <button class="get" data-toggle="modal" data-target="#signUp">Get Started</button>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <!-- End of Navigation Bar -->

    <!--Chapter 1 -->
    <div class = "chapter1">
      <div class= "container">
        <div class="row">
          <h1 class = "background-text">FITNESS CENTERED AROUND YOU</h1>
        </div>
        <div class="row">
          <button class="getStarted" data-toggle="modal" data-target="#signUp">
            Get Active
          </button>
        </div>

        <!-- Popup Sing up -->
        <div id="signUp" class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" >
          <div clas="modal-dialog">
            <div class="modal-content popup-body">
              <div class="modal-header popup-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Sign Up</h4>
              </div>
              <div class="modal-body register-body">
                <form action="index.php" method="post">
                <div class="row">
                  <input name="firstName" type="text" class="form-control" id="inputFirstName" placeholder="First Name" required>
                  <input name="lastName" type="text" class="form-control" id="inputLastName" placeholder="Last Name" required>
                </div>
                <div class="row">
                  <input name="email" type="email" class="form-control" id="inputEmail" placeholder="youremail@email.com" required>
                </div>
                <div class="row">
                  <input name="password" type="password" class="form-control" id="inputPassword" placeholder="password" required>
                </div>
                <div class="row">
                  <input type="password" class="form-control" id="retypePassword" placeholder="Retype password" required>
                </div>
                <div class="row">
                  <input name="trainer" type="checkbox"/> Sign up as trainer
                </div>
                <div class="modal-footer popup-footer">
                  <input type="submit" class="btn btn-default submit" value="Register">
               </div>
              </div>
            </div>
          </div>
        </div>
        <!--End of Popup Signup-->
      </div>
    </div>
    <!-- End of chapter 1 -->

    <!-- Start of chapter 2 -->
    <div class="chapter2">
      <div class="container">
        <!-- Title -->
        <div class="row">
          <div class="window">
            <<h1 class="title">For You</h1>
          </div>
        </div>
        <!-- End of title -->

        <!-- paragraph1 -->
        <div class="row">
          <div class="image">
            <img src="C:\Users\Juan\Documents\FitU\DesignPh\trainers.jpg">
          </div>
          <div class="paragraph">
            <p>Let's be honest. Price of a personal trainer is expensive,
              finding a location is difficult, and schedulding is a nightmare!</p>
          </div>
        </div>
        <!-- End of paragraph1 -->
      </div>
    </div>
    <!-- End of chapter2 -->
  </body>
</html>
