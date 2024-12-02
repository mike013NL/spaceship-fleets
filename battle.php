<?php

require_once 'spaceship.php';
require_once 'fleet.php';

// Genereer fleets
$spaceshipTypes = ['LightSpaceship', 'HeavySpaceship'];
$fleet1 = generateRandomFleet('Fleet 1', $spaceshipTypes);
$fleet2 = generateRandomFleet('Fleet 2', $spaceshipTypes);

// Simuleer battle
$result = battleFleets($fleet1, $fleet2);
$rankings = calculateFleetRanking([$fleet1, $fleet2]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player 1 - Fleet Battle</title>
</head>
<body>
    <h1>Player 1</h1>
    <h2>Fleet Battle Result</h2>
    <?php if ($result): ?>
        <p>Winner: <?php echo $result->name; ?></p>
    <?php else: ?>
        <p>It's a draw!</p>
    <?php endif; ?>
    <h2>Rankings</h2>
    <ul>
        <?php foreach ($rankings as $fleetName => $score): ?>
            <li><?php echo $fleetName; ?>: <?php echo $score; ?></li>
        <?php endforeach; ?>
    </ul>
    <canvas id="rankingChart" width="400" height="200"></canvas>
    <script src="ranking.js"></script>
</body>
</html>
