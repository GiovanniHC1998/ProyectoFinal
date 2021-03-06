<?php
// DAO: Data Access Object - Objeto de Acceso a Datos

//BUSCA LA CARPETA Y LA CLASE PERSONA
require_once('../DAL/DBAccess.php');
require_once('../BOL/docente.php');

// ESTA ES LA CLASE DOCENTE
class DocenteDAO
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
	public function Registrar_doc(Docente $docente)
	{
		try
		{// LLAMA AL PROCEDIMIENTO MEDIANTE LA CONEXION QUE SE HA OBTENIDO EN LA FUNCION CONSTRUCTOR
		$statement = $this->pdo->prepare("CALL PRO_REGISTRAR_DOCENTE (?,?, ?, ?, ?, ?, ?, ?)");
		$statement->bindParam(1,$docente->__GET('COD_PERSONA'));
		$statement->bindParam(2,$docente->__GET('CARGO'));
		$statement->bindParam(3,$docente->__GET('FUNCION'));
		$statement->bindParam(4,$docente->__GET('ESTADO'));
		$statement->bindParam(5,$docente->__GET('NIVEL_INSTRUCCION'));
		$statement->bindParam(6,$docente->__GET('CARRERA_PROFESIONAL'));
		$statement->bindParam(7,$docente->__GET('FECHA_INICIO'));
		$statement->bindParam(8,$docente->__GET('FECHA_FIN'));
	
        $statement -> execute();

		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	//ESTA FUNCION LISTA A LAS PERSONAS QUE ESTAN DENTRO DEL REGISTRO
	public function Listar_doc(Docente $docente)
	{
		try
		{	// CREAMOS UNA VARIABLE PARA ALMACENAR EL REGISTRO MEDIANTE UN ARREGLO
			$result = array();

			// LLAMA AL PROCEDIMIENTO MEDIANTE LA CONEXION QUE SE HA OBTENIDO EN LA FUNCION CONSTRUCTOR
			$statement = $this->pdo->prepare("CALL PRO_LISTAR_DOCENTES()");

			//$statement->bindParam(1,$docente->__GET('Cod_Persona'));
			$statement->execute();

			foreach($statement->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$doc = new Docente();

				$doc->__SET('COD_PERSONA',          $r->COD_PERSONA);
				$doc->__SET('CARGO',                $r->CARGO);
				$doc->__SET('FUNCION',              $r->FUNCION);

				$result[] = $doc;
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