/*!
 * Start Bootstrap - SB Admin v6.0.3 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */

(function ($) {
  "use strict";

  // Add active state to sidbar nav links
  var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
  $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
    if (this.href === path) {
      $(this).addClass("active");
    }
  });

  // Toggle the side navigation
  $("#sidebarToggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
  });
})(jQuery);

function SendPassword() {
  // emailjs
  //   .send(
  //     "service_ar0ifgb",
  //     "template_tgio32o",
  //     {
  //       send_to: "mmrkjhn@gmail.com",
  //       generated_pwd: document.getElementById("generated_pwd").value,
  //     },
  //     {
  //       publicKey: "lR9LmmL0XNeKWf5V5",
  //     }
  //   )
  //   .then(() => {
  //     alert("OK");
  //   });
  alert("Noice");
}
