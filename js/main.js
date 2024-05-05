function openPage(name) {
  // функция для загрузки содержимого в блок .content при "переходе" на другую страницу
  console.log("Change page to: " + name);

  // снятие выделения со всех кнопок и его установка на кнопку соответсвующую открытой странице
  $(".tablinks").removeClass("active");
  $("#" + name + "Btn").addClass("active");

  // сохранение открытой страницы в локальное хранилище
  localStorage.setItem('lastPage', name);

  // запрос на сервер для получения и загрузки содержимого в блок .content
  // при ошибке происходит перезагрузка страницы
  const elem = $(".content");
  $.ajax({
    url: "/pages/" + name + ".php",
    type: "HEAD",
    success: function() {
      elem.load("/pages/" + name + ".php");
      console.log("Page changed");
    },
    error: function(xhr, status, error) {
      if(xhr.status == 503) {
        location.reload();
      } else {
        console.log("Файл '/pages/", name, ".php' не найден");
      }
    },
  });
}

function addStr(evt, page) {
  // функция для открытия формы создания новых данных при нажатии на кнопку "добавить"
  evt.preventDefault(); // Предотвращаем стандартное поведение

  const elem = $(".content");
  var params = {
    page: page,
  };

  elem.load("/pages/add.php", params);
}

function createStr(evt, page) {
  // функция для внесения новых данных в БД
  evt.preventDefault(); // Предотвращаем стандартное поведение

  // Проверяем валидность (заполненность) всех обязательных полей
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

  // если найдены незаполненные поля - завершаем выполнение функции
  if (!valid) {
    return;
  }

  // получение данных из формы
  var formData = $("#editForm").serialize();
  
  // отправка данных на сервер для создания новой записи в таблице
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
  // функция для удаления строки из БД
  evt.preventDefault(); // Предотвращаем стандартное поведение

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
  // функция для открытия формы изменения строки
  const elem = $(".content");
  var params = {
    id: id,
    page: page,
  };

  elem.load("/pages/edit.php", params);
}

function cancelEdit(evt, page) {
  // Функция для отмены создания/изменения данных в БД
  evt.preventDefault(); // Предотвращаем стандартное поведение

  const elem = $(".content");
  $.ajax({
    url: "/pages/" + page + ".php",
    type: "HEAD",
    success: () => elem.load("/pages/" + page + ".php"),
    error: () => console.log("Файл '/pages/", page, ".php' не найден"),
  });
}

function saveEdit(evt, page, id) {
  // функция для сохранения изменений строки в БД
  evt.preventDefault(); // Предотвращаем стандартное поведение

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

  // получаем данные из формы
  var formData = $("#editForm").serialize();

  // отправляем данные на сервер для внесения изменений в БД
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
  // функция для изменения выбранного периода времени на форме создания/изменения бронирования

  var time = ("0" + selectedTime).slice(-2) + ":" + "00" + ":00"; // формируем формат времени для БД

  var timeBlocks = document.querySelectorAll(".timeBlock"); // получаем все блоки времени
  var stop = false;

  // если выбранный блок времени имеет класс selectedOther - завершаем работу функции
  var selectedBlock = document.querySelector('[time="' + time + '"]');
  if (selectedBlock && selectedBlock.classList.contains("selectedOther")) {
    return;
  }  

  // перебираем все блоки, если у какого-то блока есть класс off - завершаем работу функции
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

  // получаем элемент формы для хранения данных о начальном и конечном времени бронирования
  var booking_time_begin = $("input[name='booking_time_begin']").eq(0);
  var booking_time_end = $("input[name='booking_time_end']").eq(0);

  // определяем куда сохранится выбранное время
  // если начальное и конечное время выбрано - сбрасываем значения и устанавливаем новое как начальное
  if (booking_time_begin.val() && booking_time_end.val()) {
    booking_time_begin.val(time);
    booking_time_end.val("");
  // если начальное значение незаполненно - заполняем
  } else if (!booking_time_begin.val()) {
    booking_time_begin.val(time);
  // если конечное значение не заполнено и выбранное время меньше чем начальное
  } else if (!booking_time_end.val() && time <= booking_time_begin.val()) {
    booking_time_end.val(booking_time_begin.val()); // меняем местами начальное и конечное время
    booking_time_begin.val(time); // устанавливаем выбранное время как начальное
  // иначе заполняем конечное время
  } else {
    booking_time_end.val(time);
  }

  // Подсвечиваем выбранный начальный блок времени
  if (booking_time_begin.val()) {
    var startBlock = document.querySelector(
      '[time="' + booking_time_begin.val() + '"]'
    );
    startBlock.classList.add("select");
  }

  // Подсвечиваем выбранный период времени, если начальное и конечно значения выбраны
  stop = false;
  if (booking_time_begin.val() && booking_time_end.val()) {
    var endBlock = document.querySelector(
      '[time="' + booking_time_end.val() + '"]'
    );

    // установка конечного времени
    booking_time_end.val(booking_time_end.val().replace(/\d{2}:\d{2}$/, "59:59"));

    // получение стоимости аренды комнаты за 1 час
    var price = 0;
    $.ajax({
      url: "/components/get_price.php",
      method: "POST",
      async: false,
      data: { room: $("#room").val() },
      success: function(response) {
          price = response;
      },
      error: function(xhr, status, error) {
          console.error("Ошибка получения списка помещений:", error);
      }
    });    
    
    // выделение периода времени и подсчет количества часов
    var hours = 1;
    while (startBlock && startBlock !== endBlock) {
      // если в период вермени попало время, выбранное другим клиентом - отменяем
      if (startBlock.classList.contains("selectedOther")) {
        stop = true;
      }
      startBlock.classList.add("select");
      startBlock = startBlock.nextElementSibling;
      hours++;
    }

    // если найдено время дургого клиента
    if (stop) {
      booking_time_end.val(booking_time_begin.val().replace(/\d{2}:\d{2}$/, "59:59")); // устанавливаем конечное время как конец часа начального времени

      $('.timeBlock').removeClass('select'); // убираем выделение у всех блоков времени
      document.querySelector('[time="' + booking_time_begin.val() + '"]').classList.add("select"); // устанавливаем выделение для начального времени
    // иначе
    } else {
      endBlock.classList.add("select"); // заканчиваем выделять перод выделением последнего блока времени
      $("#sum").prop("disabled", false).val("");  // делаем доступным для изменения поле "Стоимость"
      $("#create").prop("disabled", false); // делаем доступным для нажатия кнопку "Создать"

      // Если цена и часы не пустые - расчитываем стоимость и подставляем в соответствующее поле
      if (price != 0 && hours != 0) {
        var totalPrice = price * hours;
        $("#sum").val(totalPrice)
      }

      console.log("Price: " + price);
      console.log("Hours: " + hours);
    }
  // иначе, если какое-то из времен не выбрано
  } else {
    $("#sum").prop("disabled", true).val(""); // отключаем досутпность и обнуляем поле "Стоимость"
    $("#create").prop("disabled", true); // отключаем доступность кнопке "Создать"
  }
  console.log("Time begin (end): " + booking_time_begin.val());
  console.log("Time end (end): " + booking_time_end.val());
}
