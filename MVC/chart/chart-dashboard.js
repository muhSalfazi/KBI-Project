document.addEventListener('DOMContentLoaded', function() {
    const ctxPie = document.getElementById('myPieChart');
    if (ctxPie && typeof pieData !== 'undefined') {
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Close', 'Open'],
                datasets: [{
                    data: [pieData.Close, pieData.Open],
                    backgroundColor: ['#43eb34', '#f0ad4e'],
                    borderColor: ['#43eb34', '#f0ad4e'],
                    borderWidth: 1
                }]
            },
            options: {
              maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Persentase Tiket Open vs Close Hari Ini'
                    }
                }
            }
        });
    }

    const ctxBar = document.getElementById('myBarChart');
    if (ctxBar && typeof barData !== 'undefined') {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Cycle 1', 'Cycle 2', 'Cycle 3', 'Cycle 4'],
                datasets: [
                  {
                    label: 'Close',
                    data: barData.Close,
                    backgroundColor: '#43eb34'
                  },
                  {
                      label: 'Open',
                      data: barData.Open,
                      backgroundColor: '#f0ad4e'
                  }
                ]
            },
            options: {
              maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Tiket Berdasarkan Cycle'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    }
});
