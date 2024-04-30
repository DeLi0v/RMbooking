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
      console.log("Status code: ", response.status);
    })
    .then(function (data) {
      elem.innerHTML = data;
    })
    .catch(function (err) {
      console.log("ERROR: ", err);
    });
}
