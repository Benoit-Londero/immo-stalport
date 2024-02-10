const swiper = new Swiper(".swiper", {
  loop: true,
  autoplay: true,
  cssMode: true,

  pagination: {
    el: ".swiper-pagination",
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

const swiperResp = new Swiper(".swiper-resp", {
  slidesPerView: "auto",
  loop: true,
  autoplay: true,
  slidesPerGroup: 1,
  cssMode: true,
  slidesPerView: 1,
});
