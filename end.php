<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="endstyles.css">

    <title>KNIGHTS OF THE IN-BETWEEN RESULT</title>
    
</head>

<body>
    <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['totalPoints'] <= 0) {
            echo '<h1 class="center">GAME OVER</h1>';
        } elseif ($_SESSION['totalPoints'] < 20) {
            echo '<h1 class="center">GAME OVER</h1>';
        } else {
            echo '<h1 class="center">YOU WIN</h1>';
        }
        
        echo '<p class="center">Points Earned: ' . $_SESSION['totalPoints'] . '</p>';
    ?>
    <br>
        <button id="playAgainBtn">Play Again?</button>

<script>
    document.getElementById("playAgainBtn").addEventListener("click", function() {
        window.location.href = "inbetween.php";
    });
</script>
</body>

</html>