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
  <link rel="stylesheet" href="css/custom/navBar.css">
  <link rel="stylesheet" href="css/custom/welcome.css">
  <link rel="stylesheet" href="css/custom/popup.css">
  <link rel="stylesheet" href="css/custom/simpleApp.css">
  <link rel="stylesheet" href="css/custom/comfortable.css">
  <link rel="stylesheet" href="css/custom/anywhere.css">
  <link rel="stylesheet" href="css/custom/motivated.css">
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
          <a class="navbar-brand"><img id="logo" src="/images/fitly.png"></a>
          <!-- Dropdown menu -->
          <ul class="nav navbar-nav list" >
            <li><a>News</a></li>
            <li><a>Blogs</a></li>
            <li><a>Location</a></li>
            <li><a>Activies</a></li>
            <li><a>About Us</a></li>
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

    <!--Welcome -->
    <div class ="welcome">
      <div class="container">
        <div class="row">
          <h1 class="background-text">Be Motivated. Be Anywhere. Be Comftorable.</h1>
          <h2 class="background-text2"> Be You. </h1>
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
    <!-- End of welcome -->

    <!-- Start of Simple App -->
    <div class="simpleApp">
      <div class="container">
        <div class="row">
          <!-- image -->
          <div class="app-image">
            <img src="/images/app.png">
          </div>
          <!-- End of image -->

          <!-- App text -->
          <div class="app-body">
            <h1 class="app-title">Simple App.</h1>
            <div class="app-paragraph">
              <p>Keeping it simple is key. Focus on your health and let us focus on everything else</p>
            </div>
          </div>
          <!-- End of App text -->
        </div>
      </div>
    </div>
    <!-- End of Simple App -->

    <!-- Start of Be Comfortable -->
    <div class="comfortable">
      <div class="container">
        <div class="row">
          <!-- Start of comftorable text -->
          <div class="comf-body">
            <h1 class="comf-title">Be comfortable.</h1>
            <div class="comf-paragraph">
              <p>Connected to trainers that will help you push yourself,
                but allow you to be comfortable in your surroundings.
                We know gyms can be intimidating for many different reasons,
                so let your workout space be a comfortable one</p>
            </div>
          </div>
          <!-- End of comfortable text -->

          <!-- Start of image -->
          <div class="comf-image">
            <img src="/images/app.png">
          </div>
          <!-- End of image -->
        </div>
      </div>
    </div>
    <!-- End of Be Comfortable -->

    <!-- Start of Be Anywhere -->
    <div class="anywhere">
      <div class="container">
        <div class="row">
          <!-- image -->
          <div class="anywhere-image">
            <img src="/images/app.png">
          </div>
          <!-- End of image -->

          <!-- Anywhere text -->
          <div class="anywhere-body">
            <h1 class="anywhere-title">Be Anywhere.</h1>
            <div class="anywhere-paragraph">
              <p>Why settle yourself in just one location? Workout inside or outside. Run on a track or by the lake...</p>
            </div>
          </div>
          <!-- End of Anywhere text -->
        </div>
      </div>
    </div>
    <!-- End of Be Anywhere -->

    <!-- Start of  Be Motivated-->
    <div class="motivated">
      <div class="container">
        <div class="row">
          <!-- Start of motivated text -->
          <div class="motiv-body">
            <h1 class="motiv-title">Be Motivated.</h1>
            <div class="motiv-paragraph">
              <p>Connected to trainers that will help you push yourself,
                but allow you to be comfortable in your surroundings.
                We know gyms can be intimidating for many different reasons,
                so let your workout space be a comfortable one</p>
            </div>
          </div>
          <!-- End of motivated text -->

          <!-- Start of image -->
          <div class="motiv-image">
            <img src="/images/app.png">
          </div>
          <!-- End of image -->
        </div>
      </div>
    </div>
    <!-- End of motivated -->

    <div class="footer">
      <div class="container">
        <div class="row">
          teddsklfjsadlkfjl;kasdjflsdkjfljdslfjadslkfjlaksjdflkasjdfldjs
        </div>
      </div>
    </div>
  </body>
</html>
