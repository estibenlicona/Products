<?php 

namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\CategoryModel;

class CategoryController extends Controller
{

	public function index()
	{

		try {
			
			$oCategory = new CategoryModel();
			$oData = $oCategory->load();

			$oResponse = new \stdClass();
			$oResponse->message = $oCategory->getMessage();
			$oResponse->body = $oData;
			$this->responseSuccess($oResponse);
			
		} catch (\Exception $e) {
			$aError = [
				"error" => $e->getMessage(),
				"file" => $e->getFile(),
				"line" => $e->getLine()
			];
			$this->responseFail($oReponse, $e->getCode());
		}
	}

}