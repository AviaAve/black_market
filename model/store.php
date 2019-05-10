<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 07.04.19
 * Time: 16:43
 */

class storeModel
{
    protected $db;

    public function setConnection(AbstractDbConnection $dbConnection) {
        $this->db = $dbConnection;
    }

    public function getDeliveryNetworks() {
        $sql  = "SELECT * FROM delivery_network dn LEFT JOIN shop s  ON (dn.delivery_network_id = s.delivery_network_id);";
        $networkFromDb = $this->db->query($sql);
        $deliveryNetworks = [];

        foreach ($networkFromDb as $network) {
            $deliveryNetworks[ $network['delivery_network_id'] ] = $network;
        }

        return $deliveryNetworks;
    }

    public function getDeliveryNetworksRight() {
        $sql  = "SELECT * FROM shop dn LEFT JOIN delivery_network s  ON (dn.delivery_network_id = s.delivery_network_id);";
        return $this->db->query($sql);
    }

    public function delete() {
        $sql = "DELETE FROM shop;";
        $this->db->query($sql);
    }

    public function add($shopParameter, $deliveryNetworkId) {
        $sql = "INSERT INTO shop (adress, delivery_network_id, lat, lng) VALUES ('" . $shopParameter['address'] . "', " . $deliveryNetworkId . ", " . $shopParameter['lat'] . ", " . $shopParameter['lng'] . ");";
        $this->db->query($sql);
    }
}