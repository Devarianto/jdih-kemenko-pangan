@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper-content">
      @foreach(widget($menu->id, 'menu', 'content') as $content)
      <div class="middle__title">
        <h4>{{ $content->translated('title') }}</h4>
        <p>{{ $content->translated('description') }}</p>
      </div>
      @endforeach
      @foreach(widget($menu->id, 'menu', 'contact') as $contact)
      <div class="contact-highlight">
        <figure class="bg">
          <img src="{{ media::initial($contact->image)->url }}" 
            data-img-large="{{ media::initial($contact->image)->url }}" 
            data-img-medium="{{ media::initial($contact->value('image-medium'))->url }}" 
            data-img-small="{{ media::initial($contact->value('image-small'))->url }}" alt="{{ media::initial($contact->image)->alt }}">
        </figure>
        <div class="contact-highlight__left">
          <p>{{ $contact->translated('title') }}</p>
          <div class="wrap-col">
            <div class="col">
              <p>{{ $contact->address }}</p>
              @if($cta = $contact->childs('google-map')->first())
              <a href="{{ $cta->link }}" target="__BLANK" class="external-link">
                {{ $cta->translated('label') }}
              </a>
              @endif
            </div>
            <div class="col">
              <a href="tel:{{ $contact->phone }}">
                <i class="wa-icon wa-ic-phone-solid"></i>
                {{ $contact->phone }}
              </a>
              <a href="mailto:{{ $contact->email }}">
                <i class="wa-icon wa-ic-mail-solid"></i>
                {{ $contact->email }}
              </a>
            </div>
          </div>
        
        </div>
      </div>
      @endforeach
      <div class="box-form">
        <h5>{{ lang::translate('contact.title') }}</h5>
        <form method="POST" id="form-contact" action="{{ route('contact.submit') }}">
          @csrf
          <div class="row row-wrap">
            <div class="column column-100 @error('name') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.name') }}<i>*</i></label>
              <input type="text" class="required" name="name" maxlength="255" placeholder="{{ lang::translate('contact.form-placeholder.name') }}">
              <div class="supporting-text">@error('name'){{ $message }}@enderror</div>
            </div>
            <div class="column column-50 @error('email') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.email') }}<i>*</i></label>
              <input type="email" class="required email" name="email" maxlength="255" placeholder="{{ lang::translate('contact.form-placeholder.email') }}">
              <div class="supporting-text">@error('email'){{ $message }}@enderror</div>
            </div>
            <div class="column column-50 @error('phone') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.phone') }}<i>*</i></label>
              <input type="text" class="required number-only" name="phone" placeholder="{{ lang::translate('contact.form-placeholder.phone') }}" maxlength="13" minlength="10">
              <div class="supporting-text">@error('phone'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100 @error('message') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.message') }}<i>*</i></label>
              <textarea name="message" class="required" id="" placeholder="{{ lang::translate('contact.form-placeholder.message') }}"></textarea>
              <div class="supporting-text">@error('message'){{ $message }}@enderror</div>
            </div>
            <div class="column recaptcha-validate @error('g-recaptcha-response') error-field @enderror">
                <!-- khusus tempat render recaptcha -->
                <div class="recaptcha-container"></div>
                <div class="supporting-text">@error('g-recaptcha-response'){{ $message }}@enderror</div>
            </div>
            <div class="column column-100">
              <button type="submit" class="button button-gradient">{{ lang::translate('contact.form-button') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  @if (Session::has('success'))
  <div class="popup" id="popup-center">
    <div class="popup__overlay"></div>
    <div class="popup__box">
      <div class="popup__close">
        <i class="wa-icon wa-ic-close-solid"></i>
      </div>
      <div class="popup__content popup__content--center">
        <img src="{{asset('images/material/checklist-bullet.svg')}}" alt="">
        <h3>{{ lang::translate('contact.popup-success.title') }}</h3>
        <p>{{ lang::translate('contact.popup-success.message') }}</p>
        <a href="" class="button button-gradient">{{ lang::translate('contact.popup-success.button') }}</a>
      </div>
    </div>
  </div>
  @endif
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
    <style>
      button.is-disabled {
        background: grey !important;
        pointer-events: none;
      }
    </style>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        @if (Session::has('success'))
        openPopup('#popup-center');
        @endif

        document.getElementById("form-contact").addEventListener("submit", function (e) {
          let valid = true;
          const submitBtn = this.querySelector('button[type=submit]');
          submitBtn.textContent = "{{ lang::translate('contact.form-process') }}";
          submitBtn.disabled = true;
          submitBtn.classList.add("is-disabled");

          // ambil semua input di dalam form
          const inputs = this.querySelectorAll(".column input, .column textarea");
          inputs.forEach(input => {
            const parent = input.closest(".column");
            const msgBox = parent.querySelector(".supporting-text");

            // reset error terlebih dahulu
            parent.classList.remove("error-field");
            msgBox.textContent = "";

            const value = input.value.trim();

            // RULE: required
            if (input.classList.contains("required") && value === "") {
                parent.classList.add("error-field");
                msgBox.textContent = "{{ lang::translate('global.form-error.required') }}";
                valid = false;
                // return;
            }

            // RULE: email
            if (input.classList.contains("email") && value !== "" && !validateEmail(value)) {
                parent.classList.add("error-field");
                msgBox.textContent = "{{ lang::translate('global.form-error.email') }}";
                valid = false;
                // return;
            }

            // RULE: maxlength (baru)
            const max = input.getAttribute("maxlength");
            if (max && value.length > parseInt(max)) {
                parent.classList.add("error-field");
                msgBox.textContent = `{{ lang::translate('global.form-error.maxlength') }}`;
                msgBox.textContent = msgBox.textContent.replace(':max', max);
                valid = false;
                // return;
            }

            // RULE: minlength (baru)
            const min = input.getAttribute("minlength");
            if (min && value.length < parseInt(min)) {
                parent.classList.add("error-field");
                msgBox.textContent = `{{ lang::translate('global.form-error.minlength') }}`;
                msgBox.textContent = msgBox.textContent.replace(':min', min);
                valid = false;
                // return;
            }
          });

          const recaptchaField = document.querySelector(".recaptcha-validate textarea[name='g-recaptcha-response']");
          if (recaptchaField) {
              const recaptchaValue = recaptchaField.value.trim();

              if (recaptchaValue === "") {
                  // tampilkan error recaptcha di bagian custom
                  const recaptchaContainer = document.querySelector(".recaptcha-validate");
                  if (recaptchaContainer) {
                      recaptchaContainer.classList.add("error-field");

                      let msg = recaptchaContainer.querySelector(".supporting-text");
                      if (!msg) {
                          msg = document.createElement("div");
                          msg.classList.add("supporting-text");
                          recaptchaContainer.appendChild(msg);
                      }

                      msg.textContent = "{{ lang::translate('global.form-error.recaptcha') }}";
                  }

                  valid = false;
              }
          }

          // jika tidak valid, cegah submit
          if (!valid) {
            e.preventDefault();
            submitBtn.textContent = "{{ lang::translate('contact.form-button') }}";
            submitBtn.disabled = false;
            submitBtn.classList.remove("is-disabled");
          }
        });

        const numberInputs = document.querySelectorAll('.number-only');
        numberInputs.forEach(input => {
          input.addEventListener('input', function(e) {
            let value = e.target.value;
            value = value.replace(/[^0-9]/g, '');
            e.target.value = value;
          });
        });

        // fungsi regex email
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
      });
    </script>
  @endpush
@endsection
