<?php
include 'db.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $name = $_GET['delete'];
    $conn->query("DELETE FROM menu WHERE name = '$name'");
    header("Location: view_menu.php");
    exit();
}

// Handle price update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_price'])) {
    $name = $_POST['name'];
    $new_price = $_POST['price'];
    $conn->query("UPDATE menu SET price = '$new_price' WHERE name = '$name'");
    header("Location: view_menu.php");
    exit();
}

// Fetch menu items
$query = "SELECT m.name, m.price, f.image 
          FROM menu m 
          JOIN food_items f ON m.name = f.name";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Menu</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 30px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .menu-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            text-align: center;
            overflow: hidden;
            padding-bottom: 10px;
        }

        .menu-item img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .info {
            padding: 10px;
        }

        .name {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }

        .price {
            color: #28a745;
            font-size: 14px;
        }

        .actions {
            margin-top: 10px;
        }

        .actions form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .actions input[type="number"] {
            width: 80px;
            padding: 5px;
            margin-bottom: 5px;
        }

        .actions button,
        .actions a {
            margin-top: 3px;
            padding: 5px 10px;
            font-size: 13px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .actions button {
            background-color: #ffc107;
            color: white;
        }

        .actions a {
            background-color: #dc3545;
            color: white;
        }

        .actions button:hover {
            background-color: #e0a800;
        }

        .actions a:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Current Menu</h2>
    <div class="menu-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="menu-item">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <div class="info">
                    <div class="name"><?php echo $row['name']; ?></div>
                    <div class="price">₹<?php echo $row['price']; ?></div>
                    <div class="actions">
                        <!-- Edit price form -->
                        <form method="POST" action="view_menu.php">
                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                            <input type="number" name="price" value="<?php echo $row['price']; ?>" min="0" step="1">
                            <button type="submit" name="update_price">Update</button>
                        </form>

                        <!-- Delete button -->
                        <a href="view_menu.php?delete=<?php echo urlencode($row['name']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    </div>

<div style="text-align: center; margin-top: 30px;">
    <a href="bill_summary.php" style="
        display: inline-block;
        background-color: #007bff;
        color: white;
        font-size: 16px;
        padding: 12px 20px;
        text-decoration: none;
        border-radius: 5px;
    ">View Total Bill</a>
</div>

</div>

</div>

</body>
</html>
