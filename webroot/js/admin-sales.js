document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('chartDataContainer');
    if (!container) return;

    const barDataSets = JSON.parse(container.getAttribute('data-bar'));
    const pieLabels = JSON.parse(container.getAttribute('data-pie-labels'));
    const pieData = JSON.parse(container.getAttribute('data-pie-data'));

    const ctxBar = document.getElementById('revenueBarChart');
    let revenueChart = null;

    if (ctxBar) {
        revenueChart = new Chart(ctxBar.getContext('2d'), {
            type: 'bar',
            data: {
                labels: barDataSets['month'].labels,
                datasets: [{
                    label: 'Revenue (RM)',
                    data: barDataSets['month'].data,
                    backgroundColor: 'rgba(0, 123, 255, 0.8)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: { 
                    y: { beginAtZero: true } 
                },
                animation: { duration: 500 }
            }
        });
    }

    const filterButtons = document.querySelectorAll('.chart-filter-btn');
    const chartTitle = document.getElementById('barChartTitle');

    if (filterButtons && revenueChart && chartTitle) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filterType = this.getAttribute('data-filter');
                
                if (filterType === 'week') chartTitle.innerText = 'Revenue Trend (Last 7 Days)';
                if (filterType === 'month') chartTitle.innerText = 'Revenue Trend (This Month)';
                if (filterType === 'year') chartTitle.innerText = 'Revenue Trend (This Year)';

                revenueChart.data.labels = barDataSets[filterType].labels;
                revenueChart.data.datasets[0].data = barDataSets[filterType].data;
                revenueChart.update();
            });
        });
    }

    const ctxPie = document.getElementById('methodPieChart');
    if (ctxPie) {
        new Chart(ctxPie.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#6c757d', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    const viewButtons = document.querySelectorAll('.btn-view-modal');
    const modalOverlay = document.getElementById('quickViewModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    if (viewButtons.length > 0 && modalOverlay) {
        viewButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.getElementById('modalReceiptId').innerText = this.getAttribute('data-receipt');
                document.getElementById('modalBookingId').innerText = this.getAttribute('data-booking');
                document.getElementById('modalCustomer').innerText = this.getAttribute('data-customer');
                document.getElementById('modalAmount').innerText = this.getAttribute('data-amount');
                document.getElementById('modalMethod').innerText = this.getAttribute('data-method');
                document.getElementById('modalDate').innerText = this.getAttribute('data-date');
                document.getElementById('modalStatus').innerText = this.getAttribute('data-status');
                
                const statusEl = document.getElementById('modalStatus');
                const statusTxt = this.getAttribute('data-status').toLowerCase();
                if(statusTxt.includes('pending')) statusEl.style.color = '#ffc107';
                else if(statusTxt.includes('completed') || statusTxt.includes('paid')) statusEl.style.color = '#28a745'; 
                else statusEl.style.color = '#dc3545';
                
                modalOverlay.classList.add('show');
            });
        });

        closeModalBtn.addEventListener('click', () => {
            modalOverlay.classList.remove('show');
        });

        modalOverlay.addEventListener('click', (e) => {
            if(e.target === modalOverlay) {
                modalOverlay.classList.remove('show');
            }
        });
    }
});