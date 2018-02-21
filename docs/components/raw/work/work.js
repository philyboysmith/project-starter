$(document).ready(function() {

    $(".c-work-filter__item a").on("click", function(e) {
    e.preventDefault();
    $(".c-work-filter__item a").removeClass('active');
    $(this).addClass("active");
    var hash = $(this).attr("href"),
        target = $(hash);
    target
      .siblings()
      .fadeOut(250);
    target.delay(250).fadeIn();
  });
});
