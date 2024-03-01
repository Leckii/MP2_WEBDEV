<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="endstyles.css">
<style>
    .animation-container {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px; /* Adjust the width and height according to your animation size */
            height: 100px;
            background-image: url('images/ATTACK.png'); /* Path to your spritesheet */
    }

            @keyframes play-attack-animation {
            <?php
            $frame_width_percentage = 100 / 7; // Assuming there are 7 frames horizontally
            for ($i = 0; $i < 7; $i++) {
                $frame_position = $i * $frame_width_percentage;
                echo "$frame_position% { background-position: -$i * 100px 0; }\n";
            }
            ?>
            }

</style>
    <title>Document</title>
    
</head>

<body>
    <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['totalPoints'] < 0) {
            // Points are negative, display DEATH animation
            echo '<div class="animation-container" style="animation: play-death-animation 1s steps(<?php echo $frame_count; ?>) infinite; background-image: url(\'images/DEATH.png\');"></div>';
            echo '<h1 class="center">GAME OVER</h1>';
        } else {
            // Points are not negative, display ATTACK animation
            echo '<div class="animation-container" style="animation: play-attack-animation 1s steps(<?php echo $frame_count; ?>) infinite; background-image: url(\'images/ATTACK.png\');"></div>';
            echo '<h1 class="center">YOU WIN</h1>';
        }

        
        echo '<p class="center">Points Earned: ' . $_SESSION['totalPoints'] . '</p>';

    echo '<p class="center">Rounds: 10 </p>' . '<br>';
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