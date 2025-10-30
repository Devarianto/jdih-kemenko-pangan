<div class="accordion ai-faq" id="openAiFaq">
  @foreach($faq as $k => $faq)
  <div class="accordion-item">
    <h2 class="accordion-header" id="faq{{$k}}">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{$k}}" aria-expanded="false" aria-controls="faqCollapse{{$k}}">
        {{ array_get($faq, 'question') }}
      </button>
    </h2>
    <div id="faqCollapse{{$k}}" class="accordion-collapse collapse" aria-labelledby="faq{{$k}}" data-bs-parent="#openAiFaq">
      <div class="accordion-body">{!! array_get($faq, 'answer') !!}</div>
    </div>
  </div>
  @endforeach
</div>