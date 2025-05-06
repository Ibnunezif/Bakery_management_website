// Access the data passed from PHP
console.log(chartData); // Debugging: Check the structure of the data


const labels = chartData.map(item => item.productType);
const totalProduced = chartData.map(item => item.totalProduced);
const totalSold = chartData.map(item => item.totalSold);


const available = totalProduced.map((produced, index) => produced - totalSold[index]);

// Create the chart
const ctx = document.getElementById('productSalesChart').getContext('2d');
const productSalesChart = new Chart(ctx, {
    type: 'bar', // Chart type (e.g., bar, line, pie)
    data: {
        labels: labels, // Product types
        datasets: [
            {
                label: 'Total Produced',
                data: totalProduced,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Total Sold',
                data: totalSold,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Available',
                data: available, // Use the calculated "Available" data
                backgroundColor: 'rgba(9, 143, 80, 0.6)',
                borderColor: 'rgb(11, 164, 80)',
                borderWidth: 1
            },
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Total Products Produced and Sold'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});