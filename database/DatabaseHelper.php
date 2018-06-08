<?php
class DatabaseHelper
{
    private $db_resource;
    private $last_error = null;
    private $last_result;

    public function __construct($host, $login, $password, $db)
    {
        $this->db_resource = mysqli_connect($host, $login, $password, $db);
        mysqli_set_charset($this->db_resource, 'utf8');

        if (!$this->db_resource) {
            $this->last_error = mysqli_connect_error();
        }
    }

    public function executeQuery($sql, $data = []) {
        // Maybe omit this line later
        $this->last_error = null;
        $stmt = db_get_prepare_stmt($this->db_resource, $sql, $data);

        if (mysqli_stmt_execute($stmt) &&
            $result = mysqli_stmt_get_result($stmt)) {

            $this->last_result = $result;

            $res = true;

        } else {
            $this->last_error = mysqli_error($this->db_resource);
            $res = false;
        }

        return $res;
    }

    public function getLastError() {
        return $this->last_error;
    }

    public function getArrayByColumnName($columnName) {
        $arr = [];

        while ($row = mysqli_fetch_assoc($this->last_result)) {
            $arr[] = $row[$columnName];
        };


        return $arr;
    }

    public function getAssocArray() {
        return mysqli_fetch_assoc($this->last_result);
    }

    public function getLastId() {
        return mysqli_insert_id($this->db_resource);
    }

}
