<?php 
    declare(strict_types = 1);

    class Review{
        public int $idCustomer;    
        public int $idRestaurant;
        public string $date;       
        public string $description; 
        public int $rating;    
        public string $response; 

        public function __construct(int $idCustomer, int $idRestaurant, string $date, string $description, int $rating, string $response)
        { 
            $this->idCustomer = $idCustomer;
            $this->idRestaurant = $idRestaurant;
            $this->date = $date;
            $this->description = $description;
            $this->rating = $rating;
            $this->response = $response;
        }

        static function getRestaurantReviews(PDO $db, int $idRestaurant) : array {
            $stmt = $db->prepare('SELECT * FROM Review WHERE idRestaurant = ?');
            $stmt->execute(array($idRestaurant));
            $Reviews = array();
            while($Review = $stmt->fetch()){
                $Reviews[] = new Review(
                    intval($Review['idCustomer']),
                    intval($Review['idRestaurant']),
                    $Review['date'],
                    $Review['description'],
                    intval($Review['rating']),
                    $Review['response'] == NULL? "" : $Review['response']
                );
            }
            return $Reviews;
      }
    }
?>

