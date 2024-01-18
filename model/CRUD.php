<?php

abstract class CRUD extends PDO {

    public function __construct(){
        //parent::__construct('mysql:host=localhost; dbname=e2395496; port=3306; charset=utf8', 'e2395496', '32fEWjU4cTBDn03DWq9Y');
        parent::__construct('mysql:host=localhost; dbname=stampee; port=3306; charset=utf8', 'root', 'root');

    }

    public function select($field='id', $order='ASC'){
        $sql="SELECT * FROM $this->table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function selectId($value){
        $sql="SELECT * FROM $this->table WHERE $this->primaryKey = '$value'";
        $stmt = $this->query($sql);
        $count = $stmt->rowCount();

        if($count == 1){
            return $stmt->fetch();
        }else{
          RequirePage::url('home/error/404');
        }  
    }

    public function insert($data){

        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);

        $nomChamp = implode(", ",array_keys($data));
        $valeurChamp = ":".implode(", :", array_keys($data));

        $sql = "INSERT INTO $this->table ($nomChamp) VALUES ($valeurChamp)";

        $stmt = $this->prepare($sql);
        foreach($data as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $this->lastInsertId();

    }

    public function delete($value){

        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        if($stmt->execute()){
            return true;
        }else{
            return $stmt->errorInfo();
        }
    }


    public function update($data){
  
        $queryField = null;
        foreach($data as $key=>$value){
            $queryField .="$key =:$key, ";
        }
        $queryField = rtrim($queryField, ", ");
        
        $sql = "UPDATE $this->table SET $queryField WHERE $this->primaryKey = :$this->primaryKey";
        
        $stmt = $this->prepare($sql);
        foreach($data as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":$this->primaryKey", $data[$this->primaryKey]);
    
        if($stmt->execute()){
            return true;
        }else{
            return $stmt->errorInfo();
        }
    }
    


}


?>