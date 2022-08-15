<?php

session_start();

date_default_timezone_set('Asia/Manila');

require_once './includes/header.php';

require_once './includes/classes.php';

require_once './configures/database.php';

$product_instance = new Products();

$all_products = $product_instance->get_products($conn);

$date = date('Y-m-d h:i:s');

?>

<main class="container mt-4">
    <table class="table table-bordered caption-top table-striped mt-4">
        <div class="d-flex flex-row justify-content-center align-items-center">
            <caption>List of Products</caption>
            <button type="button" class="btn btn-primary me-2" id="add-product-btn" data-bs-toggle="modal" data-bs-target="#add-product">
                Add Product
            </button>
        </div>

        <thead class="text-center">
            <tr>
                <th>#</th>
                <th>Product_ID</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stocks</th>
                <th>Modified Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">

            <?php

            $indexes = 1;

            foreach ($all_products as $products) :

            ?>

                <tr class="vertical-align" id="<?= $indexes; ?>">
                    <td><?= $indexes; ?>.</td>
                    <td class="product_id" data-target="product_id"><?= $products->product_id; ?></td>
                    <td class="" data-target="product_image"><img src="<?= $products->product_img; ?>" class="product_image img-fluid" alt="product image"></td>
                    <td class="product_name" data-target="product_name"><?= $products->product_name; ?></td>
                    <td class="" data-target="product_price">₱<?= $products->product_price; ?>.00</td>
                    <td class="" data-target="product_stocks"><?= $products->stocks; ?></td>
                    <td><?= $products->modified_at; ?></td>
                    <td>
                        <a href="#" data-role="update" data-id="<?= $indexes; ?>" class="update-product btn btn-sm btn-primary">update</a>
                        <button type="button" class="remove-product btn btn-sm btn-danger">remove</button>
                    </td>
                </tr>

            <?php
                $indexes++;

            endforeach;
            ?>
        </tbody>
    </table>
</main>


<!-- Update Product Modal -->
<div class="modal fade" id="update-product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" method="POST" action="../process validation/process-product.php" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Product: <input type="number" class="form-control" name="updating-product_id" id="updating-product_id" required readonly></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
               
                <label class="form-label" for="update_product_name">Update Product Name:</label>
                <input type="text" class="form-control mb-5" name="update_product_name" id="update_product_name" required>

                <label class="form-label" for="update_product_stock">Update Product Stock:</label>
                <input type="number" class="form-control mb-5" name="update_product_stock" id="update_product_stock" required>

                <label class="form-label" for="update_product_price">Update Product Price (₱):</label>
                <input type="number" class="form-control mb-5" name="update_product_price" id="update_product_price" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="update-product" name="update-product" class="btn btn-primary">Update Product</button>
            </div>

        </form>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="add-product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" method="POST" action="../process validation/process-product.php" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
               
                <label class="form-label" for="product_name">Product Name:</label>
                <input type="text" class="form-control mb-5" name="product_name" id="product_name" required>

                <div class="mb-5">
                    <label for="productimg">Product Image: </label>
                    <input type="file" class="form-control" name="productimg" id="productimg" required>
                    <span class="opacity-50">Select Image with valid Extensions: JPG, JPEG, PNG</span>
                    <div class="container-img"></div>
                </div>

                <label class="form-label" for="product_stock">Product Stock:</label>
                <input type="number" class="form-control mb-5" name="product_stock" id="product_stock" required>

                <label class="form-label" for="product_price">Product Price (₱):</label>
                <input type="number" class="form-control mb-5" name="product_price" id="product_price" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="add-product" name="add-product" class="btn btn-primary">Add Product</button>
            </div>

        </form>
    </div>
</div>

<?php

require_once './includes/footer.php';

?>

<?php if (isset($_SESSION['product-message'])) : ?>

    <script>
        swal(
            "<?= $_SESSION['product-message']['title']; ?>",
            "<?= $_SESSION['product-message']['body']; ?>",
            "<?= $_SESSION['product-message']['type']; ?>"
        );
    </script>

<?php 

endif;

unset($_SESSION['product-message']);

?>