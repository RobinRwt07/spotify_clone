function opensongform() {
  document.getElementById("addsongbox").style.display = "block";
}

function closesongform() {
  document.getElementById("addsongbox").style.display ="none";
}

function openartistform() {
  document.getElementById("addartistsection").style.display = "block";
}

function closeartistform() {
  document.getElementById("addartistsection").style.display = "none";
}

// for addsongbox
var modal = document.getElementById('addsongbox');

// When the user clicks anywhere outside of the box, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

