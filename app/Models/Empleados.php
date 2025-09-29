<?php



namespace Application\Models;



use Application\Core\Database as Database;



class Empleados

{

    private $db;



    public function __construct()

    {

        $this->db = new Database();

    }



    public function fncGrabarRegistro(

        $nIdEmpresa,

        $nIdSede,

        $nTipoDocumento,

        $sNumeroDocumento,

        $sNombre,

        $sDireccion,

        $sTelefono,

        $sCorreo,

        $sLogin,

        $sClave,

        $nIdRol,

        $sImagen,

        $nPorcentajeComision,

        $nDelivery,

		$nCajaEmpleado,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLInsert("empleados", [

            "nIdEmpresa"                => $nIdEmpresa,

            "nIdSede"                   => $nIdSede,

            "nTipoDocumento"            => $nTipoDocumento,

            "sNumeroDocumento"          => $sNumeroDocumento,

            "sNombre"                   => $sNombre,

            "dFechaCreacion"            => "NOW()",

            "sDireccion"                => $sDireccion,

            "sTelefono"                 => $sTelefono,

            "sCorreo"                   => $sCorreo,

            "sLogin"                    => $sLogin,

            "sClave"                    => $sClave,

            "nIdRol"                    => $nIdRol,

            "sImagen"                   => $sImagen,

            "nPorcentajeComision"       => $nPorcentajeComision,

            "nDelivery"                 => $nDelivery,

			"nCajaEmpleado"             => $nCajaEmpleado,

            "nEstado"                   => $nEstado,

        ]);



        // echo $sSQL;

        // exit;



        return  $this->db->run($sSQL);

    }





    public function fncActualizarRegistro(

        $nIdEmpleado,

        $nIdEmpresa,

        $nIdSede,

        $nTipoDocumento,

        $sNumeroDocumento,

        $sNombre,

        $sDireccion,

        $sTelefono,

        $sCorreo,

        $sLogin,

        $sClave,

        $nIdRol,

        $sImagen,

        $nPorcentajeComision,

        $nDelivery,

		$nCajaEmpleado,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLUpdate("empleados", [

            "nIdEmpresa"                => $nIdEmpresa,

            "nIdSede"                   => $nIdSede,

            "nTipoDocumento"            => $nTipoDocumento,

            "sNumeroDocumento"          => $sNumeroDocumento,

            "sNombre"                   => $sNombre,

            "dFechaCreacion"            => "NOW()",

            "sDireccion"                => $sDireccion,

            "sTelefono"                 => $sTelefono,

            "sCorreo"                   => $sCorreo,

            "sLogin"                    => $sLogin,

            "sClave"                    => $sClave,

            "nIdRol"                    => $nIdRol,

            "sImagen"                   => $sImagen,

            "nPorcentajeComision"       => $nPorcentajeComision,

            "nDelivery"                 => $nDelivery,

			"nCajaEmpleado"             => $nCajaEmpleado,

            "nEstado"                   => $nEstado,

        ], "nIdEmpleado = $nIdEmpleado");



        return  $this->db->run($sSQL);

    }



    public function fncEliminarRegistro($nIdEmpleado)

    {

        $sSQL = $this->db->generateSQLDelete("empleados", " nIdEmpleado = $nIdEmpleado ");

        return $this->db->run($sSQL);

    }





    public function fncGetEmpleados($aryInput = [])

    {



        $aryAllFilters = [

           // "sOrderBy"           => null,

		   "sOrderBy"            => "emp.nIdEmpleado desc",

            "sLimit"             => null,

            "nIdEmpleado"        => null,

            "nIdEmpleadoNot"     => null,

            "nTipoDocumento"     => null,

            "sNumeroDocumento"   => null,

            "nIdEmpresa"         => null,

            "nIdSede"            => null,

            "sLogin"             => null,

            "sClave"             => null,

            "sCorreo"            => null,

            "aryEmpleados"       => null,

            "nDelivery"          => null,

			"nCajaEmpleado"      => null,

            "nEstado"            => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

		

        $sSQL = "SELECT  

                    emp.nIdEmpleado,

                    emp.nIdEmpresa,

                    emp.nIdSede,

                    emp.nTipoDocumento,

                    emp.sNumeroDocumento,

                    UPPER(emp.sNombre) AS sNombre,

                    IFNULL(empre.sImagen,'') AS sImagenEmpresa,

                    IFNULL(sed.sImagen,'') AS sImagenSede,

                    IFNULL(empre.sNombre,'') AS sEmpresa,

                    IFNULL(sed.sNombre,'') AS sSede,

                    IFNULL(rol.sNombreRol,'') AS sNombreRol,

                    IFNULL( tipodoc.sDescripcionCortaItem,'' ) AS sTipoDoc, 

                    IFNULL( DATE_FORMAT( emp.dFechaCreacion , '%d/%m/%Y %H:%i:%s' ), '' ) as dFechaCreacion,

                    IFNULL( DATE_FORMAT( emp.dFechaEdicion , '%d/%m/%Y %H:%i:%s' ), '' ) as dFechaEdicion,

                    emp.sDireccion,

                    emp.sCorreo,

                    emp.sTelefono,

                    emp.nIdRol,

                    emp.sLogin,

                    emp.sClave,

                    emp.sImagen,

                    emp.nPorcentajeComision,

                    emp.nDelivery,

					emp.nCajaEmpleado,

                    emp.nEstado

                FROM empleados AS emp 

                INNER JOIN empresas AS empre ON emp.nIdEmpresa = empre.nIdEmpresa

                INNER JOIN sedes AS sed ON emp.nIdSede = sed.nIdSede

                INNER JOIN roles AS rol ON emp.nIdRol = rol.nIdRol

                LEFT JOIN catalogotabla AS tipodoc ON emp.nTipoDocumento = tipodoc.nIdCatalogoTabla";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdEmpleado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nIdEmpleado = {$this->db->quote($ary['nIdEmpleado'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdEmpleadoNot"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nIdEmpleado <> {$this->db->quote($ary['nIdEmpleadoNot'])}  ");



        $sWhere .= ($this->db->isNull($ary["nTipoDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nTipoDocumento = {$this->db->quote($ary['nTipoDocumento'])}  ");



        $sWhere .= ($this->db->isNull($ary["sNumeroDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.sNumeroDocumento = {$this->db->quote($ary['sNumeroDocumento'])}  ");



        $sWhere .= ($this->db->isNull($ary["sCorreo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.sCorreo = {$this->db->quote($ary['sCorreo'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");



        $sWhere .= ($this->db->isNull($ary["sLogin"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.sLogin = {$this->db->quote($ary['sLogin'])}  ");



        $sWhere .= ($this->db->isNull($ary["sClave"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.sClave = {$this->db->quote($ary['sClave'])}  ");



        $sWhere .= ($this->db->isNull($ary["nDelivery"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nDelivery = {$this->db->quote($ary['nDelivery'])}  ");

		

		$sWhere .= ($this->db->isNull($ary["nCajaEmpleado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nCajaEmpleado = {$this->db->quote($ary['nCajaEmpleado'])}  ");



        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nEstado = {$this->db->quote($ary['nEstado'])}  ");



        $sWhere .= ($this->db->isNull($ary["aryEmpleados"]) && !is_array($ary["aryEmpleados"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' emp.nIdEmpleado IN (' . implode(",", $ary['aryEmpleados']) . ')');



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        // echo $sSQL;

        // exit;



        return $this->db->run(trim($sSQL));

    }

}

