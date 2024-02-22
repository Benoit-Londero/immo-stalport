import inView from "in-view";
import gsap from "gsap";

$(document).ready(function () {
  //IN-VIEW
  if (document.querySelector(".from-left")) {
    document.querySelector(".from-left").classList.add("invisible");
  }
  if (document.querySelector(".from-right")) {
    document.querySelector(".from-right").classList.add("invisible");
  }
  if (document.querySelector(".from-top")) {
    document.querySelector(".from-top").classList.add("invisible");
  }
  if (document.querySelector(".from-bottom")) {
    document.querySelector(".from-bottom").classList.add("invisible");
  }

  function makeMagic(data, direction) {
    data.classList.remove("invisible");
    data.classList.add(direction);
  }

  function removeMagic(data, direction) {
    data.classList.add("invisible");
    data.classList.add(direction);
  }

  inView.offset(150);

  inView(".from-left").on("enter", (el) => {
    makeMagic(el, "fade-in-left");
  });

  inView(".from-right").on("enter", (el) => {
    makeMagic(el, "fade-in-right");
  });

  inView(".from-bottom").on("enter", (el) => {
    makeMagic(el, "fade-in-bottom");
  });

  inView(".from-top").on("enter", (el) => {
    makeMagic(el, "fade-in-top");
  });

  /* ANIMATION NUMBER */
  const counters = document.querySelectorAll(".animate-number");
  const speed = 100;

  inView(".grid_stats").on("enter", (e) => {
    counters.forEach((counter) => {
      const animate = () => {
        const value = +counter.dataset.number;
        const data = +counter.innerText;

        const time = value / speed;
        if (data < value) {
          counter.innerText = Math.ceil(data + time);

          if (value < 100) {
            setTimeout(animate, 40);
          } else {
            setTimeout(animate, 2);
          }
        } else {
          counter.innerTexte = value;
        }
      };

      animate();
    });
  });

  /** Toggle Details */

  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }
});


/* Filtres */

$(".select-custom-container").click(function (event) {
  if (!$(this).hasClass("one-only")) {
    event.stopPropagation();
  }
  let inputs = $(this).children().children("input").toArray();
  let valueSelected = "";
  inputs.forEach((element) => {
    if ($(element).is(":checked")) {
      let separateValue = ", ";
      if ($(element).attr("type") == "radio") {
        separateValue = "";
      }
      valueSelected += $(element).parent().text() + separateValue;
    }
  });

  let isCheck = inputs.find((elem) => $(elem).is(":checked"));

  if (!isCheck) {
    $(this)
      .prev()
      .children("span")
      .text($(this).prev().children("span").data("lib"));
  } else {
    $(this).prev().children("span").text(valueSelected);
  }
});

$(".select-custom-container .auto-focus").on("keyup", function (elem) {
  const filterValue = $(this).val();
  const containerElem = $(this).parent().parent();
  let elemToFilter = containerElem.children().not(":first-child");
  //innerText
  elemToFilter.each(function () {
    const value = $(this).children(".title").text().toLowerCase();
    const regExp = "/" + value + "/g";
    if (value.indexOf(filterValue.toLowerCase()) < 0) {
      $(this).addClass("hide");
    } else {
      $(this).removeClass("hide");
    }
  });
});

$(window).click(function () {
  //Hide the menus if visible
  $(".select-custom-container").removeClass("open");
});

$(
  ".faq > .question > .toggle-question, .accordeon > .toggle-accordeon"
).click(function () {
  $(this).children(".icon").toggleClass("open");
  $(this).next(".entry-content, .accordeon-content").toggleClass("toggle");
  $(this).next(".entry-content, .accordeon-content").toggle(300);
});

$('input[type="file"]').change(function (e) {
  $(this).parent().prev().text(e.target.files[0].name);
});