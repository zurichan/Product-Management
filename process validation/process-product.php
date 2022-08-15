<?php

session_start();

date_default_timezone_set('Asia/Manila');

require_once '../includes/header.php';

require_once '../includes/classes.php';

require_once '../configures/database.php';

$product_instance = new Products();

/** ADD PRODUCT */

if(isset($_POST['add-product'])) {

    $date = date('Y-m-d h:i:s');

    $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);

    $product_price = filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_NUMBER_INT);

    $product_stocks = filter_input(INPUT_POST, 'product_stock', FILTER_SANITIZE_NUMBER_INT);

    $ext = array('jpg', 'jpeg', 'png');

    $file_name = $_FILES['productimg']['name'];

    $file_size = $_FILES['productimg']['size'];

    $file_tmp = $_FILES['productimg']['tmp_name'];

    $target_dir = "../images/{$file_name}";

    $file_ext = explode('.', $file_name);

    $file_ext = strtolower(end($file_ext));

    $add_product_error_count = 0;

    if (!in_array($file_ext, $ext)) {
        $add_product_error_count++;
    }

    if (!($file_size <= 1000000)) {
        $add_product_error_count++;
    }

    if($add_product_error_count == 0) {

        move_uploaded_file($file_tmp, $target_dir);

        $product_instance->products_crud($conn, 'create', [$product_name, $product_price, $target_dir, $product_stocks, $date]);

        $_SESSION['product-message'] = array(
            "title" => 'Product has been Added Successfully!',
            "body" => 'Register Date: ' . $date,
            "type" => 'success'
        );

    } else {

        $_SESSION['product-message'] = array(
            "title" => 'Invalid Product Images',
            "body" => 'Please check your image size and if contains: jpg, jpeg, and png extension',
            "type" => 'error'
        );

    }

    header('Location: ../products.php');

} else {

    header('Location: ../products.php');

}

/** DELETE PRODUCT */

if(isset($_POST['remove_product'])) {

    $product_instance->products_crud($conn, 'delete', [$_POST['product_id']]);

}

/** UPDATE PRODUCT */

if(isset($_POST['update-product'])) {

    $date = date('Y-m-d h:i:s');

    $update_product_name = filter_input(INPUT_POST, 'update_product_name', FILTER_SANITIZE_SPECIAL_CHARS);

    $update_product_price = filter_input(INPUT_POST, 'update_product_price', FILTER_SANITIZE_NUMBER_INT);

    $update_product_stocks = filter_input(INPUT_POST, 'update_product_stock', FILTER_SANITIZE_NUMBER_INT);

    $product_id =  filter_input(INPUT_POST, 'updating-product_id', FILTER_SANITIZE_NUMBER_INT);

    $product_instance->products_crud($conn, 'update', [$update_product_name, $update_product_price, $update_product_stocks, $date, $product_id]);

    $_SESSION['product-message'] = array(
        "title" => 'Product has been Updated',
        "body" => 'Updated Date: ' . $date,
        "type" => 'success'
    );

    header('Location: ../products.php');

} else {
    echo 'zxc';
}