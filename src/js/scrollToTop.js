/* Scroll to top */

$("#scrollToTop").on("click", function () {
  $("html, body").animate({ scrollTop: 0 }, "slow");
});

window.addEventListener("scroll", function () {
  var scrollToTopBtn = document.querySelector("#scrollToTop");
  var scroll = window.scrollY;

  if (scroll > 350) {
    scrollToTopBtn.style.opacity = "1";
    scrollToTopBtn.style.right = "20px"; // Position finale pour l'animation
  } else {
    scrollToTopBtn.style.opacity = "0";
    scrollToTopBtn.style.right = "-140px"; // Position initiale pour l'animation
  }
});
