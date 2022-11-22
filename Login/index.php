<?php

    require_once 'config.php';

    $username = $password = "";

    $username_err = $password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = 'Please enter username.';
        } else{
            $username = trim($_POST["username"]);
        }
        if(empty(trim($_POST['password']))){
            $password_err = 'Please enter your password.';
        } else{
            $password = trim($_POST['password']);
        }
        if(empty($username_err) && empty($password_err)){

            $sql = "SELECT username, password FROM users WHERE username = :username";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
                $param_username = trim($_POST["username"]);
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        if($row = $stmt->fetch()){
                            $hashed_password = $row['password'];
                            if(password_verify($password, $hashed_password)){
                                session_start();
                                $_SESSION['username'] = $username;      
                                header("location: welcome.php");
                            } else{
                                $password_err = 'The password you entered was not valid.';
                            }
                        }
                    } else{
                        $username_err = 'No account found with that username.';
                    }
                } else{

                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            unset($stmt);
        }
        // Close connection
        unset($pdo);
    }
    ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>LOGIN</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @import url("https://rsms.me/inter/inter-ui.css");
    ::selection {
    background: #2d2f36;
    }
    ::-webkit-selection {
    background: #2d2f36;
    }
    ::-moz-selection {
    background: #2d2f36;
    }
    body {
    background: white;
    font-family: "Inter UI", sans-serif;
    margin: 0;
    padding: 20px;
    }
    .page {
    background: #e2e2e5;
    display: flex;
    flex-direction: column;
    height: calc(100% - 40px);
    position: absolute;
    place-content: center;
    width: calc(100% - 40px);
    }
    @media (max-width: 767px) {
    .page {
        height: auto;
        margin-bottom: 20px;
        padding-bottom: 20px;
    }
    }
    .container {
    display: flex;
    height: 320px;
    margin: 0 auto;
    width: 640px;
    }
    @media (max-width: 767px) {
    .container {
        flex-direction: column;
        height: 630px;
        width: 320px;
    }
    }
    .left {
    background: white;
    height: calc(100% - 40px);
    top: 20px;
    position: relative;
    width: 50%;
    }
    @media (max-width: 767px) {
    .left {
        height: 100%;
        left: 20px;
        width: calc(100% - 40px);
        max-height: 270px;
    }
    }
    .login {
    font-size: 50px;
    font-weight: 900;
    margin: 50px 40px 40px;
    }
    .eula2 {
    color: red;
    font-size: 14px;
    line-height: 1.5;
    margin: 20px 30px;
    }
    .eula {
    color: #999;
    font-size: 14px;
    line-height: 1.5;
    margin: 40px 30px 20px 30px;
    }
    .right {
    background: #474a59;
    box-shadow: 0px 0px 40px 16px rgba(0, 0, 0, 0.22);
    color: #f1f1f2;
    position: relative;
    width: 50%;
    }
    @media (max-width: 767px) {
    .right {
        flex-shrink: 0;
        height: 100%;
        width: 100%;
        max-height: 350px;
    }
    }
    .form {
    margin: 40px;
    position: absolute;
    }
    label {
    color: #c2c2c5;
    display: block;
    height: 16px;
    margin-top: 20px;
    margin-bottom: 5px;
    }
    input {
    background: transparent;
    border: 0;
    color: #f2f2f2;
    font-size: 20px;
    height: 30px;
    line-height: 30px;
    outline: none !important;
    width: 100%;
    }
    input::-moz-focus-inner {
    border: 0;
    }
    #submit {
    color: #707075;
    margin-top: 20px;
    margin-bottom: 20px;
    transition: color 300ms;
    }
    #submit:focus {
    color: #f2f2f2;
    }
    #submit:hover {
    color: #d0d0d2;
    }
    #link {
    font-size: 12px;
    }
    #click-link{
        color: #f2f2f2;
    }
    #click-link:hover{
        color: #d0d0d2;
    }
  </style>
</head>
<body>
    <div class="page">
        <div class="container">
            <div class="left">
                <div class="login">Login</div>
                <div class="eula">Please fill in your credentials to login.</div>
                <p class="eula2"><?php echo $username_err; ?></p>
                <p class="eula2"><?php echo $password_err; ?></p>
            </div>
            <div class="right">
                <div class="form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label for="username">Username<br></label>
                            <input id ="username" type="text" name="username"class="u-full-width" value="<?php echo $username; ?>">           
                        </div>    
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="password">Password<br></label>
                            <input id ="password" type="password" name="password" class="u-full-width">                           
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="submit" value="Submit">
                        </div>
                        <p id ="link">Don't have an account? <a id="click-link" href="register.php">Sign up here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 