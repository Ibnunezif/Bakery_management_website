
        // Access the monthly revenue data from PHP
        console.log(monthlyRevenue)
        if (monthlyRevenue.length === 0) {
            console.error("No data available for the chart.");
        }

        // Extract labels (Year-Month) and data (Net Revenue)
        const year_month = monthlyRevenue.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`);
        const netRevenue = monthlyRevenue.map(item => item.netRevenue);

        // Create the line chart
        const monthlyRevenueCtx = document.getElementById('monthlyRevenue').getContext('2d');
        const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
            type: 'line', // Line chart
            data: {
                labels: year_month, // Year-Month labels
                datasets: [{
                    label: 'Net Revenue (birr)',
                    data: netRevenue, // Net revenue data
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Net Revenue Report'
                    }
            
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Net Revenue (birr)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
