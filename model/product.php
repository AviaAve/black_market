<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 07.04.19
 * Time: 16:42
 */

require_once "model/connection/AbstractDbConnection.php";

class ProductModel
{
    protected $db;

    public function setConnection(AbstractDbConnection $dbConnection) {
        $this->db = $dbConnection;
    }

    public function addProduct($product) {
        $query = "INSERT INTO product (`title`, `weight`, `price`, `old_price`, `img`, `start`, `end`) VALUES ('" . mb_convert_encoding(trim( addslashes( $product['title'] ) ), "UTF-8") . "', '" . addslashes($product['weight']) . "' ," . $product['price'] . "," . $product['old_price'] . ",'" . addslashes($product['img']) . "', '" . date("Y-m-d H:i:s", strtotime($product['start'])) . "', '" . date("Y-m-d H:i:s", strtotime($product['end'])) . "')";
        $this->db->query($query);

        $query = "SELECT MAX(`product_id`) FROM `product`;";
        $lastId = $this->db->query($query);

        if (!isset($product['categories']) || $product['categories'] != []){
            return;
        }
        $query = "INSERT INTO `product_to_category` (`product_id`, `category_id`) VALUES;";
        foreach ($product['categories'] as $category_id){
            $query .= "(". $category_id . ", " . $lastId . ")";
        }
        $query = str_replace(')(', "), )", $query);
        $this->db->query($query);
    }

    public function getAllProduct() {
        $query = "SELECT * FROM product;";
        return $this->db->query($query);
    }
}