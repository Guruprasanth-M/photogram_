<?php

class UserSession
{
    // ✅ Declare all properties to avoid dynamic property warnings
    private $conn;
    private string $token;
    private array|null $data = null;
    private int $uid;

    /**
     * This function will return a session ID if username and password is correct.
     *
     * @return string|false
     */
    public static function authenticate($user, $pass, $fingerprint = null)
    {
        $username = User::login($user, $pass);
        if ($username) {
            $user = new User(usernameOrId: $username);
            $conn = Database::getConnection();
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $token = md5(rand(0, 9999999) . $ip . $agent . time());

            $fingerprint = mysqli_real_escape_string($conn, $fingerprint ?? 'unknown');
            $agent = mysqli_real_escape_string($conn, $agent);

            $sql = "INSERT INTO `session` (`uid`, `token`, `login_time`, `ip`, `user_agent`, `active`, `fingerprint`)
                    VALUES ('$user->id', '$token', now(), '$ip', '$agent', '1', '$fingerprint')";
            // $stmt = $pdo->prepare("
            // INSERT INTO `session` 
            // (`uid`, `token`, `login_time`, `ip`, `user_agent`, `active`, `fingerprint`)
            //  VALUES (?, ?, now(), ?, ?, 1, ?)
            // ");
            // $stmt->execute([
            //  $user->id,
            //  $token,
            //  $ip,
            //  $agent,
            // $fingerprint
            // ]);

            if ($conn->query($sql)) {
                Session::set('session_token', $token);
                Session::set('fingerprint', $fingerprint);
                return $token;
            } else {
                error_log("DB Error: " . $conn->error);
                return false;
            }
        }
        return false;
    }

    public static function authorize($token)
    {
        try {
            $session = new UserSession($token);
            if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER["HTTP_USER_AGENT"])) {
                if ($session->isValid() && $session->isActive()) {
                    if ($_SERVER['REMOTE_ADDR'] == $session->getIP()) {
                        if ($_SERVER['HTTP_USER_AGENT'] == $session->getUserAgent()) {
                            if ($session->getFingerprint() == $_SESSION['fingerprint']) {
                                return true;
                            } else {
                                throw new Exception("Fingerprint doesn't match");
                            }
                        } else {
                            throw new Exception("User agent doesn't match");
                        }
                    } else {
                        throw new Exception("IP doesn't match");
                    }
                } else {
                    $session->removeSession();
                    throw new Exception("Invalid session");
                }
            } else {
                throw new Exception("IP and User_agent are null");
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function __construct($token)
    {
        $this->conn = Database::getConnection();
        $this->token = $token;

        // $sql = "SELECT * FROM `session` WHERE `token`='$token' LIMIT 1";
        // $result = $this->conn->query($sql);
        $stmt = $this->conn->prepare("SELECT * FROM `session` WHERE `token` = ? LIMIT 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->data = $row;
            $this->uid = (int)$row['uid'];
        } else {
            throw new Exception("Session is invalid.");
        }
    }

    public function getUser()
    {
        return new User($this->uid);
    }

    public function isValid(): bool
    {
        if (isset($this->data['login_time'])) {
            $login_time = DateTime::createFromFormat('Y-m-d H:i:s', $this->data['login_time']);
            return (3600 > time() - $login_time->getTimestamp());
        } else {
            throw new Exception("Login time is null");
        }
    }

    public function getIP()
    {
        return $this->data["ip"] ?? false;
    }

    public function getUserAgent()
    {
        return $this->data["user_agent"] ?? false;
    }

    public function deactivate()
    {
        $sql = "UPDATE `session` SET `active` = 0 WHERE `uid` = $this->uid";
        return $this->conn->query($sql);
    }

    public function isActive()
    {
        return isset($this->data['active']) ? (bool)$this->data['active'] : false;
    }

    public function getFingerprint()
    {
        return $this->data['fingerprint'] ?? false;
    }

    public function removeSession()
    {
        if (isset($this->data['id'])) {
            $id = (int)$this->data['id'];
            $sql = "DELETE FROM `session` WHERE `id` = $id";
            return $this->conn->query($sql);
        }
        return false;
    }
}
