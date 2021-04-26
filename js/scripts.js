/* Dore Theme Select & Initializer Script 

Table of Contents

01. Css Loading Util
02. Theme Selector And Initializer
*/

/* 01. Css Loading Util */
function loadStyle(href, callback) {
  for (var i = 0; i < document.styleSheets.length; i++) {
    if (document.styleSheets[i].href == href) {
      return;
    }
  }
  var head = document.getElementsByTagName("head")[0];
  var link = document.createElement("link");
  link.rel = "stylesheet";
  link.type = "text/css";
  link.href = href;
  if (callback) {
    link.onload = function () {
      callback();
    };
  }
  var mainCss = $(head).find('[href$="main.css"]');
  if (mainCss.length !== 0) {
    mainCss[0].before(link);
  } else {
    head.appendChild(link);
  }
}

/* 02. Theme Selector, Layout Direction And Initializer */
(function ($) {
  if ($().dropzone) {
    Dropzone.autoDiscover = false;
  }

  var themeColorsDom = '<div class="theme-colors"><div class="p-4"><p class="text-muted mb-2">Light Theme</p><div class="d-flex flex-row justify-content-between mb-4"><a href="#" data-theme="dore.light.blue.min.css" class="theme-color theme-color-blue"></a><a href="#" data-theme="dore.light.purple.min.css" class="theme-color theme-color-purple"></a><a href="#" data-theme="dore.light.green.min.css" class="theme-color theme-color-green"></a><a href="#" data-theme="dore.light.orange.min.css" class="theme-color theme-color-orange"></a><a href="#" data-theme="dore.light.red.min.css" class="theme-color theme-color-red"></a></div><p class="text-muted mb-2">Dark Theme</p><div class="d-flex flex-row justify-content-between"><a href="#" data-theme="dore.dark.blue.min.css" class="theme-color theme-color-blue"></a><a href="#" data-theme="dore.dark.purple.min.css" class="theme-color theme-color-purple"></a><a href="#" data-theme="dore.dark.green.min.css" class="theme-color theme-color-green"></a><a href="#" data-theme="dore.dark.orange.min.css" class="theme-color theme-color-orange"></a><a href="#" data-theme="dore.dark.red.min.css" class="theme-color theme-color-red"></a></div></div><div class="p-4"><p class="text-muted mb-2">Border Radius</p><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="roundedRadio" name="radiusRadio" class="custom-control-input radius-radio" data-radius="rounded"><label class="custom-control-label" for="roundedRadio">Rounded</label></div><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="flatRadio" name="radiusRadio" class="custom-control-input radius-radio" data-radius="flat"><label class="custom-control-label" for="flatRadio">Flat</label></div></div><div class="p-4"><p class="text-muted mb-2">Direction</p><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="ltrRadio" name="directionRadio" class="custom-control-input direction-radio" data-direction="ltr"><label class="custom-control-label" for="ltrRadio">Ltr</label></div><div class="custom-control custom-radio custom-control-inline"><input type="radio" id="rtlRadio" name="directionRadio" class="custom-control-input direction-radio" data-direction="rtl"><label class="custom-control-label" for="rtlRadio">Rtl</label></div></div><a href="#" class="theme-button"> <i class="simple-icon-magic-wand"></i> </a></div>';

  //$("body").append(themeColorsDom);


  /* Default Theme Color, Border Radius and  Direction */
  var theme = "dore.light.blue.min.css";
  var direction = "ltr";
  var radius = "rounded";

  if (typeof Storage !== "undefined") {
    if (localStorage.getItem("dore-theme")) {
      theme = localStorage.getItem("dore-theme");
    } else {
      localStorage.setItem("dore-theme", theme);
    }
    if (localStorage.getItem("dore-direction")) {
      direction = localStorage.getItem("dore-direction");
    } else {
      localStorage.setItem("dore-direction", direction);
    }
    if (localStorage.getItem("dore-radius")) {
      radius = localStorage.getItem("dore-radius");
    } else {
      localStorage.setItem("dore-radius", radius);
    }
  }

  $(".theme-color[data-theme='" + theme + "']").addClass("active");
  $(".direction-radio[data-direction='" + direction + "']").attr("checked", true);
  $(".radius-radio[data-radius='" + radius + "']").attr("checked", true);
  $("#switchDark").attr("checked", theme.indexOf("dark") > 0 ? true : false);

  loadStyle("css/" + theme, onStyleComplete);
  function onStyleComplete() {
    setTimeout(onStyleCompleteDelayed, 300);
  }

  function onStyleCompleteDelayed() {
    $("body").addClass(direction);
    $("html").attr("dir", direction);
    $("body").addClass(radius);
    $("body").dore();
  }

  $("body").on("click", ".theme-color", function (event) {
    event.preventDefault();
    var dataTheme = $(this).data("theme");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-theme", dataTheme);
      window.location.reload();
    }
  });

  $("input[name='directionRadio']").on("change", function (event) {
    var direction = $(event.currentTarget).data("direction");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-direction", direction);
      window.location.reload();
    }
  });

  $("input[name='radiusRadio']").on("change", function (event) {
    var radius = $(event.currentTarget).data("radius");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-radius", radius);
      window.location.reload();
    }
  });

  $("#switchDark").on("change", function (event) {
    var mode = $(event.currentTarget)[0].checked ? "dark" : "light";
    if (mode == "dark") {
      theme = theme.replace("light", "dark");
    } else if (mode == "light") {
      theme = theme.replace("dark", "light");
    }
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-theme", theme);
      window.location.reload();
    }
  });

  $(".theme-button").on("click", function (event) {
    event.preventDefault();
    $(this)
      .parents(".theme-colors")
      .toggleClass("shown");
  });

  $(document).on("click", function (event) {
    if (
      !(
        $(event.target)
          .parents()
          .hasClass("theme-colors") ||
        $(event.target)
          .parents()
          .hasClass("theme-button") ||
        $(event.target).hasClass("theme-button") ||
        $(event.target).hasClass("theme-colors")
      )
    ) {
      if ($(".theme-colors").hasClass("shown")) {
        $(".theme-colors").removeClass("shown");
      }
    }
  });
  //***************************************** */
  $("#employeAdd").click(function(){
    //
    renderAddEmploye();
    $("#exampleModalRight").modal('show');
  });
  $("#departmentAdd").click(function(){
    renderAddDepartment();
    $("#exampleModalRight").modal('show');
  });
  $("#itemAdd").click(function(){
    renderAddItem();
    $("#exampleModalRight").modal('show');
  });
  /**
   * Показывает оповещение
   * @param {*тип оповещения} type 
   * @param {*заголовок} title 
   * @param {*текст оповещения} message 
   */
  function showNotify(type,title, message){
    $.notify({
      // options
      icon: 'glyphicon glyphicon-warning-sign',
      title: title,
      message: message
    },{
      // settings
      element: 'body',
      position: null,
      type: type,
      placement: {
        from: "bottom",
        align: "right"
      },
    });
  }
  /**
   * Рендер формы добавления сотрудника
   */
  function renderAddEmploye(){
    $("#modalForm").empty();
    $.ajax({
      method: "POST",
      dataType: 'json',
      url: "api/getDepartmentsList.php",
      data:{OrgID:$("#OrgID").val()}
    }).done(function( msg ) {
      var name = '<div class="form-group"><label>Имя: </label><input required type="text" class="form-control" placeholder="" name="shortname" id="shortname" /></div>';
      var sorname = '<div class="form-group"><label>Фамилия: </label><input required type="text" class="form-control" placeholder="" name="sorname" id="sorname" /></div>';
      var thirdname = '<div class="form-group"><label>Отчество: </label><input required type="text" class="form-control" placeholder="" name="thirdname" id="thirdname" /></div>';
      var position = '<div class="form-group"><label>Должность: </label><input required type="text" class="form-control" placeholder="" name="position" id="position" /></div>';
      var departmentStart ='<div class="form-group"><label>Отдел/Цех: </label><select name="department" id="department" class="form-control">';
      var options = '<option value="0" selected >Укажите...</option>';
      var typeForm = '<input type="hidden" value="employe" id="employe" />';
      for (let i = 0; i < msg.length; i++) {
        options += '<option value="'+msg[i].id+'" >'+msg[i].name+'</option>';
      }
      var departmentEnd = '</select></div>';
      $("#modalForm").append(sorname+name+thirdname+position+departmentStart+options+departmentEnd+typeForm);
    }).fail(function(msg){
      console.log(msg);
      showNotify('danger','Ошибка!','Посмотри консоль разработчика!');
    });
    $(".modal-title").text("Добавить сотрудника");
  }
  /**
   * Рендер формы добавления отдела
   */
  function renderAddDepartment(){
    $("#modalForm").empty();
    $(".modal-title").text("Добавить отдел");
  }
  /**
   * Рендер формы добавления едениц учета
   */
  function renderAddItem(){
    $("#modalForm").empty();
    $(".modal-title").text("Добавить единицу учета");
  }
  function addEmploye(){
    var shortName = $("#shortname").val(), sorname =$("#sorname").val(), thirdname = $("#thirdname").val(), position = $("#position").val(), dep = $("#department").val();
    if(dep!=0){
      $.ajax({
        method: "POST",
        dataType: 'json',
        url: "api/setEmploye.php",
        data:{shortName:shortName, sorname:sorname, thirdname:thirdname, position:position, department:dep}
      }).done(function( msg ) {
        console.log(msg);
        showNotify('success','Успех!','Успешно добавлен новый сотрудник!');
        $("#exampleModalRight").modal("hide");
      }).fail(function(msg){
        $("#exampleModalRight").modal("hide");
        console.log(msg);
        showNotify('danger','Ошибка!','Посмотри консоль разработчика!');
      });
    }
    else {
      $("#exampleModalRight").modal("hide");
      showNotify('warning','Внимание!','Укажите отдел!');
    }
  }
  $("#formSubmit").click(function(){
    var type = $("#employe").val();
    switch(type){
      case 'employe':
        addEmploye();
        break;
      default:
        break;
    }
  });
})(jQuery);
