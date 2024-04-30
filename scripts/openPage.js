function openPage(evt, name) {
  // Declare all variables
  var i, tablinks, tabcontent;

  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  evt.currentTarget.className += " active";

  const elem = document.querySelector(".content");
  elem.innerHTML = "";

  fetch("../pages/" + name + ".php")
    .then(function (response) {
      if (!response.ok) {
        // Если статус не в диапазоне 200-299, генерируем ошибку
        throw new Error("Network response was not ok");
      }
      // Преобразуем ответ в текст
      return response.text();
    })
    .then(function (data) {
      elem.innerHTML = data;
    })
    .catch(function (err) {
      contentElement.innerHTML = "<p>Error loading content.</p>";
      console.error(
        "There has been a problem with your fetch operation:",
        error
      );
    });
}
