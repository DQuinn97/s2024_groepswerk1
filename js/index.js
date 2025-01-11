import "../css/style.css";

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
});
