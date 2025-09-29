window.setTimeout(function () {
  $(".alert")
    .fadeTo(500, 0)
    .slideUp(500, function () {
      $(this).remove();
    });
}, 2000);

$(document).ready(function () {
  $(".menu-collap").on("click", function () {
    $(".main-sidebar").toggleClass("show");
  });

  $(document).on("show.bs.modal", ".modal", function (event) {
    var zIndex = 1040 + 10 * $(".modal:visible").length;

    $(this).css("z-index", zIndex);

    setTimeout(function () {
      $(".modal-backdrop")
        .not(".modal-stack")
        .css("z-index", zIndex - 1)
        .addClass("modal-stack");
    }, 0);
  });
  // Para que ningun modal se pueda cerrar tiene que darle click en la X
  $(document)
    .find(".modal")
    .each(function () {
      $(this).attr("data-backdrop", "static");
      $(this).attr("data-keyboard", "false");
    });

  $.datepicker.regional["es"] = {
    closeText: "Cerrar",
    prevText: "< Ant",
    nextText: "Sig >",
    currentText: "Hoy",
    monthNames: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ],
    monthNamesShort: [
      "Ene",
      "Feb",
      "Mar",
      "Abr",
      "May",
      "Jun",
      "Jul",
      "Ago",
      "Sep",
      "Oct",
      "Nov",
      "Dic",
    ],
    dayNames: [
      "Domingo",
      "Lunes",
      "Martes",
      "Miércoles",
      "Jueves",
      "Viernes",
      "Sábado",
    ],
    dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    weekHeader: "Sm",
    dateFormat: "dd/mm/yy",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "",
  };

  $.fn.daterangepicker = {
    locale: {
      format: "YYYY-MM-DD",
      separator: " - ",
      applyLabel: "Guardar",
      cancelLabel: "Cancelar",
      fromLabel: "Desde",
      toLabel: "Hasta",
      customRangeLabel: "Personalizar",
      daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Setiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      firstDay: 1,
    },
  };

  $('input[type="file"]').change(function () {
    var text =
      this.files.length > 1
        ? "Existen " + this.files.length + " archivos."
        : this.files[0].name;
    $(this).next().html(text);
  });
});

$(function () {
  setTimeout(function () {
    $(".page-loader").fadeOut();
  }, 500);

  $(".datepicker").datepicker();
});

$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $(".datepicker").datepicker();

  $("#btn-toogle-desktop").on("click", function () {
    if ($("aside").hasClass("d-none")) {
      // Oculto
      $("aside").removeClass("d-none");
      $("main").removeClass("col-md-12");

      $("main").addClass("col-lg-10");
      $("main").addClass("col-md-9");
      $("main").addClass("offset-lg-2");
      $("main").addClass("offset-md-3");
    } else {
      $("main").removeClass("col-lg-10");
      $("main").removeClass("col-md-9");
      $("main").removeClass("offset-lg-2");
      $("main").removeClass("offset-md-3");

      $("main").addClass("col-md-12");
      $("aside").addClass("d-none");
    }
  });

  // if ($(".daterange").length > 0) {
  //   $(".daterange").each(function () {
  //     var sHtmlTag = $(this).attr("id");

  //      fncDateRange("#" + sHtmlTag);
  //   });
  // }
});

$(document).ready(function () {
  $(".nav-submenus").hide();

  $(".item-padre").on("click", function () {
    var bActive = false;
    var nIdModulo = $(this).data("id");
    var subMenu = $("#nav-submenu-" + nIdModulo);

    $(".nav-submenus").each(function () {
      if (
        $(this).data("id") == nIdModulo &&
        $(this).css("display") == "block"
      ) {
        bActive = true;
        $(".nav-submenus").hide();
        return false;
      }
    });

    if (bActive) {
      return;
    } else {
      $(".nav-submenus").hide();
      subMenu.toggle();
    }
  });
});

$.datepicker.regional["es"] = {
  closeText: "Cerrar",
  prevText: "< Ant",
  nextText: "Sig >",
  currentText: "Hoy",
  monthNames: [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ],
  monthNamesShort: [
    "Ene",
    "Feb",
    "Mar",
    "Abr",
    "May",
    "Jun",
    "Jul",
    "Ago",
    "Sep",
    "Oct",
    "Nov",
    "Dic",
  ],
  dayNames: [
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado",
  ],
  dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
  dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
  weekHeader: "Sm",
  dateFormat: "dd/mm/yy",
  firstDay: 1,
  isRTL: false,
  showMonthAfterYear: false,
  yearSuffix: "",
};

$.datepicker.setDefaults($.datepicker.regional["es"]);

$(document).ready(function () {
  $(".content-password")
    .find(".btnToggleVisible")
    .on("click", function () {
      if ($(this).data("visible") == true) {
        $(this).find(".icon-view").show();
        $(this).find(".icon-slash").hide();
        $(this).parent().find(".input-password").attr("type", "text");
        $(this).data("visible", false);
      } else {
        $(this).find(".icon-view").hide();
        $(this).find(".icon-slash").show();
        $(this).parent().find(".input-password").attr("type", "password");
        $(this).data("visible", true);
      }

      $(this).parent().find(".input-password").focus();
    });

  $(`li[data-submenupadre="true"]`).on("click", function () {
    var nIdSubModulo = $(this).data("nidsubmodulo");

    console.log(
      $(this),
      nIdSubModulo,
      $(`li[data-nidpadresubmenu="${nIdSubModulo}"]`)
    );

    $(`li[data-nidpadresubmenu="${nIdSubModulo}"]`).each(function () {
      $(this).toggle();
    });
  });
});

$(function () {
  var current = location.pathname;
  $("li a.nav-link").each(function () {
    var $this = $(this);
    // if the current path is like this link, make it active
    if ($this.attr("href").indexOf(current) !== -1) {
      $this.addClass("menu-link-active");
      var nidpadresubmenu = $this.parent().data("nidpadresubmenu");

      if (nidpadresubmenu == 0) {
        var nIdMod = $this.parent().parent().data("id");
        $("#mod" + nIdMod).click();
      } else {
        $("li[data-nidsubmodulo='" + nidpadresubmenu + "']").click();
        var nIdMod = $("li[data-nidsubmodulo='" + nidpadresubmenu + "']")
          .parent()
          .data("id");
        $("#mod" + nIdMod).click();
      }
    }
  });
});

var idleTime = 0;

$(document).ready(function () {
  // Aplica esta funcion para todas las vistas exectp la de login

  if ($("body").data("nvistalogin") != "1") {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
      idleTime = 0;
    });
    $(this).keypress(function (e) {
      idleTime = 0;
    });
  }

  fncDrawNotificaciones();
});

function timerIncrement() {
  if (
    window.location.pathname.search("ncliente") >= 0 ||
    
    window.location.pathname.search("/acceso") >= 0
  ) {
    console.log("no calcula login");
  } else {


    idleTime = idleTime + 1;
    
    if (idleTime > 5) {
      //  5 minutes
      $.ajax({
        type: "post",
        dataType: "json",
        url: web_root + "funciones/fncValidarSession",
        beforeSend: function () {},
        success: function (data) {
          if (data.error) {
            alert(
              "Ups. Se acabo la session porfavor vuelve a iniciar session . Gracias"
            );
            location.href = data.sRuta;
          }
        },
        complete: function () {},
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr);
          console.log(thrownError);
        },
      });
    }

    console.log("calcula login");
  }
}

$(".img-referencial").on("click", function (event) {
  event.preventDefault();
  event.stopPropagation();
  $("#mdlVerImagenImg").attr("src", $(this).attr("src"));
  $("#mdlVerImagen").modal("show");
});

function fncDrawNotificaciones() {
  if ($("#li-noti").is(":visible")) {
    fncObtenerMensajesAdmin(null, (aryData) => {
      if (aryData.success) {
        var sHtml = ``;
        var aryData = aryData.aryData;

        $("#count-noti").html(aryData.length);

        if (aryData.length > 0) {
          aryData.forEach((aryElement) => {
            sHtml += `
                    <a class="dropdown-item items" href="javascript:;">
                      <div class="notification__icon-wrapper">
                          <div class="notification__icon">
                              <i class="material-icons">message</i>
                          </div>
                      </div>
                      <div class="notification__content">
                          <span class="notification__category">NOTIFICACION</span>
                          <p style="text-transform: uppercase;">${
                            aryElement.sProducto +
                            (aryElement.sCodigoInternoProducto.length > 0
                              ? " - " + aryElement.sCodigoInternoProducto
                              : "") +
                            " " +
                            aryElement.sUnidadMedidaProducto
                          } , ha pasado su stock minimo de ${
              aryElement.nStockMinimo
            } 
                          , stock actual ${aryElement.nStockActual}</p>
                      </div>
                    </a>`;
          });

          $("#content-noti").html(sHtml);
        }
      } else {
        toastr.error(aryData.error);
      }
    });
  }
}

function fncObtenerMensajesAdmin(jsnData, fncCallback) {
  $.ajax({
    type: "post",
    dataType: "json",
    url: web_root + "funciones/fncObtenerMensajes",
    data: jsnData,
    beforeSend: function () {},
    success: function (data) {
      fncCallback(data);
    },
    complete: function () {},
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr);
      console.log(thrownError);
    },
  });
}

/**

 Tipo  1 : Pregunta
 Tipo 2 : Mensaje de dialogo

 */
