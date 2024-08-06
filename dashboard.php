<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

// Check if $_SESSION['timeout'] is set, if not set it to current time
if (!isset($_SESSION['timeout'])) {
    $_SESSION['timeout'] = time();
}

// Check for inactivity
$inactive = 600; // 10 minutes
if (isset($_SESSION['timeout'])) {
    $currentTime = time();
    $session_life = $currentTime - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        header("location: index.php");
        exit;
    }
}

// Update session timeout to current time
$_SESSION['timeout'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>
                    <div class="card-body">
                        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
                        <p>This is your dashboard.</p>
                        <p>Time left until automatic logout: <span id="timer"></span></p>
                        <a href="logout.php" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Event listeners to restart timer on mousemove and keydown events
        document.addEventListener('mousemove', resetTimeout);
        document.addEventListener('keydown', resetTimeout);

        // Function to reset session timeout
        function resetTimeout() {
            <?php $_SESSION['timeout'] = time(); ?>;
        }

        // Function to update countdown timer
        function updateTimer() {
            var currentTime = Math.floor(Date.now() / 1000);
            var sessionTimeout = <?php echo $inactive; ?>;
            var timeLeft = sessionTimeout - (currentTime - <?php echo $_SESSION['timeout']; ?>);

            if (timeLeft <= 0) {
                // Logout user if session timeout reached
                window.location.href = 'logout.php';
            } else {
                var minutes = Math.floor(timeLeft / 60);
                var seconds = timeLeft % 60;

                document.getElementById('timer').innerHTML = minutes + 'm ' + seconds + 's';
                setTimeout(updateTimer, 1000);
            }
        }

        // Call updateTimer function initially
        updateTimer();
    </script>
</body>

</html>