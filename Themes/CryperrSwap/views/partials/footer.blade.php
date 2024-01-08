@php
$footer_logo = (setting('core::logo')) ? setting('core::logo') : Theme::url('images/logo.png');
$site_description = (setting('core::site-description')) ? setting('core::site-description') : "Cryperr Trading";
$site_name = (setting('core::site-name')) ? setting('core::site-name') : "Cryperr Trading";
@endphp

<footer>
  <div class="above">
    <div class="container-fluid">
      <div class="row g-2 g-lg-4">
        <div class="col-12 col-md-4">
          <div class="">
            <img src="{{$footer_logo}}" alt="" class="footer-logo me-3 me-md-0" />
            <div class="footer-description">
             {{$site_description}}
            </div>
          </div>
        </div>
        <div class="col-6 col-md-2">
          {{-- <div class="footer-menu-title">Company</div> --}}
          @menu('footer_1', 'footer_menu')
        </div>
        <div class="col-6 col-md-2">
          {{-- <div class="footer-menu-title">Company</div> --}}
          @menu('footer_2', 'footer_menu')

        </div>
        <div class="col-6 col-md-2">
          {{-- <div class="footer-menu-title">Company</div> --}}
          @menu('footer_3', 'footer_menu')

        </div>
        <div class="col-6 col-md-2">
          {{-- <div class="footer-menu-title">Company</div> --}}
          @menu('footer_4', 'footer_menu')

        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="below">
      <div class="left order-1 order-md-0">
        <div class="title">Copyright <span class="text-primary"> All Rights Reserved By {{$site_name}}. </span></div>
      </div>
      {{-- <div class="right order-0 order-md-1">
        <ul class="social-list">
          <li>
            <a>
              <img src="{{ Theme::url('images/socials/phone.png') }}"  alt="" />
            </a>
          </li>
          <li>
            <a>
              <img src="{{ Theme::url('images/socials/gmail.png') }}"  alt="" />
            </a>
          </li>
          <li>
            <a>
              <img src="{{ Theme::url('images/socials/apple.png') }}"  alt="" />
            </a>
          </li>
          <li>
            <a>
              <img src="{{ Theme::url('images/socials/facebook.png') }}"  alt="" />
            </a>
          </li>
          <li>
            <a>
              <img src="{{ Theme::url('images/socials/twitter.png') }}"  alt="" />
            </a>
          </li>
        </ul>
      </div> --}}
    </div>
  </div>
</footer>