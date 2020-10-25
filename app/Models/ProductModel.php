<?php 

namespace App\Models;
use App\Dao\DB;

class ProductModel
{
	private $iId;
	private $sNombre;
	private $sReferencia;
	private $fPrecio;
	private $iPeso;
	private $iIdCategoria;
	private $iStock;
	private $sFechaCreacion;
	private $sFechaActualizacion;
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

	public function getReferencia()
	{
		return $this->sReferencia;
	}

	public function setReferencia($sReferencia)
	{
		$this->sReferencia = $sReferencia;
	}

	public function getPrecio()
	{
		return $this->fPrecio;
	}

	public function setPrecio($fPrecio)
	{
		$this->fPrecio = $fPrecio;
	}

	public function getPeso()
	{
		return $this->iPeso;
	}

	public function setPeso($iPeso)
	{
		$this->iPeso = $iPeso;
	}

	public function getIdCategoria()
	{
		return $this->iIdCategoria;
	}

	public function setIdCategoria($iIdCategoria)
	{
		$this->iIdCategoria = $iIdCategoria;
	}

	public function getStock()
	{
		return $this->iStock;
	}

	public function setStock($iStock)
	{
		$this->iStock = $iStock;
	}

	public function getFechaCreacion()
	{
		return $this->sFechaCreacion;
	}

	public function setFechaCreacion($sFechaCreacion)
	{
		$this->sFechaCreacion = $sFechaCreacion;
	}

	public function getFechaActualizacion()
	{
		return $this->sFechaActualizacion;
	}

	public function setFechaActualizacion($sFechaActualizacion)
	{
		$this->sFechaActualizacion = $sFechaActualizacion;
	}

	public function getMessage()
	{
		return $this->sMessage;
	}

	public function load()
	{
		try {
			$oConexion = DB::getConexion();
			$this->sMessage = "Productos cargados correctamente.";

			if (is_null($this->iId)) {
				$sSQL = "SELECT P.id, P.nombre name, P.referencia \"references\", P.peso weight, P.precio price, P.stock, C.nombre category, P.idcategoria idcategory, P.fecha_creacion creation, P.fecha_actualizacion \"update\" FROM productos P INNER JOIN categorias C ON P.idcategoria = C.id;";
				return DB::fetchAll($oConexion, $sSQL);
			
			}else{
			
				$sSQL = "SELECT P.id, P.nombre name, P.referencia \"references\", P.peso weight, P.precio price, P.stock, P.idcategoria category, P.fecha_creacion creation, P.fecha_actualizacion \"update\" FROM productos P WHERE P.id = ?;";
				return DB::fetch($oConexion, $sSQL, array($this->iId));
			
			}	
		} catch (\Throwable $t) {
			
			echo $t->getMessage() . $t->getFile() . $t->getLine();
		
		}
	}

	public function save()
	{
		if (is_null($this->iId)) {
			$this->insert();
		}else{
			$this->update();
		}
	}

	public function insert()
	{
		try {

			$sSQL = "INSERT INTO productos(nombre, referencia, precio, peso, idcategoria, stock, fecha_creacion) 
					VALUES(:nombre, :referencia, :precio, :peso, :idcategoria, :stock, :fecha_creacion);";

			$aData = [
				"nombre" => $this->sNombre,
				"referencia" => $this->sReferencia,
				"precio" => $this->fPrecio,
				"peso" => $this->iPeso,
				"idcategoria" => $this->iIdCategoria,
				"stock" => $this->iStock,
				"fecha_creacion" => date('Y-m-d')
			];
			
			$oConexion = DB::getConexion();
			$this->iId = DB::insert($oConexion, $sSQL, $aData);
			$this->sMessage = "Producto guardado correctamente.";

		} catch (\Throwable $t) {
			$this->sMessage = "No se pudo guardar el producto.";
			echo $t->getMessage() . $t->getFile() . $t->getLine();
		}	
	}

	public function update()
	{
		try {
			$sSQL = "UPDATE productos 
					 SET nombre = :nombre, 
						referencia = :referencia, 
						precio = :precio, 
						peso = :peso, 
						idcategoria = :idcategoria, 
						stock = :stock, 
						fecha_actualizacion = :fecha_actualizacion
					WHERE id = :id";

			$aData = [
				"nombre" => $this->sNombre,
				"referencia" => $this->sReferencia,
				"precio" => $this->fPrecio,
				"peso" => $this->iPeso,
				"idcategoria" => $this->iIdCategoria,
				"stock" => $this->iStock,
				"fecha_actualizacion" => date('Y-m-d H:i:s'),
				"id" => $this->iId
			];

			$oConexion = DB::getConexion();
			DB::update($oConexion, $sSQL, $aData);
			$this->sMessage = "Producto actualizado correctamente.";

		} catch (\Throwable $t) {
			$this->sMessage = "No se pudo actualizar el producto.";
			echo $t->getMessage() . $t->getFile() . $t->getLine();
		}	
	}

	public function delete()
	{
		try {

			$sSQL = "DELETE FROM productos WHERE id = :id";

			$aData = [
				"id" => $this->iId
			];
			
			$oConexion = DB::getConexion();
			DB::query($oConexion, $sSQL, $aData);
			$this->sMessage = "Producto eliminado correctamente.";

		} catch (\Throwable $t) {
			$this->sMessage = "No se pudo actualizar el producto.";
			echo $t->getMessage() . $t->getFile() . $t->getLine();
		}
	}
}