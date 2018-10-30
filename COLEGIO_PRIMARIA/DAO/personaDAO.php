<?php
// DAO: Data Access Object - Objeto de Acceso a Datos

// nota ver si hay codigo en el netbeans
//BUSCA LA CARPETA Y LA CLASE PERSONA
require_once('../DAL/DBAccess.php');
require_once('../BOL/persona.php');

// ESTA ES LA CLASE PERSONA
class PersonaDAO
{
	//VARIABLES
	private $pdo;

	//SE REALIZA UNA FUNCION PUBLICA PARA EL CONSTRUCTOR
	public function __CONSTRUCT()
	{
			$dba = new DBAccess();
			$this->pdo = $dba->get_connection(); // OBTIENE LA CONEXION
	}

	// ESTA FUNCION REGISTRA A LAS PERSONAS 
	public function Registrar_per(Persona $persona)
	{
		try
		{ // LLAMA AL PROCEDIMIENTO MEDIANTE LA CONEXION QUE SE HA OBTENIDO EN LA FUNCION CONSTRUCTOR
		$statement = $this->pdo->prepare("CALL PRO_REGISTRAR_PERSONAS (?, ?, ?, ?, ?, ?, ?, ?, ?)"); 

		$statement->bindParam(1,$persona->__GET('APE_PATERNO'));
		$statement->bindParam(2,$persona->__GET('APE_MATERNO'));
		$statement->bindParam(3,$persona->__GET('NOMBRES'));
		$statement->bindParam(4,$persona->__GET('SEXO'));
		$statement->bindParam(5,$persona->__GET('ESTADO_CIVIL'));
		$statement->bindParam(6,$persona->__GET('FECHA_NAC'));
		$statement->bindParam(7,$persona->__GET('DIRECCION'));
		$statement->bindParam(8,$persona->__GET('TELEFONO'));
		$statement->bindParam(9,$persona->__GET('CORREO'));

        $statement -> execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}




	//ESTA FUNCION LISTA A LAS PERSONAS QUE ESTAN DENTRO DEL REGISTRO
	public function Listar_per(Persona $persona)
	{
		try
		{   // CREAMOS UNA VARIABLE PARA ALMACENAR EL REGISTRO MEDIANTE UN ARREGLO
			$result = array();

			// LLAMA AL PROCEDIMIENTO MEDIANTE LA CONEXION QUE SE HA OBTENIDO EN LA FUNCION CONSTRUCTOR
			//$statement = $this->pdo->prepare("CALL PRO_BUSCAR_PERSONA(?)");
			$statement = $this->pdo->prepare("CALL PRO_LISTAR_PERSONAS()");

			//$statement->bindParam(1,$persona->__GET('COD_PERSONA'));
			$statement->execute();

			// ESTE BUCLE COMENZARA A MOSTRAR LOS RESESULTADOS DE FORMA ORDENADA LOS REGISTROS
			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $rr)
			{    
				// CREAMOS UNA VARIABLE PARA ALMACENAR EL REGISTRO MEDIANTE UN ARREGLO
				$per = new Persona();

				$per->__SET('APE_PATERNO',   $rr->APE_PATERNO);
				$per->__SET('APE_MATERNO',   $rr->APE_MATERNO);
				$per->__SET('NOMBRES',       $rr->NOMBRES);				

				// LA VARIABLE RESULT ALMACENA LOS REGISTROS OBTENIDOS
				$result[] = $per;
			}

			// RETORNA LOS REGISTROS QUE SE HAN OBTENIDO EN EL BUCLE	
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	//BUSCAR PERSONA POR CODIGO
	public function Buscar_per(Persona $persona)
	{
		try
		{
			$result = array();

			$statement = $this->pdo->prepare("CALL PRO_BUSCAR_PERSONAS(?)");
			$statement->bindParam(1,$persona->__GET('COD_PERSONA'));
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$per = new Persona();

				$per->__SET('COD_PERSONA', $r->COD_PERSONA);
				$per->__SET('APE_PATERNO', $r->APE_PATERNO);
				$per->__SET('APE_MATERNO', $r->APE_MATERNO);
				$per->__SET('NOMBRES',     $r->NOMBRES);

				$result[] = $per;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}



}

?>
