document.addEventListener("DOMContentLoaded", function() {
    if (typeof window.dashboardData === 'undefined') return;

    const data = window.dashboardData;

    // Bar chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: data.monthlyLabels,
            datasets: [{
                label: 'Total Bookings',
                data: data.monthlyData,
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Pie Chart 
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Rented', 'Maintenance'],
            datasets: [{
                data: [
                    data.carStatus.Available, 
                    data.carStatus.Rented, 
                    data.carStatus.Maintenance
                ],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});