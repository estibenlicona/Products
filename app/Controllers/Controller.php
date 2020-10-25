<?php 

namespace App\Controllers;
class Controller 
{
	private $oParams;
	private $requestID;

	function __construct()
	{
		// Headers
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
		header("Access-Control-Allow-Headers: Authorization, X-Requested-With, Content-Type");
		header('Content-Type: application/json; charset=utf-8');
		$this->oParams = array();
	}

	public function setRequestID($requestID)
	{
		$this->requestID = $requestID;			
	}

	public function getRequestID()
	{
		return $this->requestID;			
	}

	public function setParams($oParams)
	{
		$this->oParams = $oParams;			
	}

	public function getParams($iIndex = NULL)
	{
		if (is_null($iIndex)) {
			return $this->oParams;
		}else{
			return $this->oParams[$iIndex];
		}
	}

	public function responseSuccess($aData)
	{
		http_response_code(200);
		echo json_encode($aData);
	}

	public function responseFail($aData, $iCode = 404)
	{
		http_response_code($iCode);
		echo json_encode($aData);
	}
}