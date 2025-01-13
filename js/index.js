import "../css/style.css";

let modal = document.getElementById("modal");
let modal_open = document.getElementById("open_modal");
let modal_close = document.getElementById("close_modal");
let modal_input = document.getElementById("modal_input");

document.getElementById("profile").onclick = (e) => {
  let target = e.target.querySelector("section");
  target.style.display = target.style.display == "none" ? "block" : "none";

  let nav = document.getElementById("menu-toggle");
  if (nav.checked) nav.checked = false;
};
window.addEventListener("click", function (e) {
  if (!document.getElementById("profile").contains(e.target)) {
    document.getElementById("profile").querySelector("section").style.display =
      "none";
  }
  if (e.target == modal) {
    modal.style.display = "none";
  }
});
modal_open.onclick = function () {
  modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
modal_close.onclick = function () {
  modal.style.display = "none";
};
