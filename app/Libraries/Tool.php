<?php 

namespace App\Tool;

class Tool
{

	public static function post($sUrl, $aHeaders, $aData)
	{
		try {

			$ch = curl_init($sUrl);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($aData)); 
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeaders);
	        $sRespuesta = curl_exec($ch);
	        curl_close($ch);
	        
	        return json_decode($sRespuesta);

		} catch (\Throwable $t) {
			$oReponse = new \stdClass();
			$oReponse->error = $t->getMessage();
			$oReponse->file = $t->getFile();
			$oReponse->line = $t->getLine();
			echo json_encode($oReponse);
			exit;
		} 
	}
}