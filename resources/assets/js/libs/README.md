# How to use libs plugin js

### 1. accordion.js

```
<div class="faq">
  <div class="accordion">
    <a href="" class="head">
      Lorem ipsum dolor accordion 1
      <span class="ico"></span>
    </a>
    <div class="content">
      Because the rock was laid down in layers, there is a variation in the hardness of the rock formed. When water runoff trickles across the rock, some areas erode rapidly whereas others hold firm.
    </div>
  </div>
  <div class="accordion">
    <a href="" class="head">
      Lorem ipsum dolor accordion 2
      <span class="ico"></span>
    </a>
    <div class="content">
      Because the rock was laid down in layers, there is a variation in the hardness of the rock formed. When water runoff trickles across the rock, some areas erode rapidly whereas others hold firm.
    </div>
  </div>
</div>
```

```javascript
import $ from 'jquery' //import jquery module
import accordion from './libs/accordion' //import the js file

accordion($).init($('.faq .accordion')) //$('.faq .accordion') the accordion element
```

### 2. animating.js

* The element must be postion: relative / absolute
* if you use absolute element make sure position top,right unset, and for your postioning recommendation using transform: translate(0,0)
* trigger-anim is parameter html to trigger animation when user scrolling
* delay is parameter for delay trigger animation when user scrolling, delay value is in second

```
<section class="about-us">
  <div class="trigger trigger-1"></div>
  <div class="wrapper">
    <div class="row">
      <div class="column column-40">
       <figure>
          <div class="animating-element" delay="0.5" trigger-anim=".trigger-1">
            <img src="{{ asset('images/contents/home-about-2.jpg') }}" alt="home about" />
          </div>
        </figure>
      </div>
    </div>
  </div>
</div>
```

```javascript
import $ from 'jquery' //import jquery module
import animating from './libs/animating' //import the js file
import { gsap } from 'gsap' // import the gsap module

//init the js
const animatingElement = $(".animating-element") //element
animating($,gsap)
  .from({
    element: animatingElement,
    from: 'swipe-vertical', //animation type 'from-top','from-bottom','from-left','from-right','fade','swipe-horizontal','swipe-vertical'
    time: 1, // time in secnd
    ease: 'power3.easeOut' // easeing https://greensock.com/docs/v3/Eases
  })
```


### 2. responsive-images.js

###### Break Point Responsive
* viewportWidth >= 940px use data-img-large
* viewportWidth < 940 &&  viewportWidth >= 600 use data-img-medium
* viewportWidth < 600 && viewportWidth >= 0 use data-img-small


```
<div class="banner-slider">
      <img
          data-img-large="{{ asset('images/contents/home-banner-large.jpg')}}"
          data-img-medium="{{ asset('images/contents/home-banner-medium.jpg')}}"
          data-img-small="{{ asset('images/contents/home-banner-small.jpg')}}"
          alt="banner slider">

</div>
```

```javascript
import $ from 'jquery' //import jquery module
import responsiveImage from './libs/responsive-images'//import the js file

const elemBanner = $(".banner-slider img") //element
responsiveImage($).init(elemBanner, {
  type: 'image' //type image = <img>  or bg = background: url(...)
})
```


### 2. tabbing.js

* don't change html structure
* value in attribute nav-tab is class element of content tab
* set .content-tab css display: none
* set class "active" at first element in nav-tab

```
<div class="wrap-tab">
  <div class="nav-tab">
    <a data-tab=".tab-1" class="active">Content Tab 1</a>
    <a data-tab=".tab-2">Contact Tab 2</a>
  </div>

  <div class="content-tab tab-1">
    <h1>content tab 1</h1>
  </div>
  <div class="content-tab tab-2">
    <h1>content tab 2</h1>
  </div>
</div>
```

```javascript
import $ from 'jquery' //import jquery module
import tabbing from './libs/tabbing'//import the js file

const element = $(".wrap-tab")
tabbing($).init(element)

```
### 2. htmlclone.js


HTML Example :
https://gitlab.webarq.net/frontend-webarq/fe-playground/-/blob/master/resources/views/static/htmlclone/index.blade.php


Js Initializing Example :
https://gitlab.webarq.net/frontend-webarq/fe-playground/-/blob/master/resources/assets/js/libs/htmlclone.js
