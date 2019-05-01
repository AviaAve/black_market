<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 07.04.19
 * Time: 16:43
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 9000);
class category
{
    protected $db;

    public function setConnection(AbstractDbConnection $dbConnection) {
        $this->db = $dbConnection;
    }

    public function getCategories() {
        $query = "SELECT * FROM category RIGHT JOIN category_keywords ON (category.category_id = category_keywords.category_id);";
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        $test = $this->db->query($query);
        echo "<pre>";
        print_r("fuck 5");
        echo "</pre>";
        return $test;
    }

    public function getCategoryByID($id)
    {
        $query = "SELECT * FROM `category` `c` LEFT JOIN `category_keywords` `c_key` on (`c.cateogry_id` = `c_key.category_id`)  where `c.category_id` = " . $id . ";";
        return $this->db->query($query);
    }

    /**
     * @return mixed
     */
    public function getCategoriesByParentID($parent_id)
    {
        $query = "SELECT * FROM `category` `c` LEFT  JOIN `category_keywords` `ck` ON(c.category_id = ck.category_id) where `c.parent_id` = " . $parent_id . ";";
        return $this->db->query($query);
    }

    public function addCategory($parameters)
    {
        $query = "INSERT INTO `category` (`parent_id`, `name`, `description`, `img`) VALUES (" . $parameters['parent_id'] . ", '" . $parameters['name'] . "', '" . $parameters['description'] . "', '" . $parameters['img'] . "')";
        $this->db->query($query);

        $query = "INSERT INTO `category_keywords` (`category_id`, `keywords`) VALUES ((SELECT `cateogory_id` FROM `category` WHERE `name` = '" . $parameters['name'] . "')," . $parameters['keywords'] . ");";
        $this->db->query($query);
    }

    public function deleteCategory(array $ids)
    {
        if(!ids)
            return;

        $query = "DELETE FROM `category` where `category_id` in(" . implode(", ", $ids) . ");";
        $this->db->query($query);

        $query = "DELETE FROM `category_keywords` where `category_id` in(" . implode(", ", $ids) . ");";
        $this->db->query($query);
    }
}