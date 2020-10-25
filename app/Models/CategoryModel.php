<?php 

namespace App\Models;
use App\Dao\DB;

class CategoryModel
{
	private $iId;
	private $sNombre;
	private $sMessage;

	public function getId()
	{
		return $this->iId;
	}

	public function setId($iId)
	{
		$this->iId = $iId;
	}

	public function getNombre()
	{
		return $this->sNombre;
	}

	public function setNombre($sNombre)
	{
		$this->sNombre = $sNombre;
	}

	public function getMessage()
	{
		return $this->sMessage;
	}


	public function load()
	{
		try {
			$oConexion = DB::getConexion();
			$this->sMessage = "Categorias cargadas correctamente.";
			$sSQL = "SELECT id idcategory, nombre name FROM categorias;";
			return DB::fetchAll($oConexion, $sSQL);
			
		} catch (\Throwable $t) {
			
			echo $t->getMessage() . $t->getFile() . $t->getLine();
		
		}
	}

}