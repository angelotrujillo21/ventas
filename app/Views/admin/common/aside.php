<!-- Main Sidebar -->
<?php if (isset($bShowMenu) && $bShowMenu == true) : ?>
    <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
        <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                <a class="navbar-brand w-100 mr-0" href="<?=route($user["sModuloDefault"])?>">
                    <div class="d-flex flex-center w-100">
                        <img id="main-logo" class="d-inline-block align-top mr-1 img-logo" src="<?=strlen($user["sImagenEmpresa"]) > 0 ? src("multi/" . $user["sImagenEmpresa"])  : (strlen($user["sImagenSede"]) > 0 ? src("multi/" . $user["sImagenSede"]) :  src('app/shards-dashboards-logo.svg'))?>" alt="">
                        <span class="d-none d-md-inline ml-1">
                        </span>
                    </div>
                </a>
                <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none menu-collap cursor-pointer">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </nav>
        </div>


        <div class="nav-wrapper">

            <ul class="nav flex-column">

                <?php if (isset($user["aryModulos"]) && fncValidateArray($user["aryModulos"])) : ?>
                    <?php foreach ($user["aryModulos"] as $aryModulo) : ?>
                        <div class="menu-item">
                            <li data-id="<?= $aryModulo["nIdModulo"] ?>" class="nav-item padre item-padre">
                                <a class="nav-link  item-menu" href="javascript:;" role="button" data-id="<?= $aryModulo["nIdModulo"] ?>" id="mod<?= $aryModulo["nIdModulo"] ?>">
                                    <i class="material-icons"><?= $aryModulo["sIconoModulo"] ?></i>
                                    <span> <?= $aryModulo["sModulo"] ?> </span>
                                </a>
                            </li>
                            <div id="nav-submenu-<?= $aryModulo["nIdModulo"] ?>" data-id="<?= $aryModulo["nIdModulo"] ?>" class="nav-submenus">
                                <?php foreach ($aryModulo["arySubModulos"] as $arySubModulo) : ?>
                                    <li <?= $arySubModulo["nIdPadre"] != "0" ? " style = ' display : none; ' " : ""; ?> data-nidsubmodulo="<?= $arySubModulo["nIdSubModulo"] ?>" <?= $arySubModulo["sUrl"] == "#" ? " data-submenupadre = 'true' " : ''; ?> data-nidpadresubmenu="<?= $arySubModulo["nIdPadre"] ?>" class="nav-item <?= $arySubModulo["nIdPadre"] != "0" ? "ml-2" : "" ?>">
                                        <a class="nav-link reportes item__menu__link" href="<?= $arySubModulo["sUrl"] == "#" ? "javascript:;"  : route(trim($arySubModulo["sUrl"])) ?>">

                                            <i class="material-icons"><?= $arySubModulo["sIconoSubmodulo"] ?></i>

                                            <span> <?= $arySubModulo["sNombreSubmodulo"] ?></span>

                                            <?php if ($arySubModulo["sUrl"] == "#") :  ?>
                                                <i class="material-icons">arrow_drop_down</i>
                                            <?php endif ?>

                                        </a>
                                    </li>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>

            </ul>

        </div>
    </aside>
<?php endif ?>