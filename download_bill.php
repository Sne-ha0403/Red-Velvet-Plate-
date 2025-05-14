<?php
include 'db.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'csv';

// Fetch menu items for the bill
$query = "SELECT name, price FROM menu";
$result = $conn->query($query);

// Prepare data
$items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['price'];
}

// Download as CSV
if ($type == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="bill_summary.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Food Item', 'Price (₹)']);

    foreach ($items as $item) {
        fputcsv($output, [$item['name'], $item['price']]);
    }

    // Adding the total to CSV
    fputcsv($output, ['Total', '₹' . number_format($total, 2)]);

    fclose($output);
    exit();
}


?>
