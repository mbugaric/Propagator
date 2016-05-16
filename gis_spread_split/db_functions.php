<?php

class db_func
{
	private $dbconn;
	public $dbname="AdriaFirePropagator";
	private $username="postgres";
	private $password="AdriaDB4prop";
	
	
	public function connect()
	{
		$this->dbconn = pg_connect("host=localhost dbname=".$this->dbname." user=".$this->username." password=".$this->password)
			or die('Could not connect to the database: ' . pg_last_error());
	}
	
	public function disconnect()
	{
		
		pg_close($this->dbconn);
		
	}
	
	public function query($query)
	{
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		return $result;
	}
	
	
	
	
	
	
}
?>