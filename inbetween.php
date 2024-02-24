<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In-Between</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php
    function generateRandomNumber()
    {
        return rand(1, 13);
    }

    $number1 = generateRandomNumber();
    $number2 = generateRandomNumber();
    $playerNumber = null;
    $resultMessage = '';

    if (isset($_POST['deal'])) {
        $playerNumber = generateRandomNumber();
        
        if ($_POST['deal'] === "deal") {
            $win = ($playerNumber > $number1 && $playerNumber < $number2 || $playerNumber > $number2 && $playerNumber < $number1);

            if ($win) {
                $points = 10;
                $resultMessage = 'Congratulations! You win!';
            } else {
                $points = -5;
                $resultMessage = 'Sorry, you lose. Try again!';
            }
        } else {
            $points = -2;
            $resultMessage = 'Sorry, you lose. Try again!';
        }
    }
    ?>

    <h1>In-Between Game</h1>

    <p>Random Numbers: <?php echo "<input type='hidden' name='number1' value='$number1'>"; ?> and <?php echo "<input type='hidden' name='number2' value='$number2'>"; ?></p>
    
    <form method="post">
        <button type="submit" name="deal" value="deal">Deal</button>
    </form>
</body>

</html>
