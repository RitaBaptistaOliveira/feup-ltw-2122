<?php
//esta classe ainda nao esta a ser utilizada.
  class Session {
    static function generate_random_token() {
      return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function __construct() {
      session_start();
      if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = Session::generate_random_token();
      }
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function getScreenName() : ?string {
      return isset($_SESSION["screenName"]) ? $_SESSION["screenName"] : null;
    }

    public function setScreenName(string $name) {
      $_SESSION["screenName"] = $name;
    }

    public function getAddress() : ?string {
      return isset($_SESSION['address']) ? $_SESSION['address'] : null;
    }

    public function setAddress(string $name) {
      $_SESSION['address'] = $name;
    }

    public function getUsername() : ?string {
      return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    public function setUsername(string $username) {
      $_SESSION['username'] = $username;
    }

    public function getPhotoExt() : ?string {
      return isset($_SESSION['photoExtension']) ? $_SESSION['photoExtension'] : null;
    }

    public function setPhotoExt(string $ext) {
      $_SESSION['photoExtension'] = $ext;
    }

    public function getPhoneNumber() : ?int {
      return isset($_SESSION['phoneNumber']) ? $_SESSION['phoneNumber'] : null;
    }

    public function setPhoneNumber(int $number) {
      $_SESSION['phoneNumber'] = $number;
    }

    public function getUserType() : ?string {
      return isset($_SESSION['userType']) ? $_SESSION['userType'] : null;
    }

    public function setUserType(string $type) {
      $_SESSION['userType'] = $type;
    }

    public function setCart() {
      $_SESSION['cart'] = array();
      $_SESSION['id'] = NULL;
    }
  }
?>