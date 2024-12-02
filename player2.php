<?php

// start de sessie om toegang te krijgen tot sessiegegevens
session_start();

// include de Spaceship-klasse om het ruimteschip-object te gebruiken
include 'Spaceship.php';

// laad spelers vanuit sessie
// controleer of er al een opgeslagen versie van $player2 in de sessie bestaat (in $_SESSION['player2']).
$player2 = isset($_SESSION['player2']) ? unserialize($_SESSION['player2']) : new Spaceship("Player 2");
$player1 = isset($_SESSION['player1']) ? unserialize($_SESSION['player1']) : new Spaceship("Player 1");

// Controleer of het verzoek een POST-verzoek is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of de 'save'-knop is ingedrukt
    if (isset($_POST['save'])) {
        // Sla speler 2 op in de sessie en het bestand
        $_SESSION['player2'] = serialize($player2); // Sla speler 2 op in de sessie
        file_put_contents('player2_data.txt', serialize($player2)); // Sla speler 2 op in bestand

        // Controleer of de laad-knop is ingedrukt
    } elseif (isset($_POST['load'])) {
        // laad speler 2 vanuit het bestand
        // player 2 ($player2) wordt opgeslagen in een sessie en in het bestand player2_data.txt.
        // de serialize-functie zet het object om in tekstformaat voor opslag.
        if (file_exists('player2_data.txt')) {
            $player2 = unserialize(file_get_contents('player2_data.txt')); // Laad en deserialiseer de gegevens
        }

        // Controleer of de 'reset'-knop is ingedrukt
    } elseif (isset($_POST['reset'])) {
        // Reset Player 2 naar de initiële waarden
        $player2->reset(); // Player 2 resetten

        // Controleer of de 'damagePlayer1'-knop is ingedrukt
    } elseif (isset($_POST['damagePlayer1'])) {
        // Verminder het aantal levens van Player 1 en verhoog de score van Player 2
        $player1->decreaseLives(); // Player 1 damagen
        $player2->increaseScore(10); // Player 2 krijgt 10 punten bij hit

        // Controleer of de 'move'-knop is ingedrukt
    } elseif (isset($_POST['move'])) {
        // Verminder de brandstof van Player 2 bij elke beweging
        $player2->decreaseFuel(); // Verlaagt brandstof bij bewegen
    }

    // Bewaar de huidige status van de spelers na verwerking
    $_SESSION['player2'] = serialize($player2); // Sla Player 2 op in de sessie
    $_SESSION['player1'] = serialize($player1); // Sla Player 1 op in de sessie

    // controleer of er een winnaar is
    if (!$player1->isAlive()) {
        // als Player 1 geen levens meer heeft, heeft Player 2 gewonnen
        echo "<p>Player 2 heeft gewonnen!</p>"; // geef winnaar weer
        session_destroy(); // vernietig de sessie als Player 2 heeft gewonnen
        exit; // stop verdere uitvoering van het script
    }
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Speler 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><?php echo $player2->getName(); ?></h1>
    <div class="scoreboard">
        <p>Score: <?php echo $player2->getScore(); ?></p>
        <p>Levens: <?php echo $player2->getLives(); ?></p>
        <p>Fuel: <?php echo $player2->getFuel(); ?></p>
    </div>
    <form method="post" action="">
        <button type="submit" name="save">Save</button>
        <button type="submit" name="load">Load</button>
        <button type="submit" name="reset">Reset</button>
        <button type="submit" name="move">Move (Cost Fuel)</button>
        <button type="submit" name="damagePlayer1">fireball speler 1</button>
    </form>
    <p><a href="player1.php">Ga naar Speler 1</a></p>
</div>
</body>
</html>
