<?php
include 'db.php';

// Fetch menu items
$query = "SELECT name, price FROM menu";
$result = $conn->query($query);

// Calculate total
$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }
        .container {
            background: #fff;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #2c3e50;
            color: white;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
            text-align: right;
            margin-top: 20px;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bill Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Food Item</th>
                <th>Price (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>₹<?php echo number_format($item['price'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="total">Total: ₹<?php echo number_format($total, 2); ?></div>
</div>
<div style="text-align: center; margin-top: 20px;">
    <a href="download_bill.php?type=csv" style="
        display: inline-block;
        background-color: #28a745;
        color: white;
        font-size: 16px;
        padding: 12px 20px;
        text-decoration: none;
        border-radius: 5px;
    ">Download as CSV</a>
</div>

</div>


</body>
</html>
