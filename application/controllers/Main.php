<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


	function __construct()
    {
        parent::__construct();
		//cargamos el modelo de datos
        $this->load->model("Data_model");
		//0 para no autenticar por headers, 1 para autenticar
		$this->secured=0;
    }
	
	public function index()
	{
		$this->load->view("api_test_view");
	}
	
	public function get_api()
	{
		
		//$res=$this->getAPI('lista',array('item'=>"wired"));
		//$res=$this->getAPI('crear',array('catalogo'=>"LOLO", "area"=>"LOLO2", "item"=>"LOLO3"));
		//$res=$this->getAPI('editar',array('id'=>881, 'catalogo'=>"LOLO", "area"=>"LOLO2", "item"=>"LOLO33"));
		//$res=$this->getAPI('borrar',array('id'=>8810));
		//$res=$this->getAPI('version',array());
		

		return $this->output
					->set_content_type('application/json')
					->set_status_header(200)
					->set_output(json_encode($res));


	}
	
	function getAPI($opcion, $vars)
	{
		if(empty($opcion) || !is_array($vars)) return 0;
		
		//var_dump($vars);
		$postData="";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic UDMwcDEzOkAwbjM=','token: people@0n3'));
		
		
		if($opcion=="lista") {
			$url=base_url()."api/incidencias/lista?item=".$vars["item"];
		}
		elseif($opcion=="crear") {
			$url=base_url()."api/incidencias/crear"; 
		}
		elseif($opcion=="editar") {
			$url=base_url()."api/incidencias/editar";
		}
		elseif($opcion=="borrar") {
			$url=base_url()."api/incidencias/borrar";
		}
		elseif($opcion=="version")  { 
			$url=base_url()."api/incidencias/version";
		}
		else { 
			return NULL;
		}
		
		if(($opcion<>"lista") && ($opcion<>"version") ) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);
		}

		curl_setopt($ch, CURLOPT_URL,$url);

		
		$response = curl_exec ($ch); 

		curl_close ($ch);
		$result = json_decode($response);
		
		return $result;
	}
}
