<?php

declare(strict_types=1);

require_once('database/Restaurant.class.php');
require_once('database/Menu.class.php');
require_once('database/user.php');

function drawReviewForm(int $idRestaurant)
{ ?>
  <h2>Leave a Review</h2>
  <section id="reviewForm">
    <form action="/includes/review.inc.php" method="post">
      <p>Score: <input name="score" type="number" value="0" min="0" max="5" step="1"></p>
      <p>Review: <input type="text" name="reviewText"></p>
      <p><input type="hidden" name="id" value="<?= $idRestaurant ?>"></p>
      <p><button type="submit">Submit</button></p>
      <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    </form>
  </section>
<?php } ?>

<?php
function drawRestaurantReviews(PDO $db, int $idRestaurant, array $reviews)
{
  $ownerName = getRestaurantOwner($db, $idRestaurant) ?>
  <h2>Reviews</h2>
  <section id="restaurantReviews">
    <?php foreach ($reviews as $review) {
      $id = $review->idCustomer;
      $name = getIdName($db, $id); ?>
      <article class="review">
        <p><?= htmlspecialchars($name) ?> at <?= $review->date ?></p>
        <p class="description"><?= htmlspecialchars($review->description) ?></p>
        <p class="rating">Rating: <?= $review->rating ?></p>
        <?php if ($review->response != NULL) { ?>
          <section id="response">
            <h3><?= htmlspecialchars($ownerName) ?> said <?= htmlspecialchars($review->response) ?></h3>
          </section>
        <?php } ?>
      </article>
    <?php
    } ?>
  </section>
<?php } ?>

<?php
function drawUnrespondedReviews(PDO $db, array $reviews)
{ ?>
  <h2>Unresponded Reviews</h2>
  <section id="ownerReviews">
    <?php foreach ($reviews as $review) { ?>
      <p><?= Restaurant::getNamebyId($db, $review->idRestaurant) ?></p>
      <p><?= getIdName($db, $review->idCustomer) ?> at <?= $review->date ?></p>
      <p><?= $review->description ?></p>
      <p>rating:<?= $review->rating ?></p>
      <section id="reviewForm">
        <form action="/includes/addResponse.inc.php" method="post">
          Response: <input type="text" name="response">
          <input type="hidden" name="user" value="<?= $review->idCustomer ?>">
          <input type="hidden" name="restaurant" value="<?= $review->idRestaurant ?>">
          <input type="hidden" name="date" value="<?= $review->date ?>">
          <input type="hidden" name="description" value="<?= $review->description ?>">
          <input type="hidden" name="rating" value="<?= $review->rating ?>">
          <button type="submit" name="submit">Submit</button>
        </form>
      </section>
    <?php } ?>
  </section>
<?php  } ?>