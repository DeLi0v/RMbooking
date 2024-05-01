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

function deleteStr(evt, id, page) {
  console.log("Delete: ", id);

  evt.preventDefault(); // Предотвращаем стандартное поведение ссылки

  // Отправляем AJAX запрос на сервер для удаления строки
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/pages/delete.php", false);
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
  console.log("Edit: ", id);

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
  // evt.preventDefault(); // Предотвращаем стандартное поведение ссылки

  // Проверяем валидность формы
  var form = $("#editForm");
  if (!form.checkValidity()) {
    // Если форма не прошла валидацию, выходим из функции
    return;
  }

  var formData = form.serialize();

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
