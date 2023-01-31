<?php
namespace app\model\dao\sql;

class SqlBuilder {

    private string $dataBase;
    private string $type;
    private string $sql;

    public static function build() {        
        return new SqlBuilder();
    }

    public function DATABASE($database) {
        $this->dataBase = $database;
        return $this;
    }

    public function getSql() {
        if (isset($this->sql)) {
            return $this->sql;
        }
        return "";
    }

    public function SELECT() {
        $this->type = "SELECT ";
        $this->sql = $this->type;
        return $this;
    }

    public function UPDATE(string $table) {
        $this->type = "UPDATE $this->dataBase.$table SET ";
        $this->sql = $this->type;
        return $this;
    }

    public function INSERT(string $table) {
        $this->type = "INSERT INTO $this->dataBase.$table (";
        $this->sql = $this->type;
        return $this;
    }

    public function INSERTVALUES(string $values) {        
        $this->sql .= "VALUES ($values) ";
        $this->sql = str_replace(", VALUES", ") VALUES", $this->sql);
        return $this;
    }

    public function addColum(string $colum) {
        $this->sql .= "$colum, ";
        return $this;
    }

    public function FROM(string $table) {
        if(strstr($table, 'FROM') === false) {
            $this->sql .= "FROM ";
        }

        $this->sql = str_replace(", FROM", " FROM", $this->sql);

        $this->sql .= "$this->dataBase.$table ";
        return $this;
    }

    public function INNERJOIN(string $table) {
        $this->sql .= "INNER JOIN $this->dataBase.$table ";
        return $this;
    }

    public function LEFTJOIN(string $table) {
        $this->sql .= "LEFT JOIN $this->dataBase.$table ";
        return $this;
    }

    public function RIGHTJOIN(string $table) {
        $this->sql .= "RIGHT JOIN $this->dataBase.$table ";
        return $this;
    }

    public function ON(string $condition) {
        $this->sql .= "ON $condition ";
        return $this;
    }

    public function WHERE(string $condition) {
        $this->sql .= "WHERE $condition ";
        $this->sql = str_replace(", WHERE", " WHERE", $this->sql);
        return $this;
    }
    
    public function AND(string $condition) {
        $this->sql .= " AND $condition ";
        return $this;
    }

    public function ORDERBY(string $orderby) {
        $this->sql .= "ORDER BY $orderby ";
        return $this;
    }
}