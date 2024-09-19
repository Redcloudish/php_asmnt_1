<?php
    require_once('database.php');

    // Get the product ID
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    // Get product details from the database
    $query = 'SELECT * FROM products WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $product = $statement->fetch();
    $statement->closeCursor();

    // Get all categories from the database
    $query = 'SELECT * FROM categories ORDER BY categoryID';
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
    $statement->closeCursor();

    // If product ID is invalid, show an error
    if ($product == false) {
        $error = "Invalid product ID.";
        include('error.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="main.css"/>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="update_product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

        <!-- Drop-down list for Category -->
        <label>Category:</label>
        <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>"
                    <?php if ($category['categoryID'] == $product['categoryID']) echo 'selected'; ?>>
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Product Code:</label>
        <input type="text" name="code" value="<?php echo $product['productCode']; ?>"><br>

        <label>Product Name:</label>
        <input type="text" name="name" value="<?php echo $product['productName']; ?>"><br>

        <label>List Price:</label>
        <input type="text" name="price" value="<?php echo $product['listPrice']; ?>"><br>

        <input type="submit" value="Update Product">
    </form>
</body>
</html>
