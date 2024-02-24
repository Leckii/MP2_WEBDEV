<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In-Between Game</title>
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
    

    if (isset($_POST['deal'])) {
        $playerNumber = generateRandomNumber();

        function calculatePoints($choice, $number1, $number2, $playernumber, $points) {
            if ($choice === "deal") {
                // Check if third card is between the first two
                $win = ($playernumber > min($number1, $number2) && $playernumber < max($number1, $number2));
                if ($win) {
                    $points += 10; // Increase points for winning
                    $resultMessage = 'Congratulations! You win!';
                } else {
                    $points -= 5; // Decrease points for losing
                }
            } else { // choice is "no deal"
                $points -= 2; // Deduct points for choosing "no deal"
                $resultMessage = 'Sorry, you lose. Try again!';
            }
            return $points;
        }
    
        // Initialize variables
        $totalRounds = 10;
        $points = 0;
        $resultMessage = '';
    
    }
    
    ?>

    <h1>In-Between Game</h1>

    <p>Random Numbers: <?php echo $number1; ?> and <?php echo $number2; ?></p>

    <form method="post">
        <button type="submit" name="deal">Deal</button>
    </form>

    <?php if ($playerNumber !== null) : ?>
        <p>Your Number: <?php echo $playerNumber; ?></p>
        <p><?php echo $resultMessage; ?></p>
    <?php endif; ?>

</body>

</html>