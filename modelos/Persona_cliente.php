<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Cliente
{
	public $id_usr_sesion; public $id_persona_sesion; public $id_trabajador_sesion;
	//Implementamos nuestro constructor
	public function __construct()
	{
		$this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
		$this->id_persona_sesion = isset($_SESSION['idpersona']) ? $_SESSION["idpersona"] : 0;
		$this->id_trabajador_sesion = isset($_SESSION['idpersona_trabajador']) ? $_SESSION["idpersona_trabajador"] : 0;
	}
	/*T-- paepelera --desacctivar
	C-- crear
	R-- read
	U-- actualizar
	D-- delete -- eliminar*/
	//Implementamos un método para insertar registros
	public function insertar_cliente(	$idtipo_persona, $idbancos, $idcargo_trabajador, $tipo_persona_sunat, $tipo_documento, $numero_documento, $nombre_razonsocial, 
		$apellidos_nombrecomercial,	$fecha_nacimiento, $celular, $direccion, $distrito, $departamento, $provincia, $ubigeo, $correo,	$idpersona_trabajador,
		$idzona_antena, $idselec_centroProbl, $idplan, $ip_personal, $fecha_afiliacion,  $fecha_cancelacion,	$usuario_microtick,$nota, 
		$estado_descuento, $descuento,	$img_perfil	) {

		$sql1 = "INSERT INTO persona(idtipo_persona, idbancos, idcargo_trabajador, tipo_persona_sunat, nombre_razonsocial, 
		apellidos_nombrecomercial, tipo_documento, numero_documento, fecha_nacimiento, celular, direccion, departamento, provincia, 
		distrito, cod_ubigeo, correo,foto_perfil) 
		VALUES ( '$idtipo_persona', '$idbancos', '$idcargo_trabajador', '$tipo_persona_sunat', '$nombre_razonsocial', 
		'$apellidos_nombrecomercial', '$tipo_documento', '$numero_documento', '$fecha_nacimiento', '$celular', '$direccion', '$departamento', '$provincia', 
		'$distrito', '$ubigeo', '$correo','$img_perfil')";
		$inst_persona = ejecutarConsulta_retornarID($sql1, 'C');

		if ($inst_persona['status'] == false) {
			return $inst_persona;
		}
		$id = $inst_persona['data'];


		$sql2 = "INSERT INTO persona_cliente(idpersona,idzona_antena, idplan, idpersona_trabajador,idcentro_poblado, ip_personal, fecha_afiliacion, fecha_cancelacion,usuario_microtick,nota, descuento, estado_descuento) 
		VALUES ('$id','$idzona_antena', '$idplan', '$idpersona_trabajador','$idselec_centroProbl','$ip_personal', '$fecha_afiliacion', '$fecha_cancelacion', '$usuario_microtick','$nota', '$descuento', '$estado_descuento')";

		$insertar =  ejecutarConsulta($sql2, 'C');
		if ($inst_persona['status'] == false) {
			return $inst_persona;
		}

		return $insertar;
	}

	//Implementamos un método para editar registros
	public function editar_cliente(	$idpersona,	$idtipo_persona,	$idbancos,	$idcargo_trabajador,	$idpersona_cliente,	$tipo_persona_sunat,	$tipo_documento,
		$numero_documento,	$nombre_razonsocial,	$apellidos_nombrecomercial,	$fecha_nacimiento,	$celular,	$direccion,	$distrito, $departamento, $provincia, $ubigeo, 
		$correo, $idpersona_trabajador,	$idzona_antena,	$idselec_centroProbl,	$idplan, $ip_personal, $fecha_afiliacion, $fecha_cancelacion, $usuario_microtick,$nota,
		$estado_descuento, $descuento,	$img_perfil	) {

		$sql1 = "UPDATE persona SET 		
						idtipo_persona='$idtipo_persona',
						idbancos='$idbancos',
						idcargo_trabajador='$idcargo_trabajador',
						tipo_persona_sunat='$tipo_persona_sunat',
						nombre_razonsocial='$nombre_razonsocial',
						apellidos_nombrecomercial='$apellidos_nombrecomercial',
						tipo_documento='$tipo_documento',
						numero_documento='$numero_documento',
						fecha_nacimiento='$fecha_nacimiento',
						celular='$celular',
						direccion='$direccion',
						departamento='$departamento',
						provincia='$provincia',
						distrito='$distrito',
						cod_ubigeo='$ubigeo',
						correo='$correo',		
						foto_perfil='$img_perfil'	
				WHERE idpersona='$idpersona';";

		$editar1 =  ejecutarConsulta($sql1, 'U');

		if ($editar1['status'] == false) {
			return $editar1;
		}

		$sql = "UPDATE persona_cliente SET
		idpersona ='$idpersona',
		idzona_antena='$idzona_antena',
		idcentro_poblado='$idselec_centroProbl',
		idplan='$idplan',
		idpersona_trabajador='$idpersona_trabajador',
		ip_personal='$ip_personal',
		fecha_afiliacion='$fecha_afiliacion',
		fecha_cancelacion='$fecha_cancelacion',
		usuario_microtick='$usuario_microtick',
		nota='$nota',
		descuento='$descuento',
		estado_descuento='$estado_descuento'
		WHERE idpersona_cliente='$idpersona_cliente';"; 

		$editar =  ejecutarConsulta($sql, 'U');

		if ($editar['status'] == false) {
			return $editar;
		}

		return $editar;
	}

	//Implementamos un método para desactivar color
	public function desactivar_cliente($idpersona_cliente, $descripcion)	{
		$sql = "UPDATE persona_cliente SET estado='0', nota ='$descripcion' WHERE idpersona_cliente='$idpersona_cliente'";
		$desactivar = ejecutarConsulta($sql, 'T');

		return $desactivar;
	}

	//Implementamos un método para desactivar color
	public function activar_cliente($idpersona_cliente, $descripcion)	{
		$sql = "UPDATE persona_cliente SET estado='1', nota ='$descripcion' WHERE idpersona_cliente='$idpersona_cliente'";
		$desactivar = ejecutarConsulta($sql, 'T');

		return $desactivar;
	}

	//Implementamos un método para eliminar persona_cliente
	public function eliminar_cliente($idpersona_cliente)	{
		$sql = "UPDATE persona_cliente SET estado_delete='0' WHERE idpersona_cliente='$idpersona_cliente'";
		$eliminar =  ejecutarConsulta($sql, 'D');		if ($eliminar['status'] == false) {	return $eliminar;	}

		return $eliminar;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_cliente($idpersona_cliente)	{
		$sql = "SELECT pc.idpersona_cliente, pc.idpersona, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan, pc.ip_personal, pc.idcentro_poblado,
		pc.fecha_afiliacion, pc.fecha_cancelacion, pc.nota, pc.usuario_microtick, pc.descuento, pc.estado_descuento, pc.estado, p.*
		FROM persona_cliente as pc
		INNER JOIN persona as p on pc.idpersona=p.idpersona
		WHERE idpersona_cliente='$idpersona_cliente';";

		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function tabla_principal_cliente($filtro_trabajador, $filtro_dia_pago, $filtro_plan, $filtro_zona_antena)	{

		$filtro_sql_trab  = ''; $filtro_sql_dp  = ''; $filtro_sql_p  = ''; $filtro_sql_za  = '';

		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') { $filtro_sql_trab = "AND pt.idpersona_trabajador = '$this->id_trabajador_sesion'";	}

		if ( empty($filtro_trabajador) 	|| $filtro_trabajador 	== 'TODOS' ) { } else{	$filtro_sql_trab	= "AND pt.idpersona_trabajador = '$filtro_trabajador'";	}
		if ( empty($filtro_dia_pago) 		|| $filtro_dia_pago 		== 'TODOS' ) { } else{ 	$filtro_sql_dp 		= "AND DAY(pc.fecha_cancelacion)  = '$filtro_dia_pago'";	}
		if ( empty($filtro_plan) 				|| $filtro_plan 				== 'TODOS' ) { } else{	$filtro_sql_p 		= "AND pc.idplan = '$filtro_plan'";	}
		if ( empty($filtro_zona_antena) || $filtro_zona_antena 	== 'TODOS' ) { } else{	$filtro_sql_za 		= "AND pc.idzona_antena = '$filtro_zona_antena'";	}
		
		$sql = "SELECT pc.idpersona_cliente, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan , pc.ip_personal, DAY(pc.fecha_cancelacion) AS dia_cancelacion, 
		pc.fecha_cancelacion,	pc.fecha_afiliacion, pc.descuento,pc.estado_descuento,cp.nombre as centro_poblado, pc.nota, pc.usuario_microtick,
		CASE 
			WHEN p.tipo_persona_sunat = 'NATURAL' THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
			WHEN p.tipo_persona_sunat = 'JURÍDICA' THEN p.nombre_razonsocial 
			ELSE '-'
		END AS cliente_nombre_completo, 
		p.tipo_documento, p.numero_documento, p.celular, p.foto_perfil, p.direccion,p.distrito,p1.nombre_razonsocial AS trabajador_nombre, pl.nombre as nombre_plan,pl.costo,za.nombre as zona, 
		za.ip_antena,pc.estado, i.abreviatura as tipo_doc
		FROM persona_cliente as pc
		INNER JOIN persona AS p on pc.idpersona=p.idpersona
		INNER JOIN persona_trabajador AS pt on pc.idpersona_trabajador= pt.idpersona_trabajador
		INNER JOIN persona as p1 on pt.idpersona=p1.idpersona
		INNER JOIN plan as pl on pc.idplan=pl.idplan
		INNER JOIN zona_antena as za on pc.idzona_antena=za.idzona_antena
		INNER JOIN sunat_doc_identidad as i on p.tipo_documento=i.code_sunat  
		INNER JOIN centro_poblado as cp on pc.idcentro_poblado=cp.idcentro_poblado  
		where pc.estado_delete='1' $filtro_sql_trab $filtro_sql_dp $filtro_sql_p $filtro_sql_za
		ORDER BY pc.idpersona_cliente DESC";
		return ejecutarConsulta($sql);
	}

	// ══════════════════════════════════════  PAGOS POR CLIENTES ══════════════════════════════════════

	public function ver_pagos_x_cliente($idcliente)	{		
		
		$sql = "SELECT pc.idpersona_cliente, LPAD(pc.idpersona_cliente, 5, '0') as idcliente, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan , pc.ip_personal, DAY(pc.fecha_cancelacion) AS dia_cancelacion, 
		pc.fecha_cancelacion, DATE_FORMAT(pc.fecha_cancelacion, '%d/%m/%Y') AS fecha_cancelacion_format, 	pc.fecha_afiliacion, pc.descuento,pc.estado_descuento,
		cp.nombre as centro_poblado, pc.nota, pc.usuario_microtick,
		CASE 
			WHEN p.tipo_persona_sunat = 'NATURAL' THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
			WHEN p.tipo_persona_sunat = 'JURÍDICA' THEN p.nombre_razonsocial 
			ELSE '-'
		END AS cliente_nombre_completo, 
		p.tipo_documento, p.numero_documento, p.celular, p.foto_perfil, p.direccion,p.distrito,p1.nombre_razonsocial AS trabajador_nombre, 
		pl.nombre as nombre_plan,pl.costo,za.nombre as zona, za.ip_antena,pc.estado, i.abreviatura as tipo_doc
		FROM persona_cliente as pc
		INNER JOIN persona AS p on pc.idpersona=p.idpersona
		INNER JOIN persona_trabajador AS pt on pc.idpersona_trabajador= pt.idpersona_trabajador
		INNER JOIN persona as p1 on pt.idpersona=p1.idpersona
		INNER JOIN plan as pl on pc.idplan=pl.idplan
		INNER JOIN zona_antena as za on pc.idzona_antena=za.idzona_antena
		INNER JOIN sunat_doc_identidad as i on p.tipo_documento=i.code_sunat  
		INNER JOIN centro_poblado as cp on pc.idcentro_poblado=cp.idcentro_poblado  
		where pc.estado_delete='1' AND pc.idpersona_cliente = '$idcliente'
		ORDER BY pc.idpersona_cliente DESC";
		return ejecutarConsultaSimpleFila($sql);
	}

	// ══════════════════════════════════════  PAGOS ALL CLIENTES ══════════════════════════════════════

	public function ver_pagos_all_cliente($filtro_trabajador, $filtro_dia_pago, $filtro_plan, $filtro_zona_antena)	{

		$filtro_sql_trab  = ''; $filtro_sql_dp  = ''; $filtro_sql_p  = ''; $filtro_sql_za  = '';

		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') { $filtro_sql_trab = "AND pt.idpersona_trabajador = '$this->id_trabajador_sesion'";	}

		if ( empty($filtro_trabajador) 	|| $filtro_trabajador 	== 'TODOS' ) { } else{	$filtro_sql_trab	= "AND pt.idpersona_trabajador = '$filtro_trabajador'";	}
		if ( empty($filtro_dia_pago) 		|| $filtro_dia_pago 		== 'TODOS' ) { } else{ 	$filtro_sql_dp 		= "AND DAY(pc.fecha_cancelacion)  = '$filtro_dia_pago'";	}
		if ( empty($filtro_plan) 				|| $filtro_plan 				== 'TODOS' ) { } else{	$filtro_sql_p 		= "AND pc.idplan = '$filtro_plan'";	}
		if ( empty($filtro_zona_antena) || $filtro_zona_antena 	== 'TODOS' ) { } else{	$filtro_sql_za 		= "AND pc.idzona_antena = '$filtro_zona_antena'";	}
		
		$sql = "SELECT pc.idpersona_cliente, LPAD(pc.idpersona_cliente, 5, '0') as idcliente, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan , pc.ip_personal, DAY(pc.fecha_cancelacion) AS dia_cancelacion, 
		pc.fecha_cancelacion, DATE_FORMAT(pc.fecha_cancelacion, '%d/%m/%Y') AS fecha_cancelacion_format, 	pc.fecha_afiliacion, pc.descuento,pc.estado_descuento,
		cp.nombre as centro_poblado, pc.nota, pc.usuario_microtick,
		CASE 
			WHEN p.tipo_persona_sunat = 'NATURAL' THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
			WHEN p.tipo_persona_sunat = 'JURÍDICA' THEN p.nombre_razonsocial 
			ELSE '-'
		END AS cliente_nombre_completo, 
		p.tipo_documento, p.numero_documento, p.celular, p.foto_perfil, p.direccion,p.distrito,p1.nombre_razonsocial AS trabajador_nombre, 
		pl.nombre as nombre_plan,pl.costo,za.nombre as zona, za.ip_antena,pc.estado, i.abreviatura as tipo_doc
		FROM persona_cliente as pc
		INNER JOIN persona AS p on pc.idpersona=p.idpersona
		INNER JOIN persona_trabajador AS pt on pc.idpersona_trabajador= pt.idpersona_trabajador
		INNER JOIN persona as p1 on pt.idpersona=p1.idpersona
		INNER JOIN plan as pl on pc.idplan=pl.idplan
		INNER JOIN zona_antena as za on pc.idzona_antena=za.idzona_antena
		INNER JOIN sunat_doc_identidad as i on p.tipo_documento=i.code_sunat  
		INNER JOIN centro_poblado as cp on pc.idcentro_poblado=cp.idcentro_poblado  
		where pc.estado_delete='1' $filtro_sql_trab $filtro_sql_dp $filtro_sql_p $filtro_sql_za
		ORDER BY pc.idpersona_cliente DESC";
		return ejecutarConsulta($sql);
	}

	// ══════════════════════════════════════  S E L E C T 2 ══════════════════════════════════════
	public function select2_filtro_trabajador()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "WHERE pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT LPAD(pt.idpersona_trabajador, 5, '0') as idtrabajador, pt.idpersona_trabajador, pt.idpersona,  per_t.nombre_razonsocial
		FROM persona_cliente as pc
		INNER JOIN persona_trabajador as pt ON pt.idpersona_trabajador = pc.idpersona_trabajador
		INNER JOIN persona as per_t ON per_t.idpersona = pt.idpersona
		$filtro_id_trabajador
		GROUP BY pc.idpersona_trabajador
		ORDER BY per_t.nombre_razonsocial;";
		return ejecutarConsulta($sql);
	}

	
	public function select2_filtro_dia_pago()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT DISTINCT DAY(pc.fecha_cancelacion) as dia_cancelacion
		FROM persona_cliente as pc $filtro_id_trabajador
		ORDER BY DAY(pc.fecha_cancelacion) ASC;";
		return ejecutarConsulta($sql);
	}

	public function select2_filtro_anio_pago()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT DISTINCT YEAR(pc.fecha_cancelacion) as anio_cancelacion
		FROM persona_cliente as pc $filtro_id_trabajador
		ORDER BY YEAR(pc.fecha_cancelacion) DESC;";
		return ejecutarConsulta($sql);
	}

	public function select2_filtro_plan()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT pl.idplan, pl.nombre, pl.costo
		FROM persona_cliente as pc
		INNER JOIN plan as pl ON pl.idplan = pc.idplan
		WHERE pl.estado = '1' and pl.estado_delete = '1' $filtro_id_trabajador
		GROUP BY pc.idplan ORDER BY pl.nombre;";
		return ejecutarConsulta($sql);
	}

	public function select2_filtro_zona_antena()	{
		$filtro_id_trabajador  = '';
		if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
			$filtro_id_trabajador = "AND pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
		} 
		$sql = "SELECT za.idzona_antena, za.nombre, za.ip_antena
		FROM persona_cliente as pc
		INNER JOIN zona_antena as za ON za.idzona_antena = pc.idzona_antena
		WHERE za.estado = '1' and za.estado_delete = '1' $filtro_id_trabajador
		GROUP BY pc.idzona_antena ORDER BY za.nombre;";
		return ejecutarConsulta($sql);
	}
	
	public function select2_plan()	{
		$sql = "SELECT idplan, nombre, costo FROM plan WHERE estado='1' and estado_delete='1';";
		return ejecutarConsulta($sql);
	}

	public function select2_zona_antena()	{
		$sql = "SELECT idzona_antena, nombre, ip_antena FROM zona_antena WHERE estado='1' and estado_delete='1';";
		return ejecutarConsulta($sql);
	}

	public function select2_trabajador(){
		$sql = "SELECT pt.idpersona_trabajador, p.idpersona, 
		CASE 
		WHEN p.tipo_persona_sunat = 'NATURAL' THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
		WHEN p.tipo_persona_sunat = 'JURÍDICA' THEN p.nombre_razonsocial 
		ELSE '-'
		END AS nombre_completo, 
		p.tipo_documento, p.numero_documento 
		FROM persona_trabajador pt 
		INNER JOIN persona AS p ON pt.idpersona = p.idpersona 
		WHERE pt.estado = '1' AND pt.estado_delete = '1' AND p.idtipo_persona = '2';";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function perfil_trabajador($id)	{
		$sql = "SELECT p.foto_perfil	FROM persona as p WHERE p.idpersona = '$id' ;";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function selec_centroProbl(){
		$sql="SELECT idcentro_poblado, nombre FROM centro_poblado WHERE estado='1' and estado_delete='1';";
		return ejecutarConsulta($sql);
	}
}
