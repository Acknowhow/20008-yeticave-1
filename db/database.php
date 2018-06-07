<?php
class Database
{
    private $db_resource;
    private $last_error = null;
    private $last_result;

    public function __construct($host, $login, $password, $db)
    {
        $this->db_resource = mysqli_connect($host, $login, $password, $db);
        mysqli_set_charset($this->db_resource, 'utf-8');

        if (!$this->db_resource) {
            $this->last_error = mysqli_connect_error();
        }
    }

    public function exec

    public function select_data_column($sql, $data, $columnName)
    {
        // Maybe omit this line later
        $this->last_error = null;

        $arr = [];
        $res = '';
        $stmt = db_get_prepare_stmt($this->db_resource, $sql, $data);

        if (mysqli_stmt_execute($stmt) &&
            $result = mysqli_stmt_get_result($stmt)) {

            while ($row = mysqli_fetch_array($result)) {
                $arr[] = $row[$columnName];
            };

            $this->last_result = $arr;
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
}
