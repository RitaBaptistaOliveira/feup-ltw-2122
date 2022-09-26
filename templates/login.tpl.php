<?php 
declare(strict_types = 1); 
require_once('utils/session.php');

function drawLoginForm($session) { ?>

<section>
   <h2> Log In </h2>
   <form action="../includes/login.inc.php" method="post">
      <p>Username: <input type="text" name="username"></p>
      <p>Password: <input type="password" name="password"></p>
      <p><button type="submit" name="submit">Log In</button></p>
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
   </form>         
</section>

<?php } ?>


<?php
if(isset($_GET["error"])){
  if($_GET["error"] == "emptyinput"){
     echo "<p>Fill in all fields!</p>" ;    
  }
  else if($_GET["error"] == "invalidusername"){
     echo "<p>Write a proper username!</p>" ;    
  }
  else if($_GET["error"] == "nonexistentusername"){
     echo "<p>That username does not exist!</p>" ;    
  }
  else if($_GET["error"] == "wrongpassword"){ 
     echo "<p>The password doesn't match the username!</p>" ;    
  }
  else if($_GET["error"] == "none"){
     echo "<p>You are logged in!</p>";    
  }
}
?>
