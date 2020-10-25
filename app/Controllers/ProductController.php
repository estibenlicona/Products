<?php 

namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\ProductModel;

class ProductController extends Controller
{

	public function index()
	{

		try {
			
			$oProduct = new ProductModel();
			$oData = $oProduct->load();

			$oResponse = new \stdClass();
			$oResponse->message = "Data loaded successfully";
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

	public function get()
	{

		try {
			
			$iProductId = $this->getRequestID();
			$oProduct = new ProductModel();
			$oProduct->setId($iProductId);
			$oData = $oProduct->load();
			$aResponde = [
				"message" => $oProduct->getMessage(),
				"body" => $oData
			];

			$this->responseSuccess($aResponde);
			
		} catch (\Exception $e) {
			$aError = [
				"error" => $e->getMessage(),
				"file" => $e->getFile(),
				"line" => $e->getLine()
			];
			$this->responseFail($oReponse, $e->getCode());
		}
	}

	public function post()
	{

		try {
			$oData = (object)$this->getParams();
			$oProduct = new ProductModel();
			$oProduct->setNombre($oData->name);
			$oProduct->setReferencia($oData->references);
			$oProduct->setPrecio($oData->price);
			$oProduct->setPeso($oData->weight);
			$oProduct->setIdCategoria($oData->idcategory);
			$oProduct->setStock($oData->stock);
			$oProduct->save();

			$aResponde = [
				"message" => $oProduct->getMessage(),
				"body" => [
					"id" => (int)$oProduct->getId()
				]
			];

			$this->responseSuccess($aResponde);
			
		} catch (\Exception $e) {
			$aError = [
				"error" => $e->getMessage(),
				"file" => $e->getFile(),
				"line" => $e->getLine()
			];
			$this->responseFail($oReponse, $e->getCode());
		}	
	}

	public function put()
	{

		try {
			
			$iId = $this->getRequestID();
			$oProduct = new ProductModel();
			$oProduct->setId($iId);
			$oProduct->load();
			$oData = (object)$this->getParams();
			if(property_exists($oData, 'name')) $oProduct->setNombre($oData->name);
			if(property_exists($oData, 'references')) $oProduct->setReferencia($oData->references);
			if(property_exists($oData, 'price')) $oProduct->setPrecio($oData->price);
			if(property_exists($oData, 'weight')) $oProduct->setPeso($oData->weight);
			if(property_exists($oData, 'idcategory')) $oProduct->setIdCategoria($oData->idcategory);
			if(property_exists($oData, 'stock')) $oProduct->setStock($oData->stock);
			$oProduct->save();

			$aResponde = [
				"message" => $oProduct->getMessage()
			];

			$this->responseSuccess($aResponde);
			
		} catch (\Exception $e) {
			$aError = [
				"error" => $e->getMessage(),
				"file" => $e->getFile(),
				"line" => $e->getLine()
			];
			$this->responseFail($oReponse, $e->getCode());
		}	
	}

	public function delete()
	{

		try {
			
			$iId = $this->getRequestID();
			$oProduct = new ProductModel();
			$oProduct->setId($iId);
			$oProduct->delete();

			$aResponde = [
				"message" => $oProduct->getMessage()
			];

			$this->responseSuccess($aResponde);
			
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