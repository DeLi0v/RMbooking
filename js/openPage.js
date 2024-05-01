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
