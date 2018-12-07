<?php
  require_once('queryClasses/query.php');
  $query = new Query();

  $postData = file_get_contents("php://input");
  $request = json_decode($postData);

  //validate the user by sending them an Email
  function randStrGen($len){
      $result = "";
      $chars = "abcdefghijklmnopqrstuvwxyz0123456789$11";
      $charArray = str_split($chars);
      for($i = 0; $i < $len; $i++){
  	    $randItem = array_rand($charArray);
  	    $result .= "".$charArray[$randItem];
      }
      return $result;
  }

  function sanitize_my_email($field) {
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
  }

  function emailContent($urlBase, $randString) {
    $link = $urlBase . "" . $randString;
    $content = "Thank you for registering with us at Imagine Fiction! </br> Please click the link below to verify your email.</br><a href='$link'>$link</a>";
    return $content;
  }

  $user_email_key = randStrGen(20);

  $to_email = $request->email;
  $subject = 'Imagine Fiction Email Verification';
  $message = emailContent("http://localhost/Imagine-Fiction-Angular-PHP-project/verifyUser.html?verify=", $user_email_key);
  $headers = 'From: noreply@imaginefiction.com';
  //check if the email address is invalid $secure_check
  $secure_check = sanitize_my_email($to_email);
  if ($secure_check == false) {
      echo "Invalid input";
  } else { //send email
      echo "this is the message: " . $message;
      mail($to_email, $subject, $message, $headers);
      echo "This email has been sent.";
  }



  echo $query->submitUserRegistration($request->email, $request->user, $request->password, $user_email_key);
?>
