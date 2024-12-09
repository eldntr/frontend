<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Discount Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Discount Dashboard</h1>
        <div id="discount-summary" class="dashboard-section"></div>
        <div id="discount-products" class="dashboard-section"></div>
    </div>
    <script>
        async function fetchData(url) {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }

        async function displayDiscountSummary() {
            try {
                const summary = await fetchData('http://localhost:8080/discount/summary');
                const summaryDiv = document.getElementById('discount-summary');
                summaryDiv.innerHTML = `
                    <h2>Discount Summary</h2>
                    <p>Total Discounts: ${summary.totalDiscounts}</p>
                `;
            } catch (error) {
                console.error('Error fetching discount summary:', error);
            }
        }

        async function displayDiscountProducts() {
            try {
                const products = await fetchData('http://localhost:8080/discount/products');
                const productsDiv = document.getElementById('discount-products');
                productsDiv.innerHTML = '<h2>Discounted Products</h2><ul>' + 
                    products.map(product => `
                        <li>
                            <h3>${product.name}</h3>
                            <p>Original Price: ${product.originalPrice}</p>
                            <p>Discounted Price: ${product.discountedPrice}</p>
                        </li>
                    `).join('') + 
                    '</ul>';
            } catch (error) {
                console.error('Error fetching discount products:', error);
            }
        }

        displayDiscountSummary();
        displayDiscountProducts();
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
