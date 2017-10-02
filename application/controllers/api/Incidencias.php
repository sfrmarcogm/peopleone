<?php

/**
* Controlador principal del API REST
* Autor: Antonio Salazar
* update: 02/10/2017
* version: 0.9.1
*/

//evitamos el acceso directo
defined('BASEPATH') OR exit('No direct script access allowed');
//librería que brinda un mejor manejo del REST en CodeIgniter
require APPPATH . 'libraries/REST_Controller.php';

//clase principal
class Incidencias extends REST_Controller {

    function __construct()
    {
        parent::__construct();
		//cargamos el modelo de datos
        $this->load->model("Data_model");
		//0 para no autenticar por headers, 1 para autenticar
		$this->secured=0;
		//version del API
		$this->version="0.9.1";
		//última actualización
		$this->last_update="2017-10-02 10:00:00";
    }
	
	//revisa en los valores del headern que venga el parámetro Authorization con los valores correctos
	function seguro($headers)
	{
		//var_dump($headers);
		if($this->secured==1){
			$autoriza=(isset($headers['Authorization']))? $headers['Authorization']:NULL;
			$token=(isset($headers['token']))? $headers['token']:NULL;
			
			//si no es un parámetro válido, regresa un error y termina la petción
			if($autoriza<>"Basic UDMwcDEzOkAwbjM="){ //P30p13:@0n3
					$this->response([
						'status' => FALSE,
						'message' => 'Unautorized'
					], REST_Controller::HTTP_BAD_REQUEST); 
			} 
		}
		
	}
	
	//Regresa la versión del API
    public function version_get()
    {
		$this->seguro($this->input->request_headers(TRUE));

		$this->response(array("version"=>$this->version, "last_update"=>$this->last_update), 200);
		
    }
	

	/**
	* Muestra los items que coincidan con el criterio
	* @item			el item (numérico(id)  o string)
	*/
    public function lista_get()
    {
		//valores por default para la respuesta
		$error_code=1;
		$HTTP_code=404;
		$datos=NULL;
		$status=FALSE;
		$message="Item(s) could not be found";
		
		$this->seguro($this->input->request_headers(TRUE));    
		
		if(!$this->get('item',TRUE)) //si no existe el parámetro item
		{	
			$message="Incorrect params"; 
			$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
		}
		else
		{	//busca el(los) item8(s)
			$datos = $this->Data_model->getIncidencias($this->get('item', TRUE));
			$HTTP_code=200;
			
			if(is_array($datos)) //regresa los resultados y un OK
			{
				$error_code=0;
				$message="Success";
			}
			else
				$datos=NULL;  //no hay datos
		}

		
		$result["error_code"]=$error_code;
		$result["message"]=$message;
		$result["data"]=$datos;
		$this->response($result, $HTTP_code); //respuesta
		
    }
	
	/**
	* Crea una incidencia
	* @catalogo		el caálogo
	* @area			el área
	* @item			el item
	*/
    public function crear_post()
    {
        //valores por default para la respuesta
		$error_code=1;
		$HTTP_code=404;
		$datos=NULL;
		$status=FALSE;
		$message="Item could not be created";
		
		$this->seguro($this->input->request_headers(TRUE));

		if(empty($_POST)) $_POST=$_REQUEST; 
		$this->load->library('form_validation');
		
		//reglas para validar los parámetros recibidos
		$this->form_validation->set_rules('catalogo', 'catalogo', 'trim|required|min_length[2]'); 
		$this->form_validation->set_rules('area', 'area', 'trim|required|min_length[2]'); 
		$this->form_validation->set_rules('item', 'item', 'trim|required|min_length[2]'); 
		
		//en caso de error en lso parámetros
		if(($this->form_validation->run() == FALSE) and (validation_errors()<>""))
		{	
			$error_code=2;
			$message="Incorrect params"; 
			$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
		}
		else  //si los parámetros vienen completos
		{
			$catalogo=$this->input->post('catalogo', TRUE);
			$area=$this->input->post('area', TRUE);
			$item_=$this->input->post('item', TRUE);
			
			//intentamso almacenar la nueva incidencia
			$hace = $this->Data_model->newIncidencia(array("catalogo"=>$catalogo, "area"=>$area, "item"=>$item_));
			$HTTP_code=200;
			
			if($hace==1) //si se pudo crear
			{
				$error_code=0;
				//$HTTP_code=200;
				$message="Success";
			}
			else{  //no se pudo crear
				$error_code=$hace;
				switch($hace){
					case 2: $message="Incorrect params"; break;
					case 3: $message="Item already exists"; break;
					default: $message="Unknown error occurred";
				}
				//$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
			}
		}
		
		$result["error_code"]=$error_code;
		$result["message"]=$message;
		$this->response($result, $HTTP_code);
    }

	/**
	* Actualizar una incidencia
	* @id			el id de la incidencia a modificar
	* @catalogo		el caálogo
	* @area			el área
	* @item			el item
	*/
    public function editar_post()
    {
		$errores=0;
        //valores por default para la respuesta
		$error_code=1;
		$HTTP_code=404;
		$datos=NULL;
		$status=FALSE;
		$message="Item could not be created";
		
		$this->seguro($this->input->request_headers(TRUE));

		if(empty($_POST)) $_POST=$_REQUEST; 
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('catalogo', 'catalogo', 'trim|required|min_length[2]'); 
		$this->form_validation->set_rules('area', 'area', 'trim|required|min_length[2]'); 
		$this->form_validation->set_rules('item', 'item', 'trim|required|min_length[2]'); 
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		
		if(($this->form_validation->run() == FALSE) and (validation_errors()<>""))
		{	
			$error_code=2;
			$message="Incorrect params"; 
			$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
		}
		else
		{	
		 	$id=$this->input->get_post('id', TRUE);
			$catalogo=$this->input->post('catalogo', TRUE);
			$area=$this->input->post('area', TRUE);
			$item_=$this->input->post('item', TRUE);
			
			$HTTP_code=200;
			
			//verificamos que el id sea un número
			if(!is_numeric($id)){
				$error_code=2;
				$errores++;
				$message="Id field must be numeric"; 
				//$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
			}
			
			//si no hay errores en los parámetros recibidos
			if($errores==0){
				//buscamos actualizar los datos
				$hace = $this->Data_model->updateIncidencia(array("id"=>$id, "catalogo"=>$catalogo, "area"=>$area, "item"=>$item_));
				
				if($hace==1)  //si s epudo actualizar
				{
					$error_code=0;
					//$HTTP_code=200;
					$message="Success";
				}
				else{  //si no se pudo actualizar
					$error_code=$hace;
					switch($hace){
						case 2: $message="Incorrect params"; break;
						case 3: $message="Item already exists"; break;
						case 4: $message="Unknown item"; break;
						default: $message="Unknown error occurred";
					}
					//$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
				}
				
			}
		}
		
		$result["error_code"]=$error_code;
		$result["message"]=$message;
		$this->response($result, $HTTP_code);
    }
	
    /**
	* Borrar una incidencia
	* @id			el id de la incidencia a eliminar
	*/
    public function borrar_post()
    {
		$errores=0;
        //valores por default para la respuesta
		$error_code=1;
		$HTTP_code=404;
		$datos=NULL;
		$status=FALSE;
		$message="Item could not be created";
		
		$this->seguro($this->input->request_headers(TRUE));

		if(empty($_POST)) $_POST=$_REQUEST;
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
		
		if(($this->form_validation->run() == FALSE) and (validation_errors()<>""))
		{	
			$error_code=2;
			$message="Incorrect params"; 
			$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
		}
		else
		{	
		 	$id=$this->input->post('id', TRUE);
			
			if(!is_numeric($id)){
				$error_code=2;
				$errores++;
				$message="Id field must be numeric"; 
				$HTTP_code=REST_Controller::HTTP_BAD_REQUEST;
			}
			
			
			if($errores==0){
				//buscamos eliminar la incidencia por su id
				$hace = $this->Data_model->deleteIncidencia($id);
			
				if($hace==1)  //si se pudo eliminar
				{
					$error_code=0;
					$HTTP_code=200;
					$message="Success";
				}
				else{  //si no se pudo eliminar
					$error_code=$hace;
					switch($hace){
						case 2: $message="Incorrect params"; break;
						case 4: $message="Unknown item"; break;
						default: $message="Unknown error occurred";
					}
					$HTTP_code=200; //REST_Controller::HTTP_BAD_REQUEST; 
				}
				
			}
		}
		
		$result["error_code"]=$error_code;
		$result["message"]=$message;
		$this->response($result, $HTTP_code);
    }

}
