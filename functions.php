<?php

function login(PDO $connection)
{
  $date = new DateTime('now');
  $today = $date->format("Y-m-d H:i:s");
  $username = $_POST['login_username'];
  $password = $_POST['login_password'];
  $sql = $connection->prepare("SELECT * FROM `registertable` WHERE `username`= ?");
  $sql->bindParam(1, $username, PDO::PARAM_STR);
  try {
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $result = $sql->fetch();
    if ($result == false) {
      echo "<script type='text/javascript'>showError('Incorrect Username/Password')</script>";
    } else {
      if (password_verify($password, $result['password']) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        if ($result['expiry_date'] >= $today) {
          $_SESSION['login'] = "True";
          header('location: dashboard.php');
        } else {
          header('location: passwordreset.php');
        }
      } else {
        echo "<script type='text/javascript'>showError('Incorrect Username/Password')</script>";
      }
    }
  } catch (PDOException $e) {
    $message = $e->getMessage();
    $_POST['login_username'] = null;
    $_POST['login_password'] = null;
    echo "<script type='text/javascript'>showError('$message')</script>";
  }
}

function createAccount(PDO $connection)
{
  $username = $_POST['register_username'];
  $password = $_POST['register_password'];
  $email = $_POST['register_email'];
  $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
  $datetime = date_add(new DateTime('now'), date_interval_create_from_date_string("60 days"))->format('Y-m-d H:i:s');
  try {
    $sql = $connection->prepare("INSERT INTO `registertable` (`username`, `email`, `password`, `expiry_date`) VALUES (?, ?, ?, ?)");
    $sql->bindParam(1, $username, PDO::PARAM_STR);
    $sql->bindParam(2, $email, PDO::PARAM_STR);
    $sql->bindParam(3, $hashed_pwd, PDO::PARAM_STR);
    $sql->bindParam(4, $datetime, PDO::PARAM_STR);
    $sql->execute();
  } catch (PDOException $e) {
    $message = "Could not create account! Seems like your email address or username is already registered.";
    echo "<script type='text/javascript'>showError('$message')</script>";
  }
}
