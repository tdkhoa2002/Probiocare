// init
$(document).ready(function () {

  // QR Code deposit
  // document.getElementById("qr-reader").innerHTML = ""
  // new QRCode("qr-reader", {
  //   text: "TextToConvert",
  //   width: 200,
  //   height: 200,
  //   colorDark: "#000000",
  //   colorLight: "#ffffff",
  //   correctLevel: QRCode.CorrectLevel.H,
  // })
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

})

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
