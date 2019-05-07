<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 07.05.19
 * Time: 19:16
 */

require_once "model/store.php";

class StoreDataController
{
    private $storeModel;
    private $deliveryNetworkId;

    public function modelInit(AbstractDbConnection $dbConnection)
    {
        $this->storeModel = new storeModel();
        $this->storeModel->setConnection($dbConnection);

    }

    public function add($stores, $deliveryNetworkName) {
        $this->setDeliveryNetworkId($deliveryNetworkName);

        foreach ($stores as $store) {
            $this->storeModel->add($store, $this->deliveryNetworkId);
        }
    }

    public function delete() {
        $this->storeModel->delete();
    }

    public function setDeliveryNetworkId($deliveryNetworkName) {
        foreach ($this->storeModel->getDeliveryNetworks() as $network) {
            if ($network['name'] == $deliveryNetworkName)
                $this->deliveryNetworkId = $network['delivery_network_id'];
        }
    }
}