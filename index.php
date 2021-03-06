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
        if($row){
          die("This email address is already registered");
        }

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
  <link rel="stylesheet" href="css/custom/navBar.css">
  <link rel="stylesheet" href="css/custom/popup.css">

  <link rel="stylesheet" href="css/custom/header.css">
  <link rel="stylesheet" href="css/custom/simpleApp.css">
  <link rel="stylesheet" href="css/custom/comfortable.css">
  <link rel="stylesheet" href="css/custom/anywhere.css">
  <link rel="stylesheet" href="css/custom/motivated.css">
  <link rel="stylesheet" href="css/custom/fitly.css">
  <link rel="stylesheet" href="css/custom/footer.css">

  <link rel="stylesheet" href="fonts/custom/fontFace.css">



  <!-- Custom Javascript -->
  <script src="js/custom/navAnimation.js"></script>
</head>
  <body>
    <!-- Navigation Bar -->
    <div class="row">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <a href="#"><img id="logo" src="/images/fitly.png"></a>
          <!-- Dropdown menu -->
          <nav>
            <a id="menu-icon"></a>
            <ul class="nav navbar-nav list" >
              <li><a>News</a></li>
              <li><a>Blogs</a></li>
              <li><a>Location</a></li>
              <li><a>Activies</a></li>
              <li><a>About Us</a></li>
              <li class="button"><button class="get" data-toggle="modal" data-target="#signUp">Get Started</button></li>
            </ul>
            <!-- End of dropdown menu -->
          </nav>
        </div>
      </nav>
    </div>
  </div>
  <!-- End of Navigation Bar -->

    <!-- Header -->
    <div class ="welcome">
      <div class="container">
        <div class="row">
          <h1 class="background-text">Train differently</h1>
          <h2 class="background-text2">  Train with fitly</h1>
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
    <!-- End of header -->

    <!-- Start of Simple App -->
    <div class="simpleApp">
      <div class="container">
        <div class="row">
          <!-- App text -->
          <div class="app-body">
            <h1 class="app-title">Simple App.</h1>
            <div class="app-paragraph">
              <p>Keeping it simple is key. Focus on your health and let us focus on everything else</p>
            </div>
          </div>
          <!-- End of App text -->
          <!-- image -->
          <div class="app-image">
            <img src="/images/oneplus.jpg">
          </div>
          <!-- End of image -->
        </div>
      </div>
    </div>
    <!-- End of Simple App -->

    <!-- Start of Be Comfortable -->
    <div class="comfortable">
      <div class="container">
        <div class="comf-image"></div>
        <div class="row">
          <div class="comf-body">
            <!-- Start of comftorable text -->
            <h1 class="comf-title">Redefining 'personal'</h1>
            <div class="comf-paragraph">
              <p>The days of searching endlessly for the best trainers in your area are over. With Fitly, you can find the trainer you’re looking for in just about any field of fitness, so no matter what you’re interested in, there’s a trainer just around the corner. </p>
            </div>
          </div>
          <!-- End of comfortable text -->
        </div>
      </div>
    </div>
    <!-- End of Be Comfortable -->

    <!-- Start of Be Anywhere -->
    <div class="anywhere">
      <div class="container">
        <div class="row">
          <!-- Anywhere text -->
          <div class="anywhere-body">
            <h1 class="anywhere-title">Why settle with one location?</h1>
            <div class="anywhere-paragraph">
              <p>
                You decide where you want to meet your trainer - your home, the park, etc. Wherever you’re comfortable, your trainer will come to you!</p>
            </div>
          </div>
          <!-- End of Anywhere text -->

          <!-- image -->
          <div class="anywhere-image">
            <img src="/images/app.png">
          </div>
          <!-- End of image -->
        </div>
      </div>
    </div>
    <!-- End of Be Anywhere -->

    <!-- Start of  Be Motivated-->
    <div class="motivated">
      <div class="container">
        <div class="motiv-image"></div>
        <div class="row">
          <!-- Start of motivated text -->
          <div class="motiv-body">
            <h1 class="motiv-title">Be Motivated.</h1>
            <div class="motiv-paragraph">
              <p>With fitly, you’ll be connected to trainers that will help you push yourself, but allow you to be comfortable in your surroundings. We know gyms can be intimidating for many different reasons, so let your workout space be a comfortable one. </p>
            </div>
          </div>
          <!-- End of motivated text -->
        </div>
      </div>
    </div>
    <!-- End of motivated -->

    <!-- Start of Be Fitly -->
    <div class="fitly">
      <div class="container">
        <div class="row">
          <!-- fitly text -->
          <div class="fitly-body">
            <h1 class="fitly-title">Be Fitly.</h1>
            <div class="fitly-paragraph">
              <p>It's pretty straightfoward, be yourself.
                Workout when you want, where you want and with who yoo want.
                Dont limit yourself to one gym, to one trainer, or to one time.
                Change the way fitness is done. Make it personal </p>
            </div>
          </div>
          <!-- End of Anywhere text -->
          
          <!-- image -->
          <div class="fitly-image">
            <img src="/images/app.png">
          </div>
          <!-- End of image -->
        </div>
      </div>
    </div>
    <!-- End of Be Anywhere -->

    <div class="footer">
      <div class="container">
        <div class="row">
          teddsklfjsadlkfjl;kasdjflsdkjfljdslfjadslkfjlaksjdflkasjdfldjs
        </div>
      </div>
    </div>
  </body>
</html>
