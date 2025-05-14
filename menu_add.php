<?php
include 'db.php';

// Fetch food items
$query = "SELECT id, name, image, price FROM food_items";
$result = $conn->query($query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['items'])) {
    $selected_items = $_POST['items'];

    foreach ($selected_items as $item_id) {
        // Check if already in the menu
        $check = $conn->query("SELECT name FROM food_items WHERE id = $item_id");
        $food = $check->fetch_assoc();
        $food_name = $food['name'];

        $existing = $conn->query("SELECT * FROM menu WHERE name = '$food_name'");
        if ($existing->num_rows == 0) {
            $res = $conn->query("SELECT name, price FROM food_items WHERE id = $item_id");
            $item = $res->fetch_assoc();
            $name = $item['name'];
            $price = $item['price'];

            $conn->query("INSERT INTO menu (name, price) VALUES ('$name', '$price')");
        }
    }

    header("Location: view_menu.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Items</title>
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

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .gallery-item {
            background-color: #fafafa;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .gallery-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .gallery-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .gallery-item .details {
            padding: 10px;
            text-align: center;
        }

        .gallery-item .details input[type="checkbox"] {
            margin-bottom: 8px;
        }

        .form-group input[type="submit"] {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-group input[type="submit"]:hover {
            background-color: #218838;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Select Food Items and Add to Menu</h2>

    <form action="menu_add.php" method="POST">
        <div class="gallery">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="gallery-item">
                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <div class="details">
                        <input type="checkbox" name="items[]" value="<?php echo $row['id']; ?>">
                        <div class="food-name"><?php echo $row['name']; ?></div>
                        <div class="food-price">₹<?php echo $row['price']; ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <input type="submit" value="Add Selected Items to Menu">
        </div>
    </form>
</div>

</body>
</html> 