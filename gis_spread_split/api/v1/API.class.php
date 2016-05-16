<?php
abstract class API
{

	protected $method = '';
	protected $request;

	protected $user= '';
	protected $lat=0.0;
	protected $long=0.0;
	protected $pid=0;
	
	protected $statusCode;
	
	protected $requiredInputs=0;

	protected $args = Array();		
	protected $endpoint = '';


	public function __construct($request) 
	{
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");
		
		$this->statusCode['started'] = 1;
		$this->statusCode['running'] = 2;
		$this->statusCode['finished'] = 3;
		//$this->statusCode['error'] = 4;  //hardcoded in api.php
		$this->statusCode['emptyResults'] = 5;

		/*Nešto ovog tipa bi bilo da se koristi RESTful*/
		/*$this->args = explode('/', rtrim($request, '/'));
		$this->endpoint = array_shift($this->args);
		if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
			$this->verb = array_shift($this->args);
		}*/
		
		/*Ovaj dio je malo drugačiji, jer se ne koristi RESTful*/
		$parts = parse_url($request);
		parse_str($parts['query'], $query);
		$this->args = $query;	

		/*Za sada je hardcoded naziv aplikacije*/
		$this->endpoint="AdriaFirePropagator";

		
		
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->args=$this->_cleanInputs($this->args);
		
		/*if($this->method=="GET")
		{
			if($this->args['user']!='')
			{
				$this->user = $this->args['user'];
				$this->requiredInputs++;
			}
			//npr 43.601030
			if($this->args['lat']!='')
			{
				$this->lat = $this->args['lat'];
				$this->requiredInputs++;
			}
			//npr 16.464386
			if($this->args['long']!='')
			{
				$this->long = $this->args['long'];
				$this->requiredInputs++;
			}
			if($this->args['pid']!='')
			{
				$this->pid = $this->args['pid'];
				$this->requiredInputs++;
			}
		}*/
		
	
		switch($this->method) {
		case 'GET':
			
			/*if($this->requiredInputs>=2)
			{*/
				$this->request=$this->args;
			/*}				
			else
			{
				
				$this->_response('Nema dovoljno parametara', 405);
			}				
			break;*/
		default:
				$this->_response('Invalid Method', 405);
			break;
		}
		

		
	}
	
	public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);

    }
	
	
	private function _response($data, $status = 200) {
		header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
		return $data;
    }
	
	private function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }
	
	private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }
	
}


	
?>