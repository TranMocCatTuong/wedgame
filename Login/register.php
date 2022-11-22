<?php
    require_once 'config.php';

    $username = $password = $confirm_password = "";

    $username_err = $password_err = $confirm_password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){


        if(empty(trim($_POST["username"]))){

            $username_err = "Please enter a username.";

        } else{

            $sql = "SELECT id FROM users WHERE username = :username";

            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
                $param_username = trim($_POST["username"]);
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $username_err = "This username is already taken.";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            unset($stmt);
        }

        if(empty(trim($_POST['password']))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST['password'])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST['password']);
        }

        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = 'Please confirm password.';     
        } else{
            $confirm_password = trim($_POST['confirm_password']);
            if($password != $confirm_password){
                $confirm_password_err = 'Password did not match.';
            }
        }

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

            if($stmt = $pdo->prepare($sql)){

                $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);

                $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);


                $param_username = $username;

                $param_password = password_hash($password, PASSWORD_DEFAULT);

                if($stmt->execute()){
                    header("location: index.php");
                } else{
                    echo "Something went wrong. Please try again later.";
                }
            }
            unset($stmt);
        }
        unset($pdo);
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>REGISTER</title>
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
    height: 390px;
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
        color: #2d2f36;
    }
    #click-link:hover{
        color: #d0d0d2;
    }
    #gr{
        
        display: flex;
    }
  </style>
</head>
    <body>
        <div class="page">
            <div class="container">
                <div class="left">
                    <div class="login">Sign Up</div>
                    <div class="eula">
                        Please fill this form to create an account.
                        <p>Already have an account? <a id="click-link" href="index.php">Login here</a>.</p>
                    </div>
                    
                    <p class="eula2"><?php echo $username_err; ?></p>
                    <p class="eula2"><?php echo $password_err; ?></p>
                    <p class="eula2"><?php echo $confirm_password_err; ?></p>
                </div>
                <div class="right">
                <div class="form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username:</label>
                            <input type="text" name="username"class="u-full-width" value="<?php echo $username; ?>">
                            
                        </div>    
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password:</label>
                            <input type="password" name="password" class="u-full-width" value="<?php echo $password; ?>">
                            
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password:</label>
                            <input type="password" name="confirm_password" class="u-full-width" value="<?php echo $confirm_password; ?>">
                            
                        </div>
                        <div class="form-group" id="gr">
                            <input type="submit" id="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" id="submit" class="btn btn-default" value="Reset">
                        </div>
                        
                    </form>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>