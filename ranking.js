document.addEventListener('DOMContentLoaded', function () {
    const fleetData = JSON.parse('<?php echo json_encode($rankings); ?>');

    const labels = Object.keys(fleetData);
    const scores = Object.values(fleetData);

    const ctx = document.getElementById('rankingChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Fleet Ranking Score',
                data: scores,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
