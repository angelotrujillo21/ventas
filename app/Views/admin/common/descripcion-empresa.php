
<?php if (isset($user["sEmpresa"]) && isset($user["sSede"])) : ?>
    <div class="card foot-emp-sede" id="foot-empresa-sede">
        Conectado a <b> <?= $user["sEmpresa"] . " - ". $user["sSede"] ?> </b>
    </div>
<?php endif ?>