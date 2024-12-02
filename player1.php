<?php
session_start();
include 'Spaceship.php';

// Laad spelers vanuit sessie
$player1 = isset($_SESSION['player1']) ? unserialize($_SESSION['player1']) : new Spaceship("Player 1");
$player2 = isset($_SESSION['player2']) ? unserialize($_SESSION['player2']) : new Spaceship("Player 2");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        // speler 1 opslaan in sessie en bestand
        $_SESSION['player1'] = serialize($player1);
        file_put_contents('player1_data.txt', serialize($player1)); // Sla speler 1 op in bestand
    } elseif (isset($_POST['load'])) {
        // Speler 1 laden vanuit bestand
        if (file_exists('player1_data.txt')) {
            $player1 = unserialize(file_get_contents('player1_data.txt'));
        }
    } elseif (isset($_POST['reset'])) {
        $player1->reset(); // Player 1 resetten
    } elseif (isset($_POST['damagePlayer2'])) {
        $player2->decreaseLives(); // Player 2 beschadigen
        $player1->increaseScore(10); // Player 1 krijgt 10 punten bij hit
    } elseif (isset($_POST['move'])) {
        $player1->decreaseFuel(); // Vermindert brandstof bij bewegen
    }

    // Bewaar na verwerking
    $_SESSION['player1'] = serialize($player1);
    $_SESSION['player2'] = serialize($player2);

    // Controleer of er een winnaar is
    if (!$player2->isAlive()) {
        echo "<p>Player 1 heeft gewonnen!</p>";
        session_destroy(); // eindigd het spel als speler 1 heeft gewonnen
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Speler 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><?php echo $player1->getName(); ?></h1>
    <div class="scoreboard">
        <p>Score: <?php echo $player1->getScore(); ?></p>
        <p>Levens: <?php echo $player1->getLives(); ?></p>
        <p>Fuel: <?php echo $player1->getFuel(); ?></p>
    </div>
    <form method="post" action="">
        <button type="submit" name="save">Save</button>
        <button type="submit" name="load">Load</button>
        <button type="submit" name="reset">Reset</button>
        <button type="submit" name="move">Move (Cost Fuel)</button>
        <button type="submit" name="damagePlayer2">cannonball speler 2</button>
    </form>
    <p><a href="player2.php">Ga naar Speler 2</a></p>
</div>
</body>
</html>
