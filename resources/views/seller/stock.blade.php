<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Stock Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Stock Dashboard</h1>
        <div id="stock-list" class="dashboard-section"></div>
    </div>
    <script>
        async function fetchData(url) {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }

        async function displayStock() {
            try {
                const stock = await fetchData('http://localhost:8080/stock');
                const stockDiv = document.getElementById('stock-list');
                stockDiv.innerHTML = '<h2>Stock List</h2><ul>' + 
                    stock.map(item => `
                        <li>
                            <p>Product: ${item.productName}</p>
                            <p>Quantity: ${item.quantity}</p>
                        </li>
                    `).join('') + 
                    '</ul>';
            } catch (error) {
                console.error('Error fetching stock:', error);
            }
        }

        displayStock();
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
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
