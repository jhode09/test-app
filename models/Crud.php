<?php 

if($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'])) {        
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    die( header( 'location: /corporatekeys-exam/403.php' ) );
}

include_once ('../config/connection.php');
   
class Crud extends Connection 
{ 
    public $column = ""; 
    public $value  = "";

    public function __construct() { 
        parent::__construct();        
    }
             
    public function selectAll($table) {
        $sql  = "SELECT * FROM " . $table;
        $data = $this->connection->query($sql);
        return $data->fetch_all(MYSQLI_ASSOC);
    }

    public function selectAllByColumn($table, $column, $value, $id = null) {
        $sql  = "SELECT * FROM $table where $column LIKE '".$value."'";
        $sql .= ($id) ? " AND id != $id" : "";
        $data = $this->connection->query($sql);
        return $data->fetch_assoc();
    }
             
    public function selectByID($table, $id) {
        $sql  = "SELECT * FROM $table where id=$id";
        $data = $this->connection->query($sql);
        return $data->fetch_assoc();
    } 
             
    public function insert($table, $data) {
        $columns = implode(",", array_keys($data));
        $values = "'" . implode ( "', '", array_values($data)) . "'";
        $sql  = "INSERT INTO $table ($columns) VALUES ($values)";
        $data = $this->connection->query($sql);
    } 
             
    public function update($table, $data, $id) {
        foreach ($data as $key => $value) {
            $value = $this->escapeString($value);
            $value = "'$value'";
            $updates[] = "$key = $value";
        }
        $implodeArray = implode(', ', $updates);
        $sql = "UPDATE $table SET $implodeArray WHERE id=$id";
        $this->connection->query($sql);
    } 
             
    public function delete($table, $id) { 
        $delete = "DELETE FROM $table WHERE id=$id"; 
        $this->connection->query($delete);
    } 
             
    public function escapeString($value) { 
        return $this->connection->real_escape_string($value); 
    } 
             
}   
?>