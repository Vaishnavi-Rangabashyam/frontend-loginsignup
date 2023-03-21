<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "loginregister");
$mysqli = new mysqli("localhost", "root", "", "loginregister");
if ($mysqli->connect_errno!=0){
  echo $mysqli->connect_error;
  exit();
}
// IF
if(isset($_POST["action"])){
  if($_POST["action"] == "register"){
    register();
  }
  else if($_POST["action"] == "login"){
    login();
  } 
  else if($_POST["action"] == "index"){
    index();
  }
}




// REGISTER
function register(){
  global $conn,$mysqli;
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  if(empty($username) || empty($email) ||empty($password) ){
    echo "Please Fill Out The Form!";
    exit;
  }
 
  $stmt = $mysqli->prepare("SELECT * FROM tbuser WHERE username =  ?");
  $stmt->bind_param("s",$username );
  $stmt->execute();
  // $result = $stmt->get_result();
  // $data = $result->fetch_assoc();
  $result = $stmt->get_result();
  if ($result->num_rows == 1){
    echo "Username Has Already Taken";
    exit;
  }

  // $confirmPassword = $_POST["confirmPassword"];

  

  // $user = mysqli_query($conn, "SELECT * FROM tbuser WHERE username = '$username'");
  // if(mysqli_num_rows($user) > 0){
  //   echo "Username Has Already Taken";
  //   exit;
  // }
  // elseif($password != $confirmPassword)
  // {
  //     echo "Please enter same password";
  // }
  
    $loginquery = $mysqli->prepare("INSERT INTO tbuser  ( username, email , password)  VALUES( ?, ?,?)");
    $loginquery->bind_param("sss" ,$username, $email , $password);
    $loginquery->execute();
    echo "Registration Successful";

    //MongoDB
    require 'vendor/autoload.php';

   //connect to mongodb

   $client = new MongoDB\Client;

   //select a database

    $db = $client -> mydb;

   //create a collection

   $collection = $db -> mycol;

   if($_POST)
   {
    $insert = array(
      'username' => $_POST['username'],
      'email' => $_POST['email'],
      'password' => $_POST['password'],
    );

    if($collection -> insertOne($insert))
    {
      echo "Registration data Inserted Successfully";
    }
    else {
      echo "Some Issue";
    }
  }
  
}


 






// LOGIN
function login(){
  global $mysqli;
  $stmt = $mysqli->prepare("SELECT * FROM tbuser WHERE email = ? OR username = ?");
  
  $email = $_POST["email"];
  $password = $_POST["password"];
  $stmt->bind_param("ss",$email,$email);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
  // echo $data['password'];
  
  // $rowcount=mysqli_num_rows($result);

if ($result->num_rows == 1){
  if($password == $data['password']){
    echo "Login Successful";
    $_SESSION["login"] = true;
    $_SESSION["id"] =  $data["id"];
  }
  else{
      echo "Login Failed!";
      exit;
  }
}elseif ($result->num_rows == 0){

  echo "User Not Registered";
}

}


// INDEX
function  index(){
 
  global $mysqli;
  $username = $_POST["username"];
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $birthday = date('Y-m-d',strtotime(  $_POST["birthday"]));
  $phone = $_POST["phone"];
  $country = $_POST["country"];
  $state = $_POST["state"];
  $gender = $_POST["gender"];

  if(empty($firstname) || empty($lastname) || empty($birthday) || empty($phone) ||empty($country) || empty($state) || empty($gender)){
    echo "Please fill the index form";
    exit;
  }
 try{
  $stmt = $mysqli->prepare("UPDATE tbuser SET
            firstname = ?,
            lastname  = ?,     
            birthday  = ?,
            phone     = ?,
            country   = ?,
            state     = ?,
            gender    = ?
            WHERE username = ?");
 $stmt->bind_param("sssissss", $firstname,$lastname,$birthday,$phone,$country,$state,$gender,$username);
 $stmt->execute();
  // $query = "UPDATE tbuser SET
  //         firstname = '$firstname',
  //         lastname  = '$lastname',     
  //         birthday  = '$birthday',
  //         phone     = '$phone',
  //         country   = '$country',
  //         state     = '$state',
  //         gender    = '$gender'
  //         WHERE username = '$username'" ;
  //   mysqli_query($conn, $query);
    echo "User data submitted Successfully";
 }
 catch(mysqli_sql_exception $e)
 {
 var_dump($e);
 exit;
 }

  //MongoDB
  require 'vendor/autoload.php';

  //connect to mongodb

  $client = new MongoDB\Client;

  //select a database

  $db = $client -> mydb;

  //create a collection

  $collection = $db -> mycol;

  if($_POST)
  {
   $insert = array(
      'firstname' => $_POST['firstname'],
      'lastname' => $_POST['lastname'],
      'birthday' => $_POST['birthday'],
      'phone' => $_POST['phone'],
      'country' => $_POST['country'],
      'state' => $_POST['state'],
      'gender' => $_POST['gender'],
   );

   if($collection -> insertOne($insert))
   {
     echo "Document Inserted Successfully";
   }
   else {
     echo "Some Issue";
   }
 }


  
  
}

?>


