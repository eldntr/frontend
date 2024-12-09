<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Seller</title>
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
</head>
<body>
    <div class="container">
        <h1>Dashboard Seller</h1>
        <div id="seller-summary" class="dashboard-section"></div>
        <div id="seller-products" class="dashboard-section"></div>
        <div id="seller-orders" class="dashboard-section"></div>
    </div>
    <script>
        // Fungsi untuk mengambil data dari API
        async function fetchData(url) {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }

        // Menampilkan ringkasan penjualan
        async function displaySellerSummary() {
            try {
                const summary = await fetchData('http://localhost:8080/seller/summary');
                const summaryDiv = document.getElementById('seller-summary');
                summaryDiv.innerHTML = `
                    <h2>Ringkasan Penjualan</h2>
                    <p>Total Penjualan: ${summary.totalSales}</p>
                    <p>Total Produk: ${summary.totalProducts}</p>
                    <p>Total Pendapatan: ${summary.totalRevenue}</p>
                    <p>Orders in Process: ${summary.ordersInProcess}</p>
                `;
            } catch (error) {
                console.error('Error fetching seller summary:', error);
            }
        }

        // Menampilkan daftar produk
        async function displaySellerProducts() {
            try {
                const products = await fetchData('http://localhost:8080/seller/products');
                const productsDiv = document.getElementById('seller-products');
                productsDiv.innerHTML = '<h2>Daftar Produk</h2><ul>' + 
                    products.map(product => `
                        <li>
                            <h3>${product.name}</h3>
                            <p>Harga: ${product.price}</p>
                            <p>Stok: ${product.stock}</p>
                        </li>
                    `).join('') + 
                    '</ul>';
            } catch (error) {
                console.error('Error fetching seller products:', error);
            }
        }

        // Menampilkan daftar pesanan
        async function displaySellerOrders() {
            try {
                const orders = await fetchData('http://localhost:8080/seller/orders');
                const ordersDiv = document.getElementById('seller-orders');
                ordersDiv.innerHTML = '<h2>Daftar Pesanan</h2><ul>' + 
                    orders.map(order => `
                        <li>
                            <p>ID Pesanan: ${order.id}</p>
                            <p>Status: ${order.status}</p>
                            <p>Total: ${order.total}</p>
                        </li>
                    `).join('') + 
                    '</ul>';
            } catch (error) {
                console.error('Error fetching seller orders:', error);
            }
        }

        // Memanggil fungsi untuk menampilkan data
        displaySellerSummary();
        displaySellerProducts();
        displaySellerOrders();
    </script>
</body>
</html>
