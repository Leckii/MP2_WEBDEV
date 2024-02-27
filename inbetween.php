<?php
function generateRandomNumber()
{
    return rand(1, 13);
}

session_start();

// Check if it's the first round or reset if 10 rounds are completed
if (!isset($_SESSION['round']) || $_SESSION['round'] > 10) {
    $_SESSION['round'] = 1;
    $_SESSION['totalPoints'] = 0;
}

// Check if the session round variable reaches 11
if ($_SESSION['round'] == 11) {
    header("Location: end.php");
    exit();
}

// Initial random numbers
$number1 = generateRandomNumber();
$number2 = generateRandomNumber();
$playerNumber = null;
$resultMessage = "";

// Show buttons only in the first round
$showButtons = ($_SESSION['round'] == 1);
$showNextRoundButton = ($_SESSION['round'] != 1); // Show "Next Round" button if not in the first round

if (isset($_POST['play'])) {
    $number1 = generateRandomNumber(); // Generate new random numbers for the next round
    $number2 = generateRandomNumber();
    $playerNumber = generateRandomNumber();
    $_SESSION['thisNumber1'] = $number1;
    $_SESSION['thisNumber2'] = $number2;
    $_SESSION['thisNumber3'] = $playerNumber;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Generate player's number
    $playerNumber = generateRandomNumber();
    $_SESSION['thisNumber3'] = $playerNumber;

    // Check if the "Deal" button is clicked
    if (isset($_POST['deal'])) {
        $win = ($_SESSION['thisNumber3'] > $_SESSION['thisNumber1'] && $_SESSION['thisNumber3'] < $_SESSION['thisNumber2']) ||
            ($_SESSION['thisNumber3'] > $_SESSION['thisNumber2'] && $_SESSION['thisNumber3'] < $_SESSION['thisNumber1']);

        if ($win) {
            $_SESSION['totalPoints'] += 10; // Add points to total
            $resultMessage = 'Congratulations! You win! Your number is ' . $_SESSION['thisNumber3'];
        } else {
            $_SESSION['totalPoints'] -= 5; // Deduct points from total
            $resultMessage = 'Sorry, you lose. Your number is ' . $_SESSION['thisNumber3'];
        }
        // Hide buttons after making a choice
        $showButtons = false;
        // Show "Next Round" button after making a choice
        $showNextRoundButton = true;
    }

    // Check if the "No Deal" button is clicked
    if (isset($_POST['nodeal'])) {
        $_SESSION['totalPoints'] -= 2; // Deduct points from total
        // Update game result
        $resultMessage = 'No Deal! Your number is ' . $_SESSION['thisNumber3'];
        // Hide buttons after making a choice
        $showButtons = false;
        // Show "Next Round" button after making a choice
        $showNextRoundButton = true;
    }

    // Check if the "Next Round" button is clicked
    if (isset($_POST['nextRound'])) {
        $number1 = generateRandomNumber(); // Generate new random numbers for the next round
        $number2 = generateRandomNumber();
        $_SESSION['thisNumber1'] = $number1;
        $_SESSION['thisNumber2'] = $number2;

        // Reset the flag to show buttons
        $showButtons = true;
        // Hide "Next Round" button
        $showNextRoundButton = false;
        // Increment the round
        $_SESSION['round']++;

        // Check if the session round variable reaches 11 after incrementing
        if ($_SESSION['round'] == 11) {
            header("Location: end.php");
            exit();
        }
    }
}

?>

<!-- Display current round information -->
<h1>In-Between Game</h1>
<p>Round: <?php echo $_SESSION['round']; ?>/10</p>
<p>Random Numbers: <?php echo $_SESSION['thisNumber1']; ?> and <?php echo $_SESSION['thisNumber2']; ?></p>
<p><?php echo $resultMessage; ?></p>

<!-- Display buttons only if the round limit is not reached and buttons should be shown -->
<?php if ($_SESSION['round'] <= 10) : ?>
    <form method="post">
        <!-- Display "Deal", "No Deal", and "Next Round" buttons -->
        <?php if ($showButtons) : ?>
            <button type="submit" name="deal" value="deal">Deal</button>
            <button type="submit" name="nodeal" value="nodeal">No Deal</button>
        <?php endif; ?>

        <?php if ($showNextRoundButton) : ?>
            <button type="submit" name="nextRound" value="nextRound">Next Round</button>
        <?php endif; ?>
    </form>
<?php endif; ?>