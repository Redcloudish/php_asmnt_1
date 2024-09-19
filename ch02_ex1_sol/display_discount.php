<?php
// Input and validation
$product_description = filter_input(INPUT_POST, 'product_description');
$list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
$discount_percent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);

// Check for valid data
if ($list_price === false || $list_price <= 0) {
    $error_message = "Please enter a valid list price.";
} elseif ($discount_percent === false || $discount_percent < 0 || $discount_percent > 100) {
    $error_message = "Please enter a valid discount percent (0-100).";
} else {
    // Calculate the discount
    $discount = $list_price * $discount_percent * .01;
    $discount_price = $list_price - $discount;
    
    // Sales tax calculation
    $sales_tax_rate = 8; // 8% sales tax
    $sales_tax = $discount_price * ($sales_tax_rate / 100);
    $sales_total = $discount_price + $sales_tax;

    // Format the output
    $list_price_f = "$".number_format($list_price, 2);
    $discount_percent_f = $discount_percent."%";
    $discount_f = "$".number_format($discount, 2);
    $discount_price_f = "$".number_format($discount_price, 2);
    $sales_tax_f = "$".number_format($sales_tax, 2);
    $sales_total_f = "$".number_format($sales_total, 2);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Product Discount Calculator</h1>

        <?php if (!empty($error_message)) : ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php else : ?>
            <label>Product Description:</label>
            <span><?php echo htmlspecialchars($product_description); ?></span><br>

            <label>List Price:</label>
            <span><?php echo $list_price_f; ?></span><br>

            <label>Discount Percent:</label>
            <span><?php echo $discount_percent_f; ?></span><br>

            <label>Discount Amount:</label>
            <span><?php echo $discount_f; ?></span><br>

            <label>Discount Price:</label>
            <span><?php echo $discount_price_f; ?></span><br>

            <label>Sales Tax Rate:</label>
            <span>8%</span><br>

            <label>Sales Tax Amount:</label>
            <span><?php echo $sales_tax_f; ?></span><br>

            <label>Sales Total:</label>
            <span><?php echo $sales_total_f; ?></span><br>
        <?php endif; ?>
    </main>
</body>
</html>
