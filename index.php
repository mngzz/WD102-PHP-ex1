<?php
session_start(); 

if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [
        "Bearbrand" => 10,
        "Coffee"    => 12,
      
    ];
}

function addProduct(&$inventory, $product, $quantity) {
    if (!isset($inventory[$product])) {
        $inventory[$product] = intval($quantity);
    } else {
        echo "$product already exists.<br>";
    }
}

function updateProductQuantity(&$inventory, $product, $newquantity) {
    if (isset($inventory[$product])) {
        $inventory[$product] = intval($newquantity);
    } else {
        echo "$product does not exist.<br>";
    }
}

function removeProduct(&$inventory, $product) {
    if (isset($inventory[$product])) {
        unset($inventory[$product]);
    } else {
        echo "$product does not exist.<br>";
    }
}

function displayInventory(&$inventory) {
    foreach ($inventory as $product => $quantity) {
        echo "<tr>
                <td>" . ($product) . "</td>
                <td>" . intval($quantity) . "</td>
                <td>
                    <form method='get' style='display:inline;'>
                        <input type='hidden' name='action' value='edit'>
                        <input type='hidden' name='product' value='" . ($product) . "'>
                        <input type='number' name='newquantity' value='" . intval($quantity) . "' min='0' required>
                        <button type='submit'>Update</button>
                    </form>
                </td>
                <td>
                    <form method='get' style='display:inline;'>
                        <input type='hidden' name='action' value='remove'>
                        <input type='hidden' name='product' value='" . ($product) . "'>
                        <button type='submit'>Remove</button>
                    </form>
                </td>
              </tr>";
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $product = $_GET['product'] ?? '';
    $quantity = $_GET['quantity'] ?? '';
    $newquantity = $_GET['newquantity'] ?? '';

    switch ($action) {
        case 'add':
            if ($product && $quantity !== '') {
                addProduct($_SESSION['inventory'], $product, intval($quantity));
            }
            break;
        case 'edit':
            if ($product && $newquantity !== '') {
                updateProductQuantity($_SESSION['inventory'], $product, intval($newquantity));
            }
            break;
        case 'remove':
            if ($product) {
                removeProduct($_SESSION['inventory'], $product);
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
</head>
<body>

    <style>
        .container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>

    <div class="container">
        <h1>Inventory Management System</h1>
        <form method="GET">
            <input type="hidden" name="action" value="add">
            <label for="product">Product:</label>
            <input type="text" name="product" placeholder="Product name" required>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" placeholder="Quantity" min="0" required>
            <button type="submit">Add</button>
        </form>
            
        <table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php displayInventory($_SESSION['inventory']); ?>
            </tbody>
        </table>
    </div>
</body>
</html>
