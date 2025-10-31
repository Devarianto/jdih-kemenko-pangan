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
              <a href="{{ $cta->link }}" target="{{ $cta->target }}" class="external-link">
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
        <form method="POST" action="{{ route('contact.submit') }}">
          @csrf
          <div class="row row-wrap">
            <div class="column column-100 @error('name') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.name') }}</label>
              <input type="text" name="name" placeholder="{{ lang::translate('contact.form-placeholder.name') }}">
              @error('name')
              <div class="supporting-text">{{ $message }}</div>
              @enderror
            </div>
            <div class="column column-50 @error('email') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.email') }}</label>
              <input type="email" name="email" placeholder="{{ lang::translate('contact.form-placeholder.email') }}">
              @error('email')
              <div class="supporting-text">{{ $message }}</div>
              @enderror
            </div>
            <div class="column column-50 @error('phone') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.phone') }}</label>
              <input type="number" name="phone" placeholder="{{ lang::translate('contact.form-placeholder.phone') }}">
              @error('phone')
              <div class="supporting-text">{{ $message }}</div>
              @enderror
            </div>
            <div class="column column-100 @error('message') error-field @enderror">
              <label for="">{{ lang::translate('contact.form-title.message') }}</label>
              <textarea name="message" id="" placeholder="{{ lang::translate('contact.form-placeholder.message') }}"></textarea>
              @error('message')
              <div class="supporting-text">{{ $message }}</div>
              @enderror
            </div>
            <div class="column @error('g-recaptcha-response') error-field @enderror">
                {!! recaptcha::draw() !!}
                @error('g-recaptcha-response')
                <div class="supporting-text">{{ $message }}</div>
                @enderror
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
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        @if (Session::has('success'))
        openPopup('#popup-center');
        @endif
      });
    </script>
  @endpush
@endsection
