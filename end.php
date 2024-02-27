<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    echo "Points: " . $_SESSION['totalPoints'] . '<br>';
    echo '<br>';
    echo "Rounds: 10 " . '<br>';
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