import Chart from 'chart.js/auto';

// Récupère les données depuis ton API
async function fetchRoutesStats() {
    const response = await fetch('/api/admin/stats');
    const data = await response.json();
    return data;
}

function initCharts(data) {
    // --- Trajets par ville ---
    const villesLabels = data.routes_par_ville.map(r => r.town);
    const villesData = data.routes_par_ville.map(r => r.total);
    const ctxVilles = document.getElementById('chartVilles').getContext('2d');
    new Chart(ctxVilles, {
        type: 'bar',
        data: {
            labels: villesLabels,
            datasets: [{
                label: 'Nombre de trajets par ville',
                data: villesData,
                backgroundColor: ['#36A2EB', '#FF6384'],
            }]
        },
        options: { responsive: true, plugins: { legend: { display: true } } }
    });

    // --- Trajets par jour ---
    const joursLabels = data.routes_par_jour.map(r => r.day.split('T')[0]);
    const joursData = data.routes_par_jour.map(r => r.total);
    const ctxJours = document.getElementById('chartJours').getContext('2d');
    new Chart(ctxJours, {
        type: 'line',
        data: {
            labels: joursLabels,
            datasets: [{
                label: 'Nombre de trajets par jour',
                data: joursData,
                fill: false,
                borderColor: '#FFCE56',
                tension: 0.2
            }]
        },
        options: { responsive: true, plugins: { legend: { display: true } } }
    });
}

// Initialisation
document.addEventListener('DOMContentLoaded', async () => {
    const data = await fetchRoutesStats();
    initCharts(data);
});
