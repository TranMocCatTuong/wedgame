<?php
    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
      header("location: login.php");
      exit;
    }
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HOME</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
.button-86 {
  all: unset;
  width: 200px;
  height: 30px;
  font-size: 20px;
  background: transparent;
  border: none;
  position: relative;
  color: #f0f0f0;
  cursor: pointer;
  z-index: 1;
  padding: 10px 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-86::after,
.button-86::before {
  content: '';
  position: absolute;
  bottom: 0;
  right: 0;
  z-index: -99999;
  transition: all .4s;
}

.button-86::before {
  transform: translate(0%, 0%);
  width: 100%;
  height: 100%;
  background: #28282d;
  border-radius: 10px;
}

.button-86::after {
  transform: translate(10px, 10px);
  width: 35px;
  height: 35px;
  background: #ffffff15;
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(5px);
  border-radius: 50px;
}

.button-86:hover::before {
  transform: translate(5%, 20%);
  width: 110%;
  height: 110%;
}

.button-86:hover::after {
  border-radius: 10px;
  transform: translate(0, 0);
  width: 100%;
  height: 100%;
}

.button-86:active::after {
  transition: 0s;
  transform: translate(0, 5%);
}
.container{
  margin-top: 200px;
  width: 470px;
  height: 260px;
  border: 1px solid black;
  box-shadow: 0px 5px 34px 22px LightGray;
}
h1{
  font-size: 30px;
  color: white;
  text-shadow: 1px 1px 0 black,
    -1px 1px 0 black,
    1px -1px 0 black,
    -1px -1px 0 black,
    0px 1px 0 black,
    0px -1px 0 black,
    -1px 0px 0 black,
    1px 0px 0 black,
    2px 2px 0 black,
    -2px 2px 0 black,
    2px -2px 0 black,
    -2px -2px 0 black,
    0px 2px 0 black,
    0px -2px 0 black,
    -2px 0px 0 black,
    2px 0px 0 black,
    1px 2px 0 black,
    -1px 2px 0 black,
    1px -2px 0 black,
    -1px -2px 0 black,
    2px 1px 0 black,
    -2px 1px 0 black,
    2px -1px 0 black,
    -2px -1px 0 black;
}

  </style>
</head>
<body>
<center>
  <div class="container">
    <h1>Hi, <b><?php echo $_SESSION['username']; ?></h1>
    <br>
    <a href="../Wed_Game/index.html" class="button-86">Play Game</a>
    <br>
    <a href="logout.php" class="button-86">Log Out</a>
</div>
</center>
    </body>
    </html>