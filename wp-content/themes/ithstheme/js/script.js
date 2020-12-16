console.log("Nira");
var counter = 1;
setInterval(function () {
  document.getElementById('radio' + counter).checked = true;
  counter++;
  if (counter > 4) {
    counter = 1;
    console.log("Showing image: " + counter);
  }
}, 2000);