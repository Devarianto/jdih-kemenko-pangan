export default ($, gsap) => ({
  isOnScreen(element) {
    if (element.length) {
      var viewport = {}
      viewport.top = $(window).scrollTop()
      viewport.bottom = viewport.top + $(window).height()
      var bounds = {}
      bounds.top = element.offset().top
      bounds.bottom = bounds.top + element.outerHeight()
      return ((bounds.top <= viewport.bottom) && (bounds.bottom >= viewport.top))
    } else
      return false
  },
  from({ element, from, time, ease }){
    const this_ = this
    element.each(function() {
      if ($(this).attr('with-opacity') !== 'none')
        gsap.set($(this), {
          opacity: 0
        })

      if ($(this).css('position') !== 'absolute')
        gsap.set($(this), {
          position: 'relative'
        })

      switch (from) {
        case "from-top":
          gsap.set($(this), {
            top: '-50px'
          })
          break
        case "from-bottom":
          gsap.set($(this), {
            bottom: '-50px'
          })
          break
        case "from-left":
          gsap.set($(this), {
            left: '-50px'
          })
          break
        case "from-right":
          gsap.set($(this), {
            right: '-50px'
          })
          break
        case "fade":
          gsap.set($(this), {
            opacity: 0
          })
          break
        case "swipe-horizontal":
          gsap.set($(this), {
            overflow: 'hidden',
            width: 0,
            opacity: 1
          })
          break
        case "swipe-vertical":
          gsap.set($(this), {
            overflow: 'hidden',
            height: 0,
            opacity: 1
          })
          break
      }
    })
    $(window).scroll(function() {
      this_.animating({
        element,
        from,
        time,
        ease
      })
    })
    this_.animating({
      element,
      from,
      time,
      ease
    })
  },
  animating({ element, from, time, ease }) {
    const this_ = this
    let delay
    let triggerElem

    element.each(function() {
      if ($(this).attr('trigger-anim') !== undefined) {
        triggerElem = $($(this).attr('trigger-anim'))
      } else
        triggerElem = $(this)

      switch (from) {
        case "from-top":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('actived')) {
            gsap.to($(this), time, {
              css: {
                top: 0,
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('actived')
          }
          break

        case "from-bottom":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('actived')) {
            gsap.to($(this), time, {
              css: {
                bottom: 0,
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('actived')
          }
          break

        case "from-left":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('actived')) {
            gsap.to($(this), time, {
              css: {
                left: 0,
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('actived')
          }
          break

        case "from-right":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('actived')) {
            gsap.to($(this), time, {
              css: {
                right: 0,
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('actived')
          }
          break

        case "fade":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('faded')) {
            gsap.to($(this), time, {
              css: {
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('faded')
          }
          break

        case "swipe-horizontal":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('swiped')) {
            gsap.to($(this), time, {
              css: {
                width: '100%',
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('swiped')
          }
          break

        case "swipe-vertical":
          delay = parseFloat($(this).attr('delay'))
          if (this_.isOnScreen(triggerElem) && !gsap.isTweening(triggerElem) && !$(this).hasClass('swiped')) {
            gsap.to($(this), time, {
              css: {
                height: $(this).children('*').height(),
                opacity: 1
              },
              delay: delay,
              ease: ease
            })
            $(this).addClass('swiped')
          }
          break
      }
    })
  }
})