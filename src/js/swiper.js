require("fslightbox");

const swiper = new Swiper(".swiper", {
  loop: true,
  autoplay: false,
  cssMode: true,
  speed: 500,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

const swiper_about = new Swiper(".swiper-about", {
  loop: false,
  autoplay: false,
  cssMode: true,
  slidesPerView: 1,

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

const swiper_mea = new Swiper(".swiper-mea", {
  loop: false,
  autoplay: false,
  cssMode: true,
  slidesPerView: 1,

  navigation: {
    nextEl: ".swiper-button-next-2",
    prevEl: ".swiper-button-prev-2",
  },
});

const swiper_estate = new Swiper(".swiper-estate", {
  spaceBetween: 10,
  slidesPerView: 3,

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
    },
    640: {
      slidesPerView: 3,
    },
  },
});
