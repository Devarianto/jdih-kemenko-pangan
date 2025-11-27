export default () => ({
  animating(element) {
    const el = document.querySelectorAll(element)
    for (let i = 0; i < el.length; i++) {
      let elAnimate = el[i]
      let trigger = elAnimate.getAttribute('data-animate-trigger')
      const animateTrigger = document.querySelector(trigger)
      elAnimate.classList.add('before-animate')

      const f = () => {
        // handleScroll
        const heightWindow = window.innerHeight
        const offsetTop = animateTrigger.getBoundingClientRect().top

        if (offsetTop - heightWindow < 0) {
          window.removeEventListener('scroll', f)
          elAnimate.classList.add('after-animate')

          // this code if for counting numbers on Homepages section about
          setTimeout(() => {
            const lottie = document.querySelector('.animation-lottie');
            if (lottie) {
              lottie.play();
            }

            const boxCard = document.querySelectorAll('.box-card__col');
            if (boxCard) {
              boxCard.forEach(item => {
                item.classList.add('actived');
              });
            }
          }, 500);
        }

      }
      window.addEventListener('scroll', f)
      window.addEventListener('load', f)
    }
    setTimeout(() => {
      $('.banner-homepage').addClass('after-animate')
    }, 100);
  }
})
