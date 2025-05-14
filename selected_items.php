<?php
session_start(); // Start session to access selected items

// Check if session has selected items
if (!isset($_SESSION['selected_items']) || count($_SESSION['selected_items']) == 0) {
    header("Location: menu_add.php"); // Redirect to the menu add page if no items are selected
    exit();
}

$selected_items = $_SESSION['selected_items']; // Get selected items from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selected Menu Items</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .selected-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .selected-item {
            background-color: #fafafa;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .selected-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .selected-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .selected-item .details {
            padding: 10px;
            text-align: center;
        }

        .food-name {
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        .food-price {
            font-size: 14px;
            color: #555;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Selected Menu Items</h2>

    <div class="selected-items">
        <?php foreach ($selected_items as $item) { ?>
            <div class="selected-item">
                <img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                <div class="details">
                    <div class="food-name"><?php echo $item['name']; ?></div>
                    <div class="food-price">₹<?php echo $item['price']; ?></div>
                </div>
            </div>
        <?php } ?>
    </div>

    <a href="menu_add.php" class="back-button">Go Back to Menu</a>
</div>

</body>
</html>
