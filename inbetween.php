<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knights of the In-Between</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
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

    if ($_SESSION['round'] == 11) {
        header("Location: end.php");
        exit();
    }

    $number1 = generateRandomNumber();
    $number2 = generateRandomNumber();
    $playerNumber = null;
    $resultMessage = "";

    $showButtons = ($_SESSION['round'] == 1);
    $showNextRoundButton = ($_SESSION['round'] != 1); // Show "Next Round" button if not in the first round

    if (isset($_POST['higher']) || isset($_POST['lower'])) {
        $_SESSION['round']++;
    }


    if (isset($_POST['play'])) {
        $number1 = generateRandomNumber();
        $number2 = generateRandomNumber();
        $playerNumber = generateRandomNumber();
        $_SESSION['thisNumber1'] = $number1;
        $_SESSION['thisNumber2'] = $number2;
        $_SESSION['thisNumber3'] = $playerNumber;
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $playerNumber = generateRandomNumber();
        $_SESSION['thisNumber3'] = $playerNumber;

        if (isset($_POST['deal'])) {
            $win = ($_SESSION['thisNumber3'] > $_SESSION['thisNumber1'] && $_SESSION['thisNumber3'] < $_SESSION['thisNumber2']) ||
                ($_SESSION['thisNumber3'] > $_SESSION['thisNumber2'] && $_SESSION['thisNumber3'] < $_SESSION['thisNumber1']);

            if ($win) {
                $_SESSION['totalPoints'] += 10;
                $resultMessage = "Well met, friend! Your number is " . $_SESSION['thisNumber3'] . ", a mark of fortune's grace. ";
            } else {
                $_SESSION['totalPoints'] -= 5; 
                $resultMessage = "Apologies, dear friend. Your number is " . $_SESSION['thisNumber3'] . ", eludes the realm of luck.";
            }
            $showButtons = false;
            $showNextRoundButton = true;
        }

        if (isset($_POST['nodeal'])) {
            $_SESSION['totalPoints'] -= 2; 
            $resultMessage = 'Declined! Your number is ' . $_SESSION['thisNumber3'] . ", unmoved by fate's sway!";
            $showButtons = false;
            $showNextRoundButton = true;
        }

        if (isset($_POST['higher'])) {
            $high = ($_SESSION['thisNumber3'] > $_SESSION['thisNumber1']) && ($_SESSION['thisNumber3'] > $_SESSION['thisNumber2']);
            $jackpot = ($_SESSION['thisNumber1'] == $_SESSION['thisNumber2'] && $_SESSION['thisNumber1'] == $_SESSION['thisNumber3']);


            if ($high) {
                $_SESSION['totalPoints'] += 10; 
                $resultMessage = "Well met, friend! Your number is " . $_SESSION['thisNumber3'] . ", a mark of fortune's grace. ";
            } elseif ($jackpot) {
                $_SESSION['totalPoints'] += 25;
                $resultMessage = "Joyous tidings! The jackpot is yours! Your number is " . $_SESSION['thisNumber3'] . " shines with victory!";
            } else {
                $_SESSION['totalPoints'] -= 5;
                $resultMessage = "Apologies, dear friend. Your number is " . $_SESSION['thisNumber3'] . ", eludes the realm of luck.";

                $showButtons = false;
                $showNextRoundButton = true;
            }
        } elseif (isset($_POST['lower'])) {
            $low = ($_SESSION['thisNumber3'] < $_SESSION['thisNumber1']) && ($_SESSION['thisNumber3'] < $_SESSION['thisNumber2']);
            $jackpot = ($_SESSION['thisNumber1'] == $_SESSION['thisNumber2'] && $_SESSION['thisNumber1'] == $_SESSION['thisNumber3']);

            if ($low) {
                $_SESSION['totalPoints'] += 10; 
                $resultMessage = "Well met, friend! Your number is " . $_SESSION['thisNumber3'] . ", a mark of fortune's grace. ";
            } elseif ($jackpot) {
                $_SESSION['totalPoints'] += 20;
                $resultMessage = $resultMessage = "Joyous tidings! The jackpot is yours! Your number is " . $_SESSION['thisNumber3'] . " shines with victory!";
            } else {
                $_SESSION['totalPoints'] -= 5; 
                $resultMessage = "Apologies, dear friend. Your number is " . $_SESSION['thisNumber3'] . ", eludes the realm of luck.";

                $showButtons = false;
                $showNextRoundButton = true;
            }
        }



        if (isset($_POST['nextRound'])) {
            $number1 = generateRandomNumber(); 
            $number2 = generateRandomNumber();
            $_SESSION['thisNumber1'] = $number1;
            $_SESSION['thisNumber2'] = $number2;
            $showButtons = true;
            $showNextRoundButton = false;
            $_SESSION['round']++;

            if ($_SESSION['round'] == 11) {
                header("Location: end.php");
                exit();
            }
        }
    }

    ?>

    <h1 class="style-header">KNIGHTS OF THE IN-BETWEEN</h1>
    <p class="style-text">Round: <?php echo $_SESSION['round']; ?>/10</p>
    <div class="cards">
        <div class="card">
            <div class="card-info">

                <div class="hidden-number"><?php echo $_SESSION['thisNumber1']; ?></div>
            </div>
        </div>
        <div class="card">
            <div class="card-info">

                <div class="hidden-number"><?php echo $_SESSION['thisNumber2']; ?></div>
            </div>
        </div>
    </div>
    <p class="style-resultmessage"><?php echo $resultMessage; ?></p>

    <?php if ($_SESSION['round'] <= 10) : ?>
        <form method="post">
            <?php if ($showButtons) : ?>
                <?php if ($_SESSION['thisNumber1'] == $_SESSION['thisNumber2']) : ?>
                    <br><br><br><br>
                    <div class="buttons">
                        <button type="submit" name="higher" value="higher">Higher</button>
                        <button type="submit" name="lower" value="lower">Lower</button>
                    <?php else : ?>
                        <button type="submit" name="deal" value="deal">Deal</button>
                        <button type="submit" name="nodeal" value="nodeal">No Deal</button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($showNextRoundButton) : ?>
                <button type="submit" name="nextRound" value="nextRound">Next Round</button>
            <?php endif; ?>
        <?php endif; ?>
        </form>
</body>