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

    public function addProduct($product, $deliveryNetworkId) {
        $query = "INSERT INTO product (`title`, `weight`, `price`, `old_price`, `img`, `start`, `end`, `delivery_network_id`) VALUES ('" . mb_convert_encoding(trim( addslashes( $product['title'] ) ), "UTF-8") . "', '" . addslashes($product['weight']) . "' ," . $product['price'] . "," . $product['old_price'] . ",'" . addslashes($product['img']) . "', '" . date("Y-m-d H:i:s", strtotime($product['start'])) . "', '" . date("Y-m-d H:i:s", strtotime($product['end'])) . "', " . $deliveryNetworkId . ")";
        $this->db->query($query);

        $query = "SELECT MAX(`product_id`) FROM `product`;";
        $lastId = $this->db->query($query)[0]['MAX(`product_id`)'];

        if (!isset($product['categories']) || !$product['categories']){
            return;
        }

        $query = "INSERT INTO `product_to_category` (`product_id`, `category_id`) VALUES ";

        foreach ($product['categories'] as $category_id){
            $query .= "(". $category_id . ", " . $lastId . ")";
        }

        $query = str_replace(')(', "), (", $query);
        $this->db->query($query);
    }

    public function getAllProduct() {
        $query = "SELECT * FROM product p LEFT JOIN product_to_category pc ON(p.product_id = pc.product_id);";
        return $this->db->query($query);
    }

    public function delete() {
        $sql = "DELETE FROM product;";
        $this->db->query($sql);

        $sql = "DELETE FROM product_to_category;";
        $this->db->query($sql);
    }

    public function getDeliveryNetworks() {
        $sql  = "SELECT * FROM delivery_network;";
        $networkFromDb = $this->db->query($sql);
        $deliveryNetworks = [];

        foreach ($networkFromDb as $network) {
            $deliveryNetworks[ $network['delivery_network_id'] ] = $network;
        }

        return $deliveryNetworks;
    }
}