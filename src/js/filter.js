$(document).ready(function () {
  $(".select_2_localites").select2({
    placeholder: "Localités",
    allowClear: true,
    debug: true,
    multiple: true,
    width: "resolve",
  });

  $(".select-custom-lib").click(function (event) {
    event.stopPropagation();
    $(".select-custom-container").removeClass("open");
    $(this).next().addClass("open");
    $(this).next().children().first().children().focus();
  });

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
});
