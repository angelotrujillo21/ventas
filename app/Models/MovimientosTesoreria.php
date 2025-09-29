<?php



namespace Application\Models;



use Application\Core\Database as Database;



class MovimientosTesoreria

{

    private $db;



    public function __construct()

    {

        $this->db = new Database();

    }





    public function fncGrabarRegistro(

        $nIdCuentaCorriente,

        $sDescripcion,

        $nTipoEntidad,

        $nIdEntidad,

        $nTipo,

        $nMonto,

        $nTipoMoneda,

        $nTipoCambio,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLInsert("movimientostesoreria", [

            "nIdCuentaCorriente"  => $nIdCuentaCorriente,

            "sDescripcion"        => $sDescripcion,

            "nTipoEntidad"        => $nTipoEntidad,

            "nIdEntidad"          => $nIdEntidad,

            "nTipo"               => $nTipo,

            "nMonto"              => $nMonto,

            "nTipoMoneda"         => $nTipoMoneda,

            "nTipoCambio"         => $nTipoCambio,

            "dFechaRegistro"      => "NOW()",

            "nEstado"             => $nEstado,

        ]);



        return  $this->db->run($sSQL);

    }





    public function fncActualizarRegistro(

        $nIdMovimientoTesoreria,

        $nIdCuentaCorriente,

        $sDescripcion,

        $nTipoEntidad,

        $nIdEntidad,

        $nTipo,

        $nMonto,

        $nTipoMoneda,

        $nTipoCambio,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLUpdate("movimientostesoreria", [

            "nIdCuentaCorriente"  => $nIdCuentaCorriente,

            "sDescripcion"        => $sDescripcion,

            "nTipoEntidad"        => $nTipoEntidad,

            "nIdEntidad"          => $nIdEntidad,

            "nTipo"               => $nTipo,

            "nMonto"              => $nMonto,

            "nTipoMoneda"         => $nTipoMoneda,

            "nTipoCambio"         => $nTipoCambio,

            "dFechaRegistro"      => "NOW()",

            "nEstado"             => $nEstado,

        ], "nIdMovimientoTesoreria = $nIdMovimientoTesoreria");



        return  $this->db->run($sSQL);

    }





    public function fncEliminarRegistro($nIdMovimientoTesoreria)

    {

        $sSQL = $this->db->generateSQLDelete("movimientostesoreria", " nIdMovimientoTesoreria = $nIdMovimientoTesoreria ");

        $this->db->run($sSQL);

    }





    public function fncGetMovimientos($aryInput = [])

    {



        $aryAllFilters = [

            "sOrderBy"                   => "mt.nIdMovimientoTesoreria DESC",

            "sLimit"                     => null,

            "nIdMovimientoTesoreria"     => null,

            "nIdEmpresa"                 => null,

            "nIdSede"                    => null,

            "nTipo"                      => null,

            "dFechaRegistro"             => null,

            "nIdCuentaCorriente"         => null,

            "dFechaInicio"               => null,

            "dFechaFin"                  => null,

            "nTipoEntidad"               => null,

            "nIdEntidad"                 => null,

            "nEstado"                    => null,

            "nAnhio"                     => null,
            "nMes"                       => null
        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT  

                        mt.nIdMovimientoTesoreria,

                        mt.nIdCuentaCorriente,

                        mt.sDescripcion,

                        IFNULL(mt.nTipoEntidad, 0 ) AS nTipoEntidad,

                        mt.nIdEntidad,

                        mt.nTipo,

                        mt.nMonto,

                        mt.nTipoMoneda,

                        mt.nTipoCambio,

                        cc.sNumero AS sNumeroCC,

                        b.sNombre AS sBanco,

                        tc.sNombre AS sTipoCuenta,

                        UPPER(cc.sPropietario) AS sPropietario ,

                        IFNULL( DATE_FORMAT( mt.dFechaRegistro, '%d/%m/%Y' ), '' ) as dFechaRegistro, 

                        mt.nEstado,
                        YEAR(mt.dFechaRegistro) AS nAnhio,
                        CAST( MONTH(mt.dFechaRegistro) AS float ) AS nMes

                FROM movimientostesoreria AS mt 

                INNER JOIN cuentascorrientes AS cc ON mt.nIdCuentaCorriente = cc.nIdCuentaCorriente

                INNER JOIN bancos AS b ON cc.nIdBanco = b.nIdBanco 

                INNER JOIN tiposcuentas AS tc ON cc.nIdTipoCuenta = tc.nIdTipoCuenta";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdMovimientoTesoreria"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mt.nIdMovimientoTesoreria = {$this->db->quote($ary['nIdMovimientoTesoreria'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdCuentaCorriente"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mt.nIdCuentaCorriente = {$this->db->quote($ary['nIdCuentaCorriente'])}  ");

     

        $sWhere .= ($this->db->isNull($ary["nTipoEntidad"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mt.nTipoEntidad = {$this->db->quote($ary['nTipoEntidad'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdEntidad"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mt.nIdEntidad = {$this->db->quote($ary['nIdEntidad'])}  ");

 

        $sWhere .= ($this->db->isNull($ary["nTipo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mt.nTipo = {$this->db->quote($ary['nTipo'])}  ");



        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mt.nEstado = {$this->db->quote($ary['nEstado'])}  ");



        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(mt.dFechaRegistro)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

 

        $sWhere .= ($this->db->isNull($ary["dFechaRegistro"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(mt.dFechaRegistro) =  STR_TO_DATE( '" . $ary['dFechaRegistro'] . "', '%d/%m/%Y' )  ");


        $sWhere .= ($this->db->isNull($ary["nAnhio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " YEAR(mt.dFechaRegistro) = {$this->db->quote($ary['nAnhio'])}  ");

        $sWhere .= ($this->db->isNull($ary["nMes"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " CAST( MONTH(mt.dFechaRegistro) AS float) = {$this->db->quote($ary['nMes'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        // echo $sSQL . "<br>";
        // exit;



        return $this->db->run(trim($sSQL));

    }





    

    



}

