<?php

/**
* Modelo de datos del API REST
* Autor: Antonio Salazar
* update: 02/10/2017
* version: 0.9.1
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Data_model extends CI_Model 
{ 
	
	function __construct() 
    { 
        parent::__construct(); 
    } 
	
	//Regresa las incidencias coincidentes por @item
	function getIncidencias($item)
    {
		if($item=="") return 0;
		
		if(is_numeric($item))
		    $this->db->where('id',$item); //lo busca por su id
		else
			$this->db->where('item',$item); //lo busca por string
		
		$query = $this->db->get("incidencias");
		
		if($query->num_rows()>0)
          return $query->result_array(); //si existen coincidencias los regresa
		return 0;  //si no hay coincidencias regresa 0
    }
	
	/**
	* Crea una incidencia
	* @catalogo		el caálogo
	* @area			el área
	* @item			el item
	*/
	function newIncidencia($datos) //recibe un array con los datos
	{ 	//si hay algún error en los datos, regresa un 2
		if(empty($datos["catalogo"])) return 2;
		if(empty($datos["area"])) return 2;
		if(empty($datos["item"])) return 2;
		
		//busca una incidencia con los mismos datos enviados
		$this->db->where('catalogo',$datos["catalogo"]);
		$this->db->where('area',$datos["area"]);
		$this->db->where('item',$datos["item"]);
		$query = $this->db->get("incidencias");
		
		//si no existe la guarda
		if($query->num_rows()==0)
          {
			  $this->db->insert('incidencias', $datos);
			  return 1;  //un 1=OK
		  }
		return 3;  //un 3= la incidencia ya existe con esos parámetros y no se puede almacenar
	}
	
	/**
	* Actualiza una incidencia
	* @id			el id de la incidencia a modificar
	* @catalogo		el caálogo
	* @area			el área
	* @item			el item
	*/
	function updateIncidencia($datos)
	{ 
		if($datos["id"]=="") return 2;
		if(empty($datos["catalogo"])) return 2;
		if(empty($datos["area"])) return 2;
		if(empty($datos["item"])) return 2;
		
		//$id=intval($id);
		//buscamos la incidencia por el id
		$this->db->where('id',$datos["id"]);
		$query = $this->db->get("incidencias");
		
		//si existe la incidencia con el id proporcionado
		if($query->num_rows()>0)
          {	  //verificamos que no exista otra incidencia con lso mismos nuevos datos
			  $this->db->where('id !=',$datos["id"]);
			  $this->db->where('catalogo',$datos["catalogo"]);
			  $this->db->where('area',$datos["area"]);
			  $this->db->where('item',$datos["item"]);
			  $query = $this->db->get("incidencias");
			  
			  //si no existe un item igual, se actualiza
			  if($query->num_rows()==0)
			    {	
					$this->db->where('id',$datos["id"]);
					$this->db->update('incidencias', $datos);
			  		return 1; //OK
			    }
			  return 3; //si existe ya un item igual no se puede actualizar
		  }
		return 4; //el item identificado por el id no existe
	}
	
	/**
	* Borra una incidencia
	* @id			el id de la incidencia a eliminar
	*/
	function deleteIncidencia($id)
	{ 
		$id=intval($id);
		if($id<=0) return 2; //si el id no es válido regresa un 2
		
		//busca la incidencia por el id
		$this->db->where('id',$id);
		$query = $this->db->get("incidencias");
		
		//si existe la incidencia con el id proporcionado
		if($query->num_rows()>0)
          {
			  $this->db->where('id',$id);
			  $query = $this->db->delete("incidencias"); //lo borramos y
			  return 1; //regresamos un OK
		  }
		return 4; //el item identificado por el id no existe
	}
	
}

?>