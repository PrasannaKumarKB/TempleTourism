<?php
session_start();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "temple";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signin"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM signup WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION["user_id"] = $row["id"];
            header("Location: home.html");
            exit();
        } else {
            $loginError = "Incorrect email or password. Please enter correct details.";
        }
    }

    }

    if (isset($_POST["signup"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];

        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            echo "<script>alert('Please fill in all the fields.');</script>";
        } elseif ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match.');</script>";
        } else {
            $sql = "INSERT INTO signup (name, email, password, confirmpassword) VALUES ('$name', '$email', '$password', '$confirmPassword')";

            if ($conn->query($sql) === true) {
                header("Location: home.html"); 
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="google-signin-client_id" content="338020825099-1ctovbhd8umjc1ismngm56m4gdnm6r0e.apps.googleusercontent.com">


    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-weight: bold;
        }

        .notification {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    background-color: red;
    color: white;
    text-align: center;
    display: none; 
}
*, *:before, *:after{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Nunito', sans-serif;
}

body{
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: -webkit-linear-gradient(left, #f4f4f5, #fcfafc);
  font-family: 'Nunito', sans-serif;
  background-image: url("gallery1.webp");
  background-repeat: no-repeat;
  background-size: cover;
}

input, button{
  border:none;
  outline: none;
  background: none;
}

.cont{
  overflow: hidden;
  position: relative;
  width: 900px;
  height: 550px;
  background: white;
  box-shadow: 0 19px 38px rgba(0, 0, 0, 0.30), 0 15px 12px rgba(0, 0, 0, 0.22);
}

.error-message {
  color: red;
  font-weight: bold;
}


.form{
  position: relative;
  width: 640px;
  height: 100%;
  padding: 50px 30px;
  -webkit-transition:-webkit-transform 1.2s ease-in-out;
  transition: -webkit-transform 1.2s ease-in-out;
  transition: transform 1.2s ease-in-out;
  transition: transform 1.2s ease-in-out, -webkit-transform 1.2s ease-in-out;
}

.form h6{
  text-align: center;
 
}

h2{
  width: 100%;
  font-size: 30px;
  text-align: center;
}

label{
  display: block;
  width: 260px;
  margin: 25px auto 0;
  text-align: center;
}

label span{
  font-size: 14px;
  font-weight: 600;
  color: #505f75;
  text-transform: uppercase;
}

input{
  display: block;
  width: 100%;
  margin-top: 5px;
  font-size: 16px;
  padding-bottom: 5px;
  border-bottom: 1px solid rgba(109, 93, 93, 0.4);
  text-align: center;
  font-family: 'Nunito', sans-serif;
}

button{
  display: block;
  margin: 0 auto;
  width: 26px;
  height: 36px;
  border-radius: 30px;
  color: #fff;
  background-color: aqua;
  font-size: 15px;
  cursor: pointer;
}

.submit {
    margin: 20px auto 30px;
    width: 150px;
    height: 30px;
    text-transform: uppercase;
    font-weight: 600;
    font-family: 'Nunito', sans-serif;
    background: -webkit-linear-gradient(left, #7579ff, #b224ef);
    display: block;
}

.submit:hover {
    background: -webkit-linear-gradient(left, #b224ef, #7579ff);
}


.forgot-pass{
  margin-top: 15px;
  text-align: center;
  font-size: 14px;
  font-weight: 600;
  color: #0c0101;
  cursor: pointer;
}

.forgot-pass:hover{
  color: red;
}

.social-media{
  width: 100%;
  text-align: center;
  margin-top: 20px;
}

.social-media ul{
  list-style: none;
}

.social-media ul li{
  display: inline-block;
  cursor: pointer;
  margin: 25px 15px;
}

.social-media img{
  width: 40px;
  height: 40px;
}

.sub-cont{
  overflow: hidden;
  position: absolute;
  left: 640px;
  top: 0;
  width: 900px;
  height: 100%;
  padding-left: 260px;
  background: #fff;
  -webkit-transition: -webkit-transform 1.2s ease-in-out;
  transition: -webkit-transform 1.2s ease-in-out;
  transition: transform 1.2s ease-in-out;
}

.cont.s-signup .sub-cont{
  -webkit-transform:translate3d(-640px, 0, 0);
          transform:translate3d(-640px, 0, 0);
}

.img{
  overflow: hidden;
  z-index: 2;
  position: absolute;
  left: 0;
  top: 0;
  width: 260px;
  height: 100%;
  padding-top: 360px;
}

.img:before{
  content: '';
  position: absolute;
  right: 0;
  top: 0;
  width: 900px;
  height: 100%;
  background-image: url("homebackground.webp");
  background-size: cover;
  transition: -webkit-transform 1.2s ease-in-out;
  transition: transform 1.2s ease-in-out, -webkit-transform 1.2s ease-in-out;
}

.img:after{
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.3);
}

.cont.s-signup .img:before{
  -webkit-transform:translate3d(640px, 0, 0);
          transform:translate3d(640px, 0, 0);
}

.img-text{
  z-index: 2;
  position: absolute;
  left: 0;
  top: 50px;
  width: 100%;
  padding: 0 20px;
  text-align: center;
  color: #fff;
  -webkit-transition:-webkit-transform 1.2s ease-in-out;
  transition: -webkit-transform 1.2s ease-in-out;
  transition: transform 1.2s ease-in-out, -webkit-transform 1.2s ease-in-out;
}

.img-text h2{
  margin-bottom: 10px;
  font-weight: normal;
}

.img-text p{
  font-size: 14px;
  line-height: 1.5;
}

.cont.s-signup .img-text.m-up{
  -webkit-transform:translateX(520px);
          transform:translateX(520px);
}

.img-text.m-in{
  -webkit-transform:translateX(-520px);
          transform:translateX(-520px);
}

.cont.s-signup .img-text.m-in{
  -webkit-transform:translateX(0);
          transform:translateX(0);
}


.sign-in{
  padding-top: 65px;
  -webkit-transition-timing-function:ease-out;
          transition-timing-function:ease-out;
}

.cont.s-signup .sign-in{
  -webkit-transition-timing-function:ease-in-out;
          transition-timing-function:ease-in-out;
  -webkit-transition-duration:1.2s;
          transition-duration:1.2s;
  -webkit-transform:translate3d(640px, 0, 0);
          transform:translate3d(640px, 0, 0);
}

.img-btn{
  overflow: hidden;
  z-index: 2;
  position: relative;
  width: 100px;
  height: 36px;
  margin: 0 auto;
  background: transparent;
  color: #fff;
  text-transform: uppercase;
  font-size: 15px;
  cursor: pointer;
}

.img-btn:after{
  content: '';
  z-index: 2;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  border: 2px solid #fff;
  border-radius: 30px;
}

.img-btn span{
  position: absolute;
  left: 0;
  top: 0;
  display: -webkit-box;
  display: flex;
  -webkit-box-pack:center;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  -webkit-transition:-webkit-transform 1.2s;
  transition: -webkit-transform 1.2s;
  transition: transform 1.2s;
  transition: transform 1.2s, -webkit-transform 1.2s;;
}

.img-btn span.m-in{
  -webkit-transform:translateY(-72px);
          transform:translateY(-72px);
}

.cont.s-signup .img-btn span.m-in{
  -webkit-transform:translateY(0);
          transform:translateY(0);
}

.cont.s-signup .img-btn span.m-up{
  -webkit-transform:translateY(72px);
          transform:translateY(72px);
}

.sign-up{
  margin-bottom: 50px;
  -webkit-transform:translate3d(-900px, 0, 0);
          transform:translate3d(-900px, 0, 0);
}

.cont.s-signup .sign-up{
  -webkit-transform:translate3d(0, 0, 0);
          transform:translate3d(0, 0, 0);
}
.google-sign-in {
    display: block;
    width: 30%;
    margin-left: 37%;
    color: #ffffff;
    padding: 10px;
    border: 5px;
    border-radius: 25px;
    cursor: pointer;
}



    </style>
</head>
<body>

<div class="notification" id="notification">
    <?php if (isset($loginError)) : ?>
        <?php echo $loginError; ?>
    <?php endif; ?>
</div>




<div class="cont">
    <div class="form sign-in">
        <h2>Sign In</h2>
        <form method="post" action="">
            <label>
                <span>Email</span>
                <input type="email" name="email">
            </label>
            <label>
                <span>Password</span>
                <input type="password" name="password">
            </label>
            <button type="submit" class="submit" name="signin" id="signinButton">Sign In Now</button>
            <p class="forgot-pass"><a href="forgot.html">Forgot Password?</a></p>
            <?php if (isset($loginError)) : ?>
    <p class="error-message"><?php echo $loginError; ?></p>
<?php endif; ?>

<div class="social-media">
    <ul>
      <h3>FOLLOW US ON</h3>
        <li><a href="https://www.facebook.com/tntourismoffcl/"><img src="facebook.png"></a></li>
        <li><a href="https://twitter.com/tntourismofcl"><img src="x.png"></a></li>
        <li><a href="https://www.linkedin.com/company/tamil-nadu-tourism/"><img src="linkedin.png"></a></li>
        <li><a href="https://www.instagram.com/tntourismoffcl/"><img src="instagram.png"></a></li>
        <li><a href="https://www.youtube.com/@TamilnaduTourismOnline"><img src="youtube.png"></a></li>
    </ul>
</div>

        </form>
    </div>

    <div class="sub-cont">
      <div class="img">
        <div class="img-text m-up">
          <h2>New here?</h2>
          <p>Sign up and discover great amount of new opportunities!</p>
        </div>
        <div class="img-text m-in">
          <h2>One of us?</h2>
          <p>If you already has an account, just sign in. We've missed you!</p>
        </div>
        <div class="img-btn">
          <span class="m-up">Sign Up</span>
          <span class="m-in">Sign In</span>
        </div>
      </div>
      <div class="form sign-up">
    <h2>Sign Up</h2>
    <form method="post" action="">
        <label>
            <span>Name</span>
            <input type="text" name="name">
        </label>
        <label>
            <span>Email</span>
            <input type="email" name="email">
        </label>
        <label>
            <span>Password</span>
            <input type="password" name="password">
        </label>
        <label>
            <span>Confirm Password</span>
            <input type="password" name="confirm_password">
        </label>
        <button type="submit" class="submit" name="signup" id="signupButton">Sign Up Now</button><h6>OR</h6>
       
       
        <div class="google-sign-in">
    <div class="g-signin2" data-onsuccess="onSignIn"></div>
</div>


    </form>
</div>


    </div>
  </div>
<script type="text/javascript" src="script.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const signupButton = document.getElementById("signupButton");

  if (signupButton) {
    signupButton.addEventListener("click", function() {
      window.location.href = "home.html";
    });
  }
});
document.querySelector('.img-btn').addEventListener('click', function()
    {
        document.querySelector('.cont').classList.toggle('s-signup')
    }
);
const postCommentBtn = document.getElementById("postCommentBtn");
const commentSection = document.querySelector(".comment-section");

postCommentBtn.addEventListener("click", function() {
    commentSection.style.display = commentSection.style.display === "block" ? "none" : "block";
});

document.addEventListener("DOMContentLoaded", function() {
    const notification = document.getElementById("notification");
    const signinButton = document.getElementById("signinButton");

    if (signinButton) {
        signinButton.addEventListener("click", function() {
       
            notification.style.display = "none";

            window.location.href = "home.html";
        });
    }
   
    document.addEventListener("DOMContentLoaded", function () {
        const signupButton = document.getElementById("signupButton");

        if (signupButton) {
            signupButton.addEventListener("click", function () {
                window.location.href = "home.html";
            });
        }

        document.querySelector('.img-btn').addEventListener('click', function () {
            document.querySelector('.cont').classList.toggle('s-signup');
        });

        document.addEventListener("DOMContentLoaded", function () {
            const notification = document.getElementById("notification");
            const signinButton = document.getElementById("signinButton");

            if (signinButton) {
                signinButton.addEventListener("click", function () {
                    notification.style.display = "none";
                    window.location.href = "home.html";
                });
            }
        });

        function onSignIn(googleUser) {
            // This function is called after a successful Google sign-in
            // You can handle the sign-in process here if needed
            const profile = googleUser.getBasicProfile();
            console.log('Google User:', profile);

            // Here, you can use AJAX to send the Google user data to your server
            // for further processing or registration.
        }

        function googleSignIn() {
            gapi.auth2.getAuthInstance().signIn().then(function (googleUser) {
                onSignIn(googleUser);
            }, function (error) {
                console.error('Google Sign-In Error:', error);
            });
        }
    });



   


   

    function isValidPassword(password) {
        const pattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return pattern.test(password);
    }
});

    
        document.addEventListener("DOMContentLoaded", function () {
            const signinButton = document.getElementById("signinButton");
            const signupButton = document.getElementById("signupButton");

            if (signinButton) {
                signinButton.addEventListener("click", function () {
                    validateSignIn();
                });
            }

            if (signupButton) {
                signupButton.addEventListener("click", function () {
                    validateSignUp();
                });
            }

            function validateSignIn() {
                const email = document.getElementsByName("email")[0].value;
                const password = document.getElementsByName("password")[0].value;
                const notification = document.getElementById("notification");

                if (!isValidEmail(email) || !isValidPassword(password)) {
                    notification.innerHTML = "Invalid email or password format.";
                    notification.style.display = "block";
                    return false;
                }

                return true;
            }

            function validateSignUp() {
                const name = document.getElementsByName("name")[0].value;
                const email = document.getElementsByName("email")[1].value;
                const password = document.getElementsByName("password")[1].value;
                const confirmPassword = document.getElementsByName("confirm_password")[0].value;
                const notification = document.getElementById("notification");

                if (
                    !name ||
                    !isValidEmail(email) ||
                    !isValidPassword(password) ||
                    password !== confirmPassword
                ) {
                    notification.innerHTML = "Please fill in all the fields correctly.";
                    notification.style.display = "block";
                    return false;
                }

                return true;
            }

            function isValidEmail(email) {
                const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return pattern.test(email);
            }

            function isValidPassword(password) {
                const pattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                return pattern.test(password);
            }
        });

        function onSignIn(googleUser) {
            // This function is called after a successful Google sign-in
            // You can handle the sign-in process here if needed
            const profile = googleUser.getBasicProfile();
            console.log('Google User:', profile);

            // Here, you can use AJAX to send the Google user data to your server
            // for further processing or registration.
        }

        function googleSignIn() {
            gapi.auth2.getAuthInstance().signIn().then(function (googleUser) {
                onSignIn(googleUser);
            }, function (error) {
                console.error('Google Sign-In Error:', error);
            });
        }
    
</script>
</body>