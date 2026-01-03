window.addEventListener("load", function () {
  const loader = document.getElementById("loader");

  if (loader) {
    loader.style.opacity = "0";
    loader.style.transition = "opacity 0.5s ease";

    setTimeout(function () {
      loader.style.setProperty("display", "none", "important");

      loader.style.pointerEvents = "none";
    }, 500);
  }
});
