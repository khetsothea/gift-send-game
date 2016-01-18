<?php

Class  Database{

public function __construct($config){

	 try
        {
            $this->pdo = new PDO("mysql:host=".$config['db']['host'].";dbname=".$config['db']['database'].";charset=utf8", 
			$config['db']['username'], $config['db']['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
	}
		/**
       *  Select record
       *  @return array
       */
public function select($query, $fetch_one=false){
	
	
	$this->stmt = $this->pdo->prepare($query);
	$this->stmt->execute();
	if($this->stmt->rowCount() > 0)
          {
	if(!$fetch_one) 
		return $this->stmt->fetchAll();
	else 
		return $this->stmt->fetchAll();
		}
}

		/**
       *  Returns the last inserted id.
       *  @return int
       */
public function insert($table, $array){

	
		$columns = implode(", ", array_keys($array));
		
		$values  = array_values($array);
		
		$valCount = count($values);
		
		$str = '?';
		
		$str .= str_repeat(", ?", $valCount-1);
		
		$sql = "INSERT INTO ".$table."(".$columns.") VALUES (".$str.")";
		
		$results = $this->pdo->prepare($sql); 
	    try { 
	        $results->execute($values);
	        return $this->pdo->lastInsertId($table); 
	    } catch(PDOException $e) { 
	        return  $e->getMessage(); 
	    } 
		
	}
	
	   /**
       *  Update
       *  @return boelan
       */
	   
public function update($table, $array, $where){

	
		$columns = array_keys($array);
		$values = array_values($array);
		$sqlString = "";
		for($i=0;$i<count($columns);$i++){
			if($i==count($columns)-1){
				$sqlString .= $columns[$i]." = '".$values[$i]."' ";
			}else{
				$sqlString .= $columns[$i]." = '".$values[$i]."', ";
			}
		}
		$sql = "UPDATE ".$table." SET ".$sqlString." WHERE " . $where;
		$update = $this->pdo->query($sql);
		
        if ($update) {
            return true;
        } else {
            return false;
        }		
		
}

    	/**
       *  Returns the last inserted id.
       *  @return string
       */	
		public function lastInsertId() {
			return $this->pdo->lastInsertId();
		}	


}