function openPage(evt, name) {
  // Declare all variables
  var i, tablinks;

  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  evt.currentTarget.className += " active";

  const elem = $(".content");
  $.ajax({
    url: "/pages/" + name + ".php",
    type: "HEAD",
    success: () => elem.load("/pages/" + name + ".php"),
    error: () => console.log("Файл '/pages/", name, ".php' не найден"),
  });
}

function addStr(evt, page) {
  evt.preventDefault();

  const elem = $(".content");
  var params = {
    page: page,
  };

  elem.load("/pages/add.php", params);
}

function createStr(evt, page) {
  evt.preventDefault(); // Предотвращаем стандартное поведение ссылки

  // Проверяем валидность всех обязательных полей
  var valid = true;
  $("#editForm [required]").each(function () {
    if (!$(this).val()) {
      // Если поле не заполнено, добавляем класс для подсветки
      $(this).addClass("highlight");
      valid = false;
    } else {
      // Если поле заполнено, удаляем класс подсветки (если был добавлен)
      $(this).removeClass("highlight");
    }
  });

  if (!valid) {
    return;
  }

  var formData = $("#editForm").serialize();
  
  $.ajax({
    url: "/components/create.php", // Файл на сервере для обработки данных
    type: "POST",
    data: { page: page, formData: formData },
    success: function (response) {
      const elem = $(".content");
      elem.load("/pages/" + page + ".php");
    },
    error: function (xhr, status, error) {
      console.error("Ошибка сохранения:", error);
    },
  });
}

function deleteStr(evt, id, page) {
  evt.preventDefault(); // Предотвращаем стандартное поведение ссылки

  // Отправляем AJAX запрос на сервер для удаления строки
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/components/delete.php", false);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Обновляем страницу после успешного удаления
      const elem = $(".content");
      elem.load("/pages/" + page + ".php");
    }
  };
  xhr.send("id=" + id + "&table=" + page);
}

function editStr(evt, id, page) {
  const elem = $(".content");
  var params = {
    id: id,
    page: page,
  };

  elem.load("/pages/edit.php", params);
}

function cancelEdit(evt, page) {
  evt.preventDefault(); // Предотвращаем стандартное поведение ссылки

  const elem = $(".content");
  $.ajax({
    url: "/pages/" + page + ".php",
    type: "HEAD",
    success: () => elem.load("/pages/" + page + ".php"),
    error: () => console.log("Файл '/pages/", page, ".php' не найден"),
  });
}

function saveEdit(evt, page, id) {
  evt.preventDefault(); // Предотвращаем стандартное поведение ссылки

  // Проверяем валидность всех обязательных полей
  var valid = true;
  $("#editForm [required]").each(function () {
    if (!$(this).val()) {
      // Если поле не заполнено, добавляем класс для подсветки
      $(this).addClass("highlight");
      valid = false;
    } else {
      // Если поле заполнено, удаляем класс подсветки (если был добавлен)
      $(this).removeClass("highlight");
    }
  });

  if (!valid) {
    return;
  }

  var formData = $("#editForm").serialize();

  $.ajax({
    url: "/components/save_edit.php", // Файл на сервере для обработки данных
    type: "POST",
    data: { page: page, id: id, formData: formData },
    success: function (response) {
      const elem = $(".content");
      elem.load("/pages/" + page + ".php");
    },
    error: function (xhr, status, error) {
      console.error("Ошибка сохранения:", error);
    },
  });
}

function selectTime(selectedTime) {

  var time = ("0" + selectedTime).slice(-2) + ":" + "00" + ":00";

  var timeBlocks = document.querySelectorAll(".timeBlock");
  var stop = false;


  var selectedBlock = document.querySelector('[value="' + time + '"]');
  if (selectedBlock && selectedBlock.classList.contains("selectedOther")) {
    return;
  }  

  timeBlocks.forEach(function (block) {
    if (block.classList.contains("off")) {
      stop = true;
      return;
    } else {
      block.classList.remove("select"); 
    }
  });

  if (stop) {
    return;
  }

  var booking_time_begin = $("input[name='booking_time_begin']").eq(0);
  var booking_time_end = $("input[name='booking_time_end']").eq(0);

  if (booking_time_begin.val() && booking_time_end.val()) {
    booking_time_begin.val(time);
    booking_time_end.val("");
  } else if (!booking_time_begin.val()) {
    booking_time_begin.val(time);
  } else if (!booking_time_end.val() && time <= booking_time_begin.val()) {
    booking_time_end.val(booking_time_begin.val());
    booking_time_begin.val(time);
  } else {
    booking_time_end.val(time);
  }

  // Подсвечиваем выбранные блоки времени
  if (booking_time_begin.val()) {
    var startBlock = document.querySelector(
      '[time="' + booking_time_begin.val() + '"]'
    );
    startBlock.classList.add("select");
  }

  // Подсвечиваем выбранный период времени
  stop = false;
  if (booking_time_begin.val() && booking_time_end.val()) {
    var endBlock = document.querySelector(
      '[time="' + booking_time_end.val() + '"]'
    );

    booking_time_end.val(time.replace(/\d{2}:\d{2}$/, "59:59"));

    while (startBlock && startBlock !== endBlock) {
      if (startBlock.classList.contains("selectedOther")) {
        stop = true;
        return;
      }
      startBlock.classList.add("select");
      startBlock = startBlock.nextElementSibling;
    }
    if (stop) {
      booking_time_end.val("");
      return;
    }
    endBlock.classList.add("select");
    $("#sum").prop("disabled", false).val("");
  } else {
    $("#sum").prop("disabled", true).val("");
  }
}
