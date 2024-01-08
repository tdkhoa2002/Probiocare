// init
$(document).ready(function () {

  $('.copy-wrap').click(function (e) {
    const copyText = $(this).parents('.group-input-custom').find('input')
    copyText.select();
    document.execCommand("copy");
    $(this).children('div.copy-notify').css("display", "block")
    setTimeout(() => {
      $(this).children('div.copy-notify').css("display", "none")
    }, 3000);
  })
  $(".box-modal-verify-code .box-code input").jqueryPincodeAutotab();

  $('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
  })
  var hash = location.hash.replace(/^#/, '');
  if (hash) {
    $('.nav-tabs a[href="#' + hash + '"]').tab('show');
  }

  $('.togglePassword').click(function () {
    $(this).toggleClass("active");
    const input = $(this).parents('.input-group-password').find('input');
    if ($(this).hasClass("active")) {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  })
  changeMinheightMain();

})

window.addEventListener('resize', function (event) {
  changeMinheightMain();
}, true);

function changeMinheightMain() {
  const hFooter = $('footer').height();
  $('main').css('min-height', `calc(100vh - ${hFooter}px)`)
}

// Toggle drawer token detail
function toggleDrawerTokenDetail(e, visible) {
  e.preventDefault

  const container = document.getElementById("drawer_token_info")
  if (visible) {
    container.classList.add("show")
  } else {
    container.classList.remove("show")
  }
}
