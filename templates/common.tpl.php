<?php 
declare(strict_types = 1); 
require_once('utils/session.php');

$session = new Session;
?>

<?php function drawHeader(Session $session) { ?>
  <!DOCTYPE html>
  <html lang="en-US">
  <head>
    <title>Foodies</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
    <script src="javascript/cart.js" defer></script>
    <script src="javascript/search.js" defer></script>
  </head>

  <body>
    <header id = "topBar">
        <h1><a href="index.php">Foodies</a></h1>
      <?php 
        if ($session->isLoggedIn()){
          drawLogout($session);
        }
        else 
          drawLogin();
      ?>
    </header>
    <main>
    <?php } ?>

    <?php function drawFooter()
    { ?>
    </main>
    <footer id="siteFooter">
      LTW Foodies &copy; 2022
    </footer>
  <?php } ?>

  <?php function drawLogin()
  { ?>
    <section id="login">
      <a href="login.php">Log In</a>
      | <a href="register.php">Register</a>
      <i class="fa fa-user-circle-o" style="font-size:25px;"></i>
    </section>

  <?php } ?>

<?php function drawLogout(Session $session) { ?>
<section id="logout">
  <form action="actions/action_logout.php" method="post" class="logout">
    <a href= "profile.php"><?=htmlspecialchars($session->getScreenName())?></a>
    <a href= "favorites.php?id=<?=$session->getId()?>"><i class="fa fa-heart-o" style="font-size:25px;"></i></a>
    <button type="submit">Logout</button>
    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
</section>
<?php } ?>

<?php function drawMainPage(Session $session)
{ ?>
  <section id = "mainMenuOptions">
    <article>
      <img src="images/createAccount.png" alt="create Account" class: mainOpImage>
      <?php if($session->isLoggedIn()){?>
        <footer><a href="profile.php">Check your account</a></footer>
      <?php } else { ?>  
        <footer><a href="register.php">Create an account</a></footer>
    <?php } ?>
    </article>

    <article>
      <img src="images/placeOrder.png" alt="place your order"  class: mainOpImage>
      <footer><a href="placeOrder.php">Place your order</a></footer>
    </article>

    <article>
      <img src="images/saveFavorites.png" alt="save your favorite products" class: mainOpImage>
      <?php if($session->isLoggedIn()){?>
      <footer><a href="favorites.php?id=<?=$session->getId()?>">Save your favorite products</a></footer> 
      <?php } else { ?>
        <footer><a href="register.php">Save your favorite products</a></footer> 
      <?php } ?>
    </article>
  </section>
  <?php } ?>
