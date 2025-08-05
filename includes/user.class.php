<?php

class user {
    private $conn;

    // ✅ Declare properties to avoid dynamic property warnings
    public int $id;
    public string $username;

    public function __construct($usernameOrId) {
        $this->conn = Database::getConnection();
        $this->id = 0;
        $this->username = '';

        $sql = "SELECT `id`, `username` FROM `live` WHERE `username` = '$usernameOrId' OR `id` = '$usernameOrId' LIMIT 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->id = (int)$row['id'];
            $this->username = $row['username'];
        } else {
            throw new Exception("User not found.");
        }
    }

    public function __call($name, $arguments) {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3) == "set") {
            return $this->_set_data($property, $arguments[0]);
        } else {
            throw new Exception("function -> $name is not available");
        }
    }

    public static function signup($user, $pass, $email, $phone) {
        $options = ['cost' => 11];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $conn = Database::getconnection();

        $sql = "INSERT INTO  `live` (`username`, `password`, `phone`, `email`, `blocked`)
                VALUES ('$user', '$pass', '$phone', '$email', '1')";

        $error = false;
        try {
            if ($conn->query($sql) !== TRUE) {
                $error = $conn->error;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $conn->close();
        return $error;
    }

    public static function login($user, $pass) {
       $query = "SELECT * FROM `live` WHERE `username` = '$user'"; //vulnerable
        // $stmt = $pdo->prepare("SELECT * FROM `live` WHERE `username` = :username");
        // $stmt->execute(['username' => $user]);

            print($sql);
        $conn = Database::getconnection();
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                return $row['id'];
            }
        }
        return false;
    }

    
//     public static function login($user, $pass) {
//     $query = "SELECT * FROM `live` WHERE `username` = '$user'";
//     print($query);
//     $conn = Database::getconnection();
//     $result = $conn->query($query);

//     if ($result && $result->num_rows >= 1) {
//         // Just return the first matched user's ID without checking password
//         $row = $result->fetch_assoc();
//         return $row['id'];
//     }

//     return false;
// }


    private function _get_data($var) {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "SELECT `$var` FROM `users` WHERE `id` = $this->id";
            // $stmt = $pdo->prepare("SELECT `$var` FROM `users` WHERE `id` = ?");
            // $stmt->execute([$this->id]);
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows === 1) ? $result->fetch_assoc()[$var] : null;
    }

    private function _set_data($var, $data) {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
      $sql = "UPDATE `users` SET `$var`='$data' WHERE `id`=$this->id;";
            // $stmt = $pdo->prepare("UPDATE `users` SET `$var` = :value WHERE `id` = :id");
            // $stmt->execute([':value' => $data,':id' => $this->id]);
        return $this->conn->query($sql);
    }

    public function setDob($year, $month, $day) {
        if (checkdate($month, $day, $year)) {
            return $this->_set_data('dob', "$year.$month.$day");
        }
        return false;
    }

    public function getUsername() {
        return $this->username;
    }

    public function authenticate() {
        // Left empty intentionally
    }
}


    // public function setBio($bio)
    // {
    //     //TODO: Write UPDATE command to change new bio
    //     return $this->_set_data('bio', $bio);
    // }

    // public function getBio()
    // {
    //     //TODO: Write SELECT command to get the bio.
    //     return $this->_get_data('bio');
    // }

    // public function setAvatar($link)
    // {
    //     return $this->_set_data('avatar', $link);
    // }

    // public function getAvatar()
    // {
    //     return $this->_get_data('avatar');
    // }

    // public function setFirstname($name)
    // {
    //     return $this->_set_data("firstname", $name);
    // }

    // public function getFirstname()
    // {
    //     return $this->_get_data('firstname');
    // }

    // public function setLastname($name)
    // {
    //     return $this->_set_data("lastname", $name);
    // }

    // public function getLastname()
    // {
    //     return $this->_get_data('lastname');
    // }



    // public function getDob()
    // {
    //     return $this->_get_data('dob');
    // }

    // public function setInstagramlink($link)
    // {
    //     return $this->_set_data('instagram', $link);
    // }

    // public function getInstagramlink()
    // {
    //     return $this->_get_data('instagram');
    // }

    // public function setTwitterlink($link)
    // {
    //     return $this->_set_data('twitter', $link);
    // }

    // public function getTwitterlink()
    // {
    //     return $this->_get_data('twitter');
    // }
    // public function setFacebooklink($link)
    // {
    //     return $this->_set_data('facebook', $link);
    // }

    // public function getFacebooklink()
    // {
    //     return $this->_get_data('facebook');
    // }

