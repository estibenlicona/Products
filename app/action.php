<?php 
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../config.php';

// Funcion para el control de errores
function logErrors($iErrorCode, $sDescription, $sFile, $iLine){
	
	$aError = [
		"errorCode" => $iErrorCode,
		"descripcion" => $sDescription,
		"file" => $sFile,
		"line" => $iLine
	];

	echo json_encode($aError);
	exit;
}

set_error_handler("logErrors");

try {
	// Validar autorización
	$oHeaders = (object)getallheaders();
	// if (!property_exists($oHeaders, 'Authorization') or $oHeaders->Authorization !== TOKEN) {
	// 	throw new Exception("Not authorized", 401);
	// }

	$sRequest = $_SERVER['REQUEST_URI'];
	$sMethod = strtolower($_SERVER['REQUEST_METHOD']);

	// Obtener Request
	$aRequest = explode('/', substr($sRequest, 1));

	// Obtener controlador
	$sController = ucwords($aRequest[2]);

	// Instanciar controlador
	$sControlador = "\\App\\Controllers\\{$sController}Controller";
	$oController = new $sControlador;

	// Obtener id del recurso
	if (count($aRequest) == 4 and ($sMethod == 'get' or $sMethod == 'delete' or $sMethod == 'put')) {
		if (!empty($aRequest[3])) {
			$oController->setRequestID($aRequest[3]);
		}else{
			throw new \Exception("El id del recurso no fue enviado", 404);
			
		}
	}

	// Definir accion del recurso a ejecutar
	$sAccion = $sMethod;

	// Es index?
	if (count($aRequest) == 3 and ($sMethod != 'put' and $sMethod != 'post')) {
		$sAccion = "index";	
	}

	// Validar body
	if ($sMethod == 'put' || $sMethod == 'post') {
	 	$sPostJSON = file_get_contents('php://input');
	 	$iLen = strlen($sPostJSON); 
		if ($iLen == 0) {
			throw new \Exception("Peticion mal formada; El Body de la petición no fue enviado", 404);
		}
			
		if ($iLen > 0) {
			$oJson = json_decode($sPostJSON, TRUE);
			if (is_null($oJson)) {
				throw new \Exception("Peticion mal formada; La estructura enviada no es un objeto json", 404);		
			}

			// Setear body
			$oController->setParams($oJson);
		}
	}

	// llamar accion
	$oController->$sAccion();

} catch (\Exception $e) {

	http_response_code($e->getCode());
	$aError = [
		"error" => $e->getMessage(),
		"file" => $e->getFile(),
		"line" => $e->getLine()
	];

	echo json_encode($aError);
	exit;

}

	