function fncOcultarLoader() {
  $(".page-loader").fadeOut();
}

function fncMostrarLoader() {
  $(".page-loader").fadeIn();
}

function fncClearInputs(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      switch (this.type) {
        case "number":
          if (this.name.substring(0, 9) == "nCantidad") {
            $(this).val(1);
          } else {
            $(this).val(0);
          }

          break;
        case "select-one":
        case "select-multiple":
          if (this.name.substring(0, 7) == "nEstado") {
            $(this).val(1);
          } else {
            $(this).val(0);
          }
          break;
        case "file":
          $(this).val("");
          var attr = $(this).attr("multiple");
          if (typeof attr !== typeof undefined && attr !== false) {
            $(this)
              .parent()
              .find(".custom-file-label")
              .html("Seleccione los archivos");
          } else {
            $(this)
              .parent()
              .find(".custom-file-label")
              .html("Selecciona un archivo");
          }
          break;
        case "email":
        case "password":
        case "text":
        case "date":
        case "time":
        case "tel":
        case "textarea":
          $(this).val("");
          break;
        case "checkbox":
        case "radio":
          this.checked = bFlag;
      }
    });
}

function fncAddDisabled(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(".modal-body")
    .find(":input")
    .each(function () {
      $(this).attr("disabled", "disabled");
    });

  $(sHtmlTag)
    .find(".modal-footer")
    .find(":input")
    .each(function () {
      $(this).attr("disabled", "disabled");
    });
}

function fncRemoveDisabled(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      $(this).removeAttr("disabled");
    });
}

function fncAddDisabledForm(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      $(this).attr("disabled", "disabled");
    });
}

function fncRemoveDisabledForm(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      $(this).removeAttr("disabled");
    });
}

function fncViewForm(sHtmlTag, sTitle) {
  $(sHtmlTag).find(".modal-dialog").find(".modal-title").html(sTitle);
  fncAddDisabled(sHtmlTag);
}

function fncEditForm(sHtmlTag, sTitle) {
  $(sHtmlTag).find(".modal-dialog").find(".modal-title").html(sTitle);
  fncRemoveDisabled(sHtmlTag);
}

// Cambia el MaxLength para un text or txtarea según el tipo de documento
function fncMaxLengthTypeDocument(sTypeDocument, sHtmlTag) {
  if (sTypeDocument.indexOf("RUC") >= 0) {
    $(sHtmlTag).prop("maxlength", "11");
  } else if (sTypeDocument.indexOf("DNI") >= 0) {
    $(sHtmlTag).prop("maxlength", "8");
  } else if (
    sTypeDocument.indexOf("EXT") >= 0 ||
    sTypeDocument.indexOf("PAS") >= 0
  ) {
    $(sHtmlTag).prop("maxlength", "12");
  } else {
    $(sHtmlTag).prop("maxlength", "15");
  }
}

function src(path = "") {
  return web_root_resource + "images/" + path;
}

function route(path = "") {
  return web_root + path;
}

function copyToClipboard(sHtmlTag) {
  var copyText = document.getElementById(sHtmlTag);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
}

$(document).ready(function () {
  $.fn.select2.defaults.set("theme", "bootstrap");
});

function fncValidateEmail(sString) {
  if (
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(
      sString
    )
  ) {
    // Email correcto
    return true;
  }
  return false;
}

function fncNf(sInput) {
  return parseFloat(sInput).toFixed(2);
}

function fncDrawSelect(
  aryLista,
  sNameorId,
  sItemValue,
  sItemOption,
  nEstatusItemOne = true,
  sClass = "form-control",
  nRequerido = 0
) {
  sHtml = ``;
  sHtml += `<select name="${sNameorId}" class="${sClass}" id="${sNameorId}" data-nrequerido="${nRequerido}">`;
  sHtml += nEstatusItemOne ? `<option value="0">Seleccionar</option>` : ``;
  if (aryLista.length > 0) {
    aryLista.forEach((element) => {
      sHtml += `<option value="${
        sItemValue == "" ? element : element[sItemValue]
      }">${sItemOption == "" ? element : element[sItemOption]}</option>`;
    });
  }
  sHtml += `</select>`;
  return sHtml;
}

function fncDrawInput(
  sNameorId,
  sType,
  sPlaceHolder = "",
  sClass = "form-control",
  nRequerido = 0
) {
  sHtml = `<input type="${sType}" placeholder="${sPlaceHolder}" id="${sNameorId}" name="${sNameorId}"  class="${sClass}" autocomplete="off" data-nrequerido="${nRequerido}" />`;
  return sHtml;
}

function fncDrawTextArea(
  sNameorId,
  sPlaceHolder = "",
  sClass = "form-control",
  nRequerido = 0,
  cols = "2",
  rows = "2"
) {
  sHtml = `<textarea rows="${rows}" cols="${cols}" placeholder="${sPlaceHolder}" id="${sNameorId}" name="${sNameorId}"  class="${sClass}" data-nrequerido="${nRequerido}"></textarea>`;
  return sHtml;
}

function fncDrawRadio(aryLista, sNameorId, nRequerido = 0, sClassExtra = "") {
  sHtml = ``;
  if (aryLista.length > 0) {
    aryLista.forEach(function (element, nIndex) {
      sHtml += `<div class="custom-control custom-radio">
                      <input data-nrequerido="${nRequerido}" type="radio" id="${sNameorId}-${nIndex}" name="${sNameorId}" value="${element}" class="custom-control-input ${sClassExtra}">
                      <label class="custom-control-label ml-label-radio w-100" for="${sNameorId}-${nIndex}">${element}</label>
                  </div>`;
    });
  }
  return sHtml;
}

function fncUc(str) {
  var str = str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
    return letter.toUpperCase();
  });
  return str;
}

function fncDesplegarSgt(elemet) {
  $(elemet).next("div.order-items").toggleClass("order-items-visible");
  return false;
}


// var idleTime = 0;
// var idleInterval;
// $(document).ready(function () {
//   //Increment the idle time counter every minute.
//   idleInterval = setInterval(timerIncrement, 60000); // 1 minute

//   //Zero the idle timer on mouse movement.
//   $(this).mousemove(function (e) {
//     idleTime = 0;
//   });

//   $(this).keypress(function (e) {
//     idleTime = 0;
//   });
// });

// function timerIncrement() {
//   idleTime = idleTime + 1;
//   if (idleTime > 29) {
//     // 29 minutes
//     clearInterval(idleInterval);
//     alert("Su session caduco");
//     window.location = "salir";
//   }
// }



window.fncOcultarAside = function () {
  //console.log("ocularaside");
  var mq = window.matchMedia( "(max-width: 768px)" );
  if (mq.matches) {
    // console.log("mobile");
    //el ancho de la ventana es inferior a 570 px
  } else {
    // el ancho de la ventana es mayor que 570px
   // console.log("desktop");
    if (!$(".main-sidebar").hasClass("d-none")) {
       $("#btn-toogle-desktop").trigger("click");
    }
  }
};






function sp(input, pad = "00000000") {
  var str = "" + input;
  return pad.substring(0, pad.length - str.length) + str;
}



function pf(input) {
  return parseFloat(input).toFixed(2);
}



function fncGetNameMesById(nIdMes)
{
     var mes = "";
    nIdMes = parseInt(nIdMes);
    switch (nIdMes) {
        case "01":
        case 1:
            mes = "Enero";
            break;
        case "02":
        case 2:
            mes = "Febrero";
            break;
        case "03":
        case 3:
            mes = "Marzo";
            break;
        case "04":
        case 4:
            mes = "Abril";
            break;
        case "05":
        case 5:
            mes = "Mayo";
            break;
        case "06":
        case 6:
            mes = "Junio";
            break;
        case "07":
        case 7:
            mes = "Julio";
            break;
        case "08":
        case 8:
            mes = "Agosto";
            break;
        case "09":
        case 9:
            mes = "Septiembre";
            break;
        case "10":
        case 10:
            mes = "Octubre";
            break;
        case "11":
        case 11:
            mes = "Noviembre";
            break;
        case "12":
        case 12:
            mes = "Diciembre";
            break;
    }
    return mes;
}


/* Type 1 PREGUNTA , TYPE 2 Mensaje , TYPE 3 Mensaje success */
function fncMsg(stype, sMsg, fncCallbackSucces, fncCallbackCancel = null, jsnOptions = null) {
  if (stype == 1) {

    Swal.fire({
      title: sMsg,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
      confirmButtonColor: '#007bff',
    //  cancelButtonColor: '#FF4B4B',
    }).then((result) => {

      if (result.isConfirmed) {
        fncCallbackSucces();
      } else {
      if(fncCallbackCancel != null) fncCallbackCancel();
      }

    });

  } else if (stype == 2){
    
    Swal.fire({
      title: sMsg,
      icon: 'info',
      showCancelButton: false,
      confirmButtonText: 'ok',
      confirmButtonColor: '#007bff',
    }).then((result) => {

      if (result.isConfirmed) {
        fncCallbackSucces();
      } else {
      if(fncCallbackCancel != null) fncCallbackCancel();
      }

    });
  }  else if (stype == 3){
    
    Swal.fire({
      title: sMsg,
      icon: 'success',
      showCancelButton: false,
      confirmButtonText: 'ok',
      confirmButtonColor: '#a5dc86',
    }).then((result) => {

      if (result.isConfirmed) {
        fncCallbackSucces();
      } else {
      if(fncCallbackCancel != null) fncCallbackCancel();
      }

    });
  }
}



function fncCleanQuotes(str){
  return str.replace(/['"]+/g, '')
}