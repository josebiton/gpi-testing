<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Usuario
{
	//Implementamos nuestro constructor
  public $id_usr_sesion; public $id_empresa_sesion;
  //Implementamos nuestro constructor
  public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )
  {
    $this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
		$this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
  }

	//Implementamos un método para insertar registros
	public function insertar($idpersona, $login, $clavehash, $permisos, $series)	{
		$sql = "INSERT INTO usuario( idpersona, login, password) VALUES ('$idpersona','$login','$clavehash')";
		$id_new = ejecutarConsulta_retornarID($sql, 'C');	if ($id_new['status'] == false) {  return $id_new; } 		

		$id = $id_new['data'];
		$zz = 0;
		$yy = 0;

		while ($zz < count($permisos)) {
			$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$id', '$permisos[$zz]')";
			$usr_permiso = ejecutarConsulta($sql_detalle, 'C'); if ($usr_permiso['status'] == false) {  return $usr_permiso; } 
			$zz = $zz + 1;
		}

		while ($yy < count($series)) {
			$sql_detalle_series = "INSERT into sunat_usuario_comprobante(idusuario, idtipo_comprobante) values ('$id', '$series[$yy]')";
			$usr_num = ejecutarConsulta($sql_detalle_series, 'C'); if ($usr_num['status'] == false) {  return $usr_num; } 
			$yy = $yy + 1;
		}		

    return $id_new;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario, $idpersona, $login, $clavehash, $permisos, $series) {

		$sql = "UPDATE usuario SET idpersona='$idpersona', login='$login', password='$clavehash' WHERE idusuario='$idusuario'";
		$edit_user = ejecutarConsulta($sql, 'U'); if ($edit_user['status'] == false) {  return $edit_user; }

		//Eliminar todos los permisos asignados para volverlos a registrar
		$sqldel = "DELETE from usuario_permiso where 	idusuario='$idusuario'";
		$del_up = ejecutarConsulta($sqldel); if ($del_up['status'] == false) {  return $del_up; }

		$sqldelSeries = "DELETE from sunat_usuario_comprobante where idusuario='$idusuario'";
		$del_suc = ejecutarConsulta($sqldelSeries); if ($del_suc['status'] == false) {  return $del_suc; }

		$zz = 0;
		$yy = 0;

		while ($zz < count($permisos)) {
			$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$idusuario', '$permisos[$zz]')";
			$usr_permiso = ejecutarConsulta($sql_detalle, 'C'); if ($usr_permiso['status'] == false) {  return $usr_permiso; } 
			$zz = $zz + 1;
		}

		while ($yy < count($series)) {
			$sql_detalle_series = "INSERT into sunat_usuario_comprobante(idusuario, idtipo_comprobante) values ('$idusuario', '$series[$yy]')";
			$usr_num = ejecutarConsulta($sql_detalle_series, 'C'); if ($usr_num['status'] == false) {  return $usr_num; } 
			$yy = $yy + 1;
		}		

    return $edit_user;		
	}

	//Implementamos un método para desactivar usuario
	public function desactivar($idusuario) {
		$sql = "UPDATE usuario set condicion='0' where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar usuario
	public function activar($idusuario)	{
		$sql = "UPDATE usuario set condicion='1' where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar usuario
	public function cargo_persona($idpersona)	{
		$sql = "SELECT p.idpersona, p.nombre_razonsocial, cp.nombre as cargo_trabajador
		FROM persona as p
		INNER JOIN cargo_trabajador as cp on cp.idcargo_trabajador = p.idcargo_trabajador		
		WHERE p.idpersona = '$idpersona'";
		$datos = ejecutarConsultaSimpleFila($sql);

		if (empty($datos['data'])) {
			$data = [ 'status'=>true, 'message'=>'todo okey','data'=> ['idpersona' => '', 'nombre_razonsocial' => '', 'cargo_trabajador' => '' ]  ];
    	return $data;
		}

		return $datos;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)	{
		$sql = "SELECT u.idusuario, p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo,
		p.foto_perfil, u.login, DATE_FORMAT(u.last_sesion, '%m/%d/%Y %h:%i: %p') AS last_sesion, u.estado,	t.nombre as tipo_persona, c.nombre as cargo_trabajador
		FROM  usuario as u
		inner join persona as p on u.idpersona = p.idpersona
		INNER JOIN tipo_persona as t ON t.idtipo_persona = p.idtipo_persona
		INNER JOIN cargo_trabajador as c ON c.idcargo_trabajador = p.idcargo_trabajador
		where u.idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_clave($idusuario)	{
		$sql = "SELECT u.idusuario, u.idpersona, u.login, u.password, u.estado FROM  usuario as u where u.idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function validar_usuario($idusuario, $user) {
    $validar_user = empty($idusuario) ? "" : "AND u.idusuario != '$idusuario'" ;
    $sql = "SELECT u.idusuario, u.login, u.password, u.estado FROM usuario AS u WHERE u.login = '$user' $validar_user;";
    $buscando =  ejecutarConsultaArray($sql); if ( $buscando['status'] == false) {return $buscando; }

    if (empty($buscando['data'])) { return true; }else { return false; }
  }

	//Implementar un método para listar los registros
	public function listar()	{
		$sql = "SELECT u.idusuario, p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo,
		p.foto_perfil, u.login, DATE_FORMAT(u.last_sesion, '%m/%d/%Y %h:%i: %p') AS last_sesion, u.estado,	t.nombre as tipo_persona, c.nombre as cargo_trabajador
		FROM  usuario as u
		inner join persona as p on u.idpersona = p.idpersona
		INNER JOIN tipo_persona as t ON t.idtipo_persona = p.idtipo_persona
		INNER JOIN cargo_trabajador as c ON c.idcargo_trabajador = p.idcargo_trabajador
		WHERE u.estado = '1' AND u.estado_delete = '1'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()	{
		$sql = "SELECT * from usuario where condicion=1";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para listar los permisos marcados
	public function listarmarcados($idusuario)	{		
		$sql = "SELECT * from usuario_permiso where idusuario='$idusuario'";
		return ejecutarConsultaArray($sql); 		
	}

	public function listar_grupo_marcados($idusuario)	{		
		$sql = "SELECT up.idusuario, p.idpermiso, p.estado, p.modulo, count(p.modulo) 
		from usuario_permiso AS up 
		INNER JOIN permiso as p ON up.idpermiso = p.idpermiso 
		where idusuario='$idusuario'
		GROUP BY p.modulo ORDER BY count(p.modulo) DESC; ";
		return ejecutarConsultaArray($sql); 		
			
	}

	public function listarmarcadosEmpresa($idusuario)	{
		$sql = "SELECT * from usuario_empresa where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	public function listarmarcadosEmpresaTodos()	{
		$sql = "SELECT * from usuario_empresa ";
		return ejecutarConsulta($sql);
	}

	public function listarmarcadosNumeracion($idusuario)	{
		$sql = "SELECT * from sunat_usuario_comprobante where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Funcion para verificar el acceso al sistema
	public function verificar($login, $clave)	{

		$sql = "SELECT u.idusuario, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo, ct.nombre as cargo, u.login, p.foto_perfil, p.tipo_documento
    FROM usuario as u, persona as p, cargo_trabajador as ct 
    WHERE  u.idpersona = p.idpersona AND p.idcargo_trabajador =ct.idcargo_trabajador AND  u.login='$login' AND u.password='$clave' 
    AND p.estado=1 and p.estado_delete=1 and u.estado=1 and u.estado_delete=1;";
		$user = ejecutarConsultaSimpleFila($sql); if ($user['status'] == false) {  return $user; } 

		// $id_user =  empty($user['data']) ? '' : $user['data']['idusuario'];

		// $sql2 = "SELECT ue.*, u.nombre as nombre_usuario, u.apellidos as apellido_usuario, e.nombre_razon_social, e.nombre_comercial, e.domicilio_fiscal, e.numero_ruc, co.igv 
		// FROM usuario_empresa as ue
		// INNER JOIN usuario AS u ON u.idusuario = ue.idusuario
		// INNER JOIN empresa as e ON e.idempresa = ue.idempresa
		// inner join configuraciones co on e.idempresa=co.idempresa 
		// WHERE ue.idusuario = '$id_user'";
		// $sucursal = ejecutarConsultaSimpleFila($sql2); if ($sucursal['status'] == false) {  return $sucursal; }

		$data = [ 'status'=>true, 'message'=>'todo okey','data'=> ['usuario' => $user['data']]  ];
    return $data;
	}

	public function onoffTempo($st)	{
		$sql = "UPDATE temporizador set estado='$st' where id='1' ";
		return ejecutarConsulta($sql);
	}

	public function consultatemporizador()	{
		$sql = "SELECT id as idtempo, tiempo, estado from temporizador where id='1' ";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function savedetalsesion($idusuario)	{
		$sql = "INSERT into detalle_usuario_sesion (idusuario, tcomprobante, idcomprobante, fechahora) 
      values ('$idusuario', '','', now())";
		return ejecutarConsulta($sql);
	}

	public function last_sesion($idusuario)	{
		$sql = "UPDATE usuario SET last_sesion = CURRENT_TIMESTAMP WHERE  idusuario='$idusuario';";
		 ejecutarConsulta($sql);
		$sql1 = "INSERT INTO bitacora_sesion (idusuario) VALUES ('$idusuario')";
		return ejecutarConsulta($sql1); 	
	}

	public function historial_sesion($idusuario) {
   
    $sql = "SELECT DATE_FORMAT(bs.fecha_sesion, '%m/%d/%Y %h:%i %p') AS last_sesion , MONTHNAME(bs.fecha_sesion) AS nombre_mes, DAYNAME(bs.fecha_sesion) AS nombre_dia
		FROM bitacora_sesion as bs WHERE idusuario = '$idusuario' ORDER BY bs.fecha_sesion DESC;";
    return ejecutarConsultaArray($sql); 
  }
}
