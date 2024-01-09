// init
$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('.btn-add-to-cart').click(function () {
    const productId = $(this).data('product-id')
    $.ajax({
      method: "POST",
      url: apiAddToCart,
      data: { productId },
      beforeSend: function (xhr) {
        $('body').addClass('loading');
      }
    })
      .done(function (response) {
        $('body').removeClass('loading');
        if (response.error == true) {
          toastr.error(response.message)
        } else {
          toastr.success(response.message)
        }
      });
  })
  $('.btn-add-to-cart-quick').click(function () {
    const productId = $(this).data('product-id')
    $.ajax({
      method: "POST",
      url: apiQuickBuy,
      data: { productId },
      beforeSend: function (xhr) {
        $('body').addClass('loading');
      }
    })
      .done(function (response) {
        $('body').removeClass('loading');
        if (response.error == true) {
          toastr.error(response.message)
        } else {
          toastr.success(response.message)
          window.location.href = response.url;
        }
      });
  })
  function callfunc() {
    $(".func-plus").click(function () {
      const rowId = $(this).data('row-id')
      const num_frm = $('.box-number-' + rowId);
      const value_num = num_frm.val()
      if (value_num > 0) {
        const new_val = +value_num + 1
        if (new_val > 0) {
          $.ajax({
            method: "POST",
            url: apiUpdateQty,
            data: { rowId, qty: new_val },
            beforeSend: function (xhr) {
              $('body').addClass('loading');
            }
          })
            .done(function (response) {
              num_frm.val(new_val);
              $('body').removeClass('loading');
              $(".shopping-cart .header-open-cart .cart-count").text(response.count);
              $("#popup-shopping-card .products-block .tabIndex-01 .num").text(response.count)
              $("#sticky-price-box-sticky-wrapper #sticky-price-box .price-box .price").text(response.total + "đ");
              $("#sticky-price-box-sticky-wrapper #sticky-price-box .price-box .total-price").text(response.total + "đ");
            });
        } else {
          return false;
        }
      }
    })
    $(".func-minus").click(function () {
      const rowId = $(this).data('row-id')
      const num_frm = $('.box-number-' + rowId);
      const value_num = num_frm.val()
      if (value_num > 0) {
        const new_val = +value_num - 1
        if (new_val > 0) {
          $.ajax({
            method: "POST",
            url: apiUpdateQty,
            data: { rowId, qty: new_val },
            beforeSend: function (xhr) {
              $('body').addClass('loading');
            }
          }).done(function (response) {
            num_frm.val(new_val);
            $('body').removeClass('loading');
            $(".shopping-cart .header-open-cart .cart-count").text(response.count);
            $("#popup-shopping-card .products-block .tabIndex-01 .num").text(response.count)
            $("#sticky-price-box-sticky-wrapper #sticky-price-box .price-box .price").text(response.total + "đ");
            $("#sticky-price-box-sticky-wrapper #sticky-price-box .price-box .total-price").text(response.total + "đ");
          });
        } else {
          return false;
        }
      }
    })
    $('.btn-delete-item-cart').click(function () {
      const rowId = $(this).data('row-id')
      $.ajax({
        method: "POST",
        url: apiDeleteItem,
        data: { rowId },
        beforeSend: function (xhr) {
          $('body').addClass('loading');
        }
      })
        .done(function (response) {
          $('body').removeClass('loading');
          $('.item-cart-' + rowId).remove()
        });
    })
  }
  callfunc()
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
