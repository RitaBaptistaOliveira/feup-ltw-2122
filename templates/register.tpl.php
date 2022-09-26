<?php 
declare(strict_types = 1); 
require_once('utils/session.php');

function drawRegisterForm() { ?>

    <section>
    <h2> Register </h2>
        <form action="../includes/register.inc.php" method = "post" enctype="multipart/form-data">
            Username: <input type="text" name="username">
            <p>Your Name: <input type="text" name="screenName"></p>
            <p>Password: <input type="password" name="password"></p>
            <p>Confirm Password: <input type="password" name="passwordRepeat"></p>
            <p>Phone Number: <input type="text" name="phonenumber"></p>
            <p>Address: <input type="text" name="address"></p>
            <p><input type="radio" name="userType" value="customer"><label for = "customer">Customer</label>  
            <input type="radio" name="userType" value="restaurantOwner"><label for = "restaurantOwner">Restaurant Owner</label></p>
            <p><label for="image">Photo: </label>
            <input id="image" type="file" name="image" required></p>
            <button type = "submit" name = "submit">Register</button>
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
     echo "<p>Pick a proper username!</p>" ;    
  }
  else if($_GET["error"] == "takenusername"){
     echo "<p>That username is already taken!</p>" ;    
  }
  else if($_GET["error"] == "invalidphonenumber"){ 
     echo "<p>Pick a proper phone number!</p>" ;    
  }
  else if($_GET["error"] == "takenphonenumber"){
   echo "<p>That phone number is already taken!</p>" ;    
}
  else if($_GET["error"] == "needimage"){ 
   echo "<p>Pick a photo!</p>" ;    
}
else if($_GET["error"] == "fileerror"){
   echo "<p>There was a error uploading your photo!</p>" ;    
}
else if($_GET["error"] == "toobig"){
   echo "<p>The file is too big!</p>" ;    
}
  else if($_GET["error"] == "invalidfile"){ 
   echo "<p>That photo is invalid!</p>" ;    
}
else if($_GET["error"] == "passwordsdontmatch"){
   echo "<p>Passwords don't match!</p>";
}
  else if($_GET["error"] == "none"){
     echo "<p>You have signed up!</p>" ;    
  }
}
?>
