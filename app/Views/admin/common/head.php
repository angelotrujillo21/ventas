<meta charset="uft-8">
<meta name="author" content="MM">
<link rel="shortcut icon" href="<?=isset($user["sImagenEmpresa"]) && strlen($user["sImagenEmpresa"]) > 0 ? src("multi/" . $user["sImagenEmpresa"])  : (isset($user["sImagenSede"]) && strlen($user["sImagenSede"]) > 0 ? src("multi/" . $user["sImagenSede"]) :  src('app/shards-dashboards-logo.svg'))?>"  />
<title><?=isset($sTitulo) && !empty($sTitulo) ? $sTitulo : NOMBRE_SITIO?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />

<?php load_style([
    'bootstrap',
    'jquery-ui',
    'admin/style',
    'admin/shards-dashboards.1.1.0.min',
    'admin/extras.1.1.0.min',
    'admin/float-label'
    ]);


    load_style_plugin([
        'toast/toastr.min',
        'select2/select2',
        'select2/select2-bootstrap',
        'bootstrap-table/bootstrap-table',
        'summernote/summernote.min',
        'daterangepicker/daterangepicker',
    ]);
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

