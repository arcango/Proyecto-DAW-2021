<?php


class Conexion {

	private $connection;
	private $dataBase;
	private $host = "localhost";
	private $user = "root";
	private $password="";
	public $returnData;          
	
	
	/**
	 * El constructor recibe la base de datos y se conecta con los datos de las variables
	 * de la clase.
	 */

	public function __construct($db) {
	
	try {

		$this->dataBase=$db;
		$this->connection = new PDO("mysql:host=$this->host;dbname=$this->dataBase",$this->user,$this->password);
		$this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		$this->connection->exec("set names utf8mb4");
		
		} catch (PDOException $e) {  
			echo "  <p>Error: No se pudo conectar s la base de datos.</p>\n\n";
			echo "  <p>Error: " . $e->getMessage() . "</p>\n";
			
			exit();
		}
	}

	/**
	 * Consultas que no devuelven datos.
	 * En caso de error, devuelve mensaje de error.
	 */
	public function SimpleQuery($query,$parameter) {
		
		$statement=$this->connection->prepare($query);			
		
		if	(!$statement->execute($parameter) ) {
			echo " <p>Eror en la consulta<p>\n";
		} 
	}

	/**
	 * Consultas que devuelven datos
	 * Creamos la conexión, limpiamos el array y ejecutamos la consulta.
	 * Devuelve el array con los datos de la consulta.
	 * En caso de error, devuelve un mensaje de error.
	 */
	public function Query($query,$parameter)             
	{
		
		$statement=$this->connection->prepare($query);
		
		$this->returnData=array();              
		
		if ($statement->execute($parameter)) {
		
			while( $row=$statement->fetch()) {
				$this->returnData[]=$row;	
			}

		} else {
		
			echo "  <p>Error en la consulta<p>\n";	
			
		}	 	
	} 

	/**
	 * Cierra la conexión con la base de datos.
	 */
	public function CloseConnection() {

		$this->connection= null ;
	
	}
	
	/**
	 * Cerramos la conexión al liberar el objeto de la memoria.
	 */
	public function __destruct() {

		$this->CloseConnection();
		
	}

}
