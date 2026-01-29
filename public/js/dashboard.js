const canvas = document.getElementById('confirmationChart');

if (canvas) {
    const rate = parseFloat(canvas.dataset.confirmation);

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: ['Confirmées', 'Non confirmées'],
            datasets: [{
                data: [rate, 100 - rate]
            }]
        }
    });
}
