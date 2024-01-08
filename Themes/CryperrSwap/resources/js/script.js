// init
$(document).ready(function () {
  // Select UI
  $(".select").select2({
    width: "100%",
    placeholder: "Select network",
    dropdownAutoWidth: true,
  })

  // Date UI
  $('input[name="dates"]').daterangepicker()

  // QR Code deposit
  document.getElementById("qr-reader").innerHTML = ""
  new QRCode("qr-reader", {
    text: "TextToConvert",
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H,
  })
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
