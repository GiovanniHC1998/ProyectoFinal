<?php
//BOL: Business Object Layer - Capa de objeto de negocio

// CLASE PERSONA
class Persona
{
	// CREAMOS LAS VARIABLES (CAMPOS DE LA TABLA PERSONA)
	private $Ape_paterno;
	private $Ape_materno;
	private $Nombres;
	private $Sexo;
	private $Estado_civil;
	private $Fecha_nac;
	private $Direccion;
	private $Telefono;
	private $Correo;
	private $Cod_distrito;

    //OBTIENE Y ESTABLECE LOS DATOS INGRESADOS 
	public function __GET($x)
	{ 
		return $this->$x; 
	}
	public function __SET($x, $y)
	{ 
		return $this->$x = $y; 
	}
}
?>