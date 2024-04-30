function openPage(evt, name) {
  // Declare all variables
  var i, tablinks, tabcontent;

  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  evt.currentTarget.className += " active";

  const elem = $(".content");
  elem.load("../pages/" + name + ".php");
}
