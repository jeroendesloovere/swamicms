<?php

/**
 * DB PDO Driver For Dingo Framework DB Library
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 */
load::driver('db','pdo');
class mysqliDbConnection extends pdoDbConnection
{
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($driver,$host,$username,$password,$database)
	{
		$this->driver = $driver;
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		
		try
		{
			$this->con = new mysqli($this->host, $this->username, $this->password, $this->database);
	
			// check connection
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		catch(Exception $e)
		{	
			dingoError(E_USER_ERROR,'DB Connection Failed. '.$e->getMessage());
		}
	}
	
	
	// Query
	// ---------------------------------------------------------------------------
	public function query($sql,$orm=FALSE)
	{
		// If SQL statement is a SELECT statement
		if(preg_match('/^SELECT/is',$sql))
		{
			$res = $this->con->query($sql);
			
			$this->last_result = array();
			
			// Cycle through results
			if($orm)
			{
				load::ormClass($orm);
				while($row = $res->fetch_object($orm.'_orm'))
				{
					$this->last_result[] = $row;
				}
			}
			else
			{
				if(!empty($res))
				{
					while($row = $res->fetch_object('dingo'))
					{
						$this->last_result[] = $row;
					}
				}
			}
		}
		
		// Any other kind of statement
		else
		{
			$this->last_result = $this->con->query($sql);
		}
		
		return $this->last_result;
	}
	
	
	// Select Table
	// ---------------------------------------------------------------------------
	public function table($table)
	{
		$t = new mysqliDbTable($table);
		$t->db = $this;
		$t->name = $table;
		
		return $t;
	}
	
	// Clean
	// ---------------------------------------------------------------------------
	public function clean($data)
	{
		return substr(self::quote($data),1,-1);
	}
	
	
	// TODO - try to establish the comment below
	/*
		PDO::quote() places quotes around the input string (if required) and escapes special characters within the input string, using a quoting style appropriate to the underlying driver.

If you are using this function to build SQL statements, you are strongly recommended to use PDO::prepare() to prepare SQL statements with bound parameters instead of using PDO::quote() to interpolate user input into an SQL statement. Prepared statements with bound parameters are not only more portable, more convenient, immune to SQL injection, but are often much faster to execute than interpolated queries, as both the server and client side can cache a compiled form of the query. 
	*/
	// Quote
	// ---------------------------------------------------------------------------
	public function quote($data)
	{
	echo "hier niet";
		$tick = DingoSQL::backtick();
		return $tick.$data.$tick;
	}
}



/**
 * DB Table Class For Dingo Framework DB Library
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 */

class mysqliDbTable extends pdoDbTable{}