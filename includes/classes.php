<?php

date_default_timezone_set('Asia/Manila');

/** CLASSES FOR MANAGING DATA AT DATABASE */

class Products
{
    public function get_products($connection)
    {

        $get_products_query = "SELECT * FROM `products`";

        $get_products_stmt = $connection->prepare($get_products_query);

        $get_products_stmt->execute();

        $all_products = $get_products_stmt->fetchAll();

        return $all_products;

    }

    public function products_crud($connection, string $type, array $values)
    {

        switch ($type) {

            case 'create':

                $insert_product_query = "INSERT INTO `products` (`product_name`, `product_price`, `product_img`, `stocks`, `modified_at`) VALUES (:product_name, :product_price, :product_img, :stocks, :modified_at)";

                $insert_product_stmt = $connection->prepare($insert_product_query);

                $insert_product_stmt->execute([
                    'product_name' => $values[0],
                    'product_price' => $values[1],
                    'product_img' => $values[2],
                    'stocks' => $values[3],
                    'modified_at' => $values[4]
                ]);

                echo 'success';

                break;

            case 'delete':

                $delete_product_query = "DELETE FROM `products` WHERE `product_id` = :product_id";

                $delete_product_stmt = $connection->prepare($delete_product_query);

                $delete_product_stmt->execute([
                    'product_id' => $values[0]
                ]);

                echo 'success';

                break;

            case 'update':

                $update_product_query = "UPDATE `products` SET `product_name` = :product_name, `product_price` = :product_price, `stocks` = :stocks, `modified_at` = :modified_at WHERE `product_id` = :product_id";

                $update_product_stmt = $connection->prepare($update_product_query);

                $update_product_stmt->execute([
                    'product_name' => $values[0],
                    'product_price' => $values[1],
                    'stocks' => $values[2],
                    'modified_at' => $values[3],
                    'product_id' => $values[4]
                ]);

                echo 'success';

                break;

            default:
                echo 'Invalid';
        }
    }
}
