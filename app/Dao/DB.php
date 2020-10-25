<?php 
	namespace App\Dao;
	require_once __DIR__.'/../../config.php';

	class DB {
	
	    private $sHost;
	    private $sDataBase;
	    private $sUser;
	    private $sPassword;
	    private $sCharset;
	    private $oDB;
		
		public static function query($oConexion, $sSQL, $aData = array())
		{
			try {
				// Preparar sentencia
				$oStmt = $oConexion->prepare($sSQL);
				
				// Iniciar Transaccion
				$oConexion->beginTransaction();
				
				// Ejecutar sentencia
				$oStmt->execute($aData);

				// Terminar transaccion
				$oConexion->commit();
			}
			catch(\PDOException $e){
				// Cancelar transaccion
				$oConexion->rollback();
				echo "¡ERROR: !" . $e->getMessage();
				exit;
			}
		}	

		public static function fetchAll($oConexion, $sSQL, $aData = array())
		{
			try {

				// Preparar sentencia
				$oStmt = $oConexion->prepare($sSQL);
				
				// Ejecutar sentencia
				$oStmt->execute($aData);

				// Retornar data
				return $oStmt->fetchAll(\PDO::FETCH_OBJ);

			}
			catch(\PDOException $e){

				echo "¡ERROR: !" . $e->getMessage();
			
			}
		}

		public static function fetch($oConexion, $sSQL, $aData = array())
		{
			try {

				// Preparar sentencia
				$oStmt = $oConexion->prepare($sSQL);
				
				// Ejecutar sentencia
				$oStmt->execute($aData);

				// Retornar data
				return $oStmt->fetch(\PDO::FETCH_OBJ);

			}
			catch(\PDOException $e){

				echo "¡ERROR: !" . $e->getMessage();
			
			}
		}

		public static function insert($oConexion, $sSQL, $aData)
		{
			try {

				// Preparar sentencia
				$oStmt = $oConexion->prepare($sSQL);

				// Iniciar Transaccion
				$oConexion->beginTransaction();
				
				// Ejecutar sentencia
				$oStmt->execute($aData);

				// Obtener ID
				$iId = $oConexion->lastInsertId();

				// Terminar transaccion
				$oConexion->commit();

				return $iId;

			}
			catch(\PDOException $e){
				// Cancelar transaccion
				$oConexion->rollback();
				echo "¡ERROR: !" . $e->getMessage();
				exit;
			}
		}

		public static function update($oConexion, $sSQL, $aData)
		{
			try {

				// Preparar sentencia
				$oStmt = $oConexion->prepare($sSQL);

				// Iniciar Transaccion
				$oConexion->beginTransaction();
				
				// Ejecutar sentencia
				$oStmt->execute($aData);

				// Terminar transaccion
				$oConexion->commit();

			}
			catch(\PDOException $e){
				// Cancelar transaccion
				$oConexion->rollback();
				echo "¡ERROR: !" . $e->getMessage();
				exit;
			}
		}

		public static function getConexion()
		{
			try {

				$sHost = HOST_NAME;
			    $sDataBase = DATABASE_NAME;
			    $sUser = USER;
			    $sPassword = PASSWORD;

			    $dsn = "mysql:host={$sHost};dbname={$sDataBase}";
			    $pdo = new \PDO($dsn, $sUser, $sPassword);
			    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				return $pdo;

			} catch (\PDOException $e){
			    echo $e->getMessage();
			}
		}
	}