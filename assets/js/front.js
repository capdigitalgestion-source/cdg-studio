document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('[data-cdg-carousel]').forEach(function(root){
    const track = root.querySelector('.cdg-front-track');
    const cards = Array.from(root.querySelectorAll('.cdg-front-card'));
    const prev = root.querySelector('.cdg-front-prev');
    const next = root.querySelector('.cdg-front-next');
    const dotsWrap = root.querySelector('.cdg-front-dots');
    if (!track || !cards.length) return;

    let index = 0;
    let timer = null;
    const autoplay = root.dataset.autoplay === '1';
    const interval = parseInt(root.dataset.interval || '5000', 10);

    function perView(){
      if (window.innerWidth <= 700) return 1;
      if (window.innerWidth <= 1000) return 2;
      return 3;
    }

    function maxIndex(){
      return Math.max(0, cards.length - perView());
    }

    function updateDots(){
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';
      for (let i = 0; i <= maxIndex(); i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'cdg-front-dot' + (i === index ? ' is-active' : '');
        dot.setAttribute('aria-label', 'Aller au groupe ' + (i + 1));
        dot.addEventListener('click', function(){
          index = i;
          update();
          restart();
        });
        dotsWrap.appendChild(dot);
      }
    }

    function update(){
      const max = maxIndex();
      if (index > max) index = 0;
      if (index < 0) index = max;
      const gap = parseFloat(getComputedStyle(track).gap) || 0;
      const width = cards[0].getBoundingClientRect().width;
      track.style.transform = 'translateX(-' + (index * (width + gap)) + 'px)';
      root.classList.toggle('cdg-carousel-disabled', cards.length <= perView());
      if (dotsWrap) {
        Array.from(dotsWrap.children).forEach(function(dot, i){
          dot.classList.toggle('is-active', i === index);
        });
      }
    }

    function goNext(){ index = index >= maxIndex() ? 0 : index + 1; update(); }
    function goPrev(){ index = index <= 0 ? maxIndex() : index - 1; update(); }
    function stop(){ if (timer) { clearInterval(timer); timer = null; } }
    function start(){ if (autoplay && cards.length > perView()) timer = setInterval(goNext, interval); }
    function restart(){ stop(); start(); }

    if (next) next.addEventListener('click', function(){ goNext(); restart(); });
    if (prev) prev.addEventListener('click', function(){ goPrev(); restart(); });
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    window.addEventListener('resize', function(){ updateDots(); update(); restart(); });

    updateDots();
    update();
    start();
  });
});
