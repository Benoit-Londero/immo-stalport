const swiper = new Swiper(".swiper", {
  loop: true,
  autoplay: false,
  cssMode: true,

  pagination: {
    el: ".swiper-pagination",
  }
});

const swiper_about = new Swiper(".swiper-about", {
  loop: false,
  autoplay: false,
  cssMode : true,
  slidesPerView : 1,

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }
})

const swiper_estate = new Swiper(".swiper-estate", {
  spaceBetween: 10,
  
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }
})