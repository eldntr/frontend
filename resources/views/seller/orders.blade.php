<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Orders Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Orders Dashboard</h1>
        <div id="orders-list" class="dashboard-section"></div>
    </div>
    <script>
        async function fetchData(url) {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }

        async function displayOrders() {
            try {
                const orders = await fetchData('http://localhost:8080/orders');
                const ordersDiv = document.getElementById('orders-list');
                ordersDiv.innerHTML = '<h2>Orders List</h2><ul>' + 
                    orders.map(order => `
                        <li>
                            <p>Order ID: ${order.id}</p>
                            <p>Status: ${order.status}</p>
                            <p>Total: ${order.total}</p>
                        </li>
                    `).join('') + 
                    '</ul>';
            } catch (error) {
                console.error('Error fetching orders:', error);
            }
        }

        displayOrders();
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .dashboard-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1, h2 {
            color: #333;
        }
    </style>
</body>
</html>
