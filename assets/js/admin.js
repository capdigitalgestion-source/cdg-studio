jQuery(function($){
  function toast(message){
    const t=$('<div class="cdg-toast"/>').text(message).appendTo('body');
    setTimeout(function(){t.fadeOut(200,function(){t.remove();});},1800);
  }

  $('.cdg-select-image').on('click', function(e){
    e.preventDefault();
    const box = $(this).closest('.cdg-image-field');
    const frame = wp.media({ title:'Choisir une image', button:{text:'Utiliser cette image'}, multiple:false });
    frame.on('select', function(){
      const attachment = frame.state().get('selection').first().toJSON();
      const url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
      box.find('.cdg-image-id').val(attachment.id);
      box.find('.cdg-image-preview').html('<img src="'+url+'" alt="">');
      $('select[name="visuel_type"]').val('image').trigger('change');
      $('[data-preview-target="visual"]').html('<img src="'+url+'" alt="">');
    });
    frame.open();
  });

  $('.cdg-remove-image').on('click', function(e){
    e.preventDefault();
    const box = $(this).closest('.cdg-image-field');
    box.find('.cdg-image-id').val('');
    box.find('.cdg-image-preview').empty();
    updatePreview();
  });

  $('[data-cdg-pick-emoji]').on('click', function(){
    $('select[name="visuel_type"]').val('emoji').trigger('change');
    $('input[name="emoji"]').val($(this).data('cdg-pick-emoji')).trigger('input');
  });

  $('[data-cdg-pick-dashicon]').on('click', function(){
    $('select[name="visuel_type"]').val('dashicon').trigger('change');
    $('input[name="dashicon"]').val($(this).data('cdg-pick-dashicon')).trigger('input');
  });

  $('.cdg-editor-tabs button').on('click', function(){
    const tab = $(this).data('cdg-tab');
    $('.cdg-editor-tabs button').removeClass('is-active');
    $(this).addClass('is-active');
    $('[data-cdg-panel]').removeClass('is-active');
    $('[data-cdg-panel="'+tab+'"]').addClass('is-active');
  });

  function updatePreview(){
    const get = name => $('[data-preview-source="'+name+'"]').val() || '';
    $('[data-preview-target="titre"]').text(get('titre'));
    $('[data-preview-target="valeur"]').text(get('valeur'));
    $('[data-preview-target="texte"]').text(get('texte'));
    $('[data-preview-target="source_label"]').text((get('source_label') || 'Source') + ' →');
    const type = get('visuel_type');
    let visual = '';
    if(type === 'emoji') visual = $('<div/>').text(get('emoji')).html();
    if(type === 'dashicon') visual = '<span class="dashicons '+ $('<div/>').text(get('dashicon')).html() +'"></span>';
    if(type === 'fontawesome') visual = '<i class="'+ $('<div/>').text(get('fontawesome')).html() +'"></i>';
    if(type === 'image'){
      const img = $('.cdg-image-preview img').attr('src');
      visual = img ? '<img src="'+img+'" alt="">' : '';
    }
    $('[data-preview-target="visual"]').html(visual);
  }
  $('[data-preview-source]').on('input change', updatePreview);

  $('.cdg-device-buttons [data-cdg-device]').on('click', function(){
    const device = $(this).data('cdg-device');
    $(this).siblings().removeClass('is-active');
    $(this).addClass('is-active');
    $('[data-cdg-preview-frame]').removeClass('is-desktop is-tablet is-mobile').addClass('is-'+device);
  });

  function filterRows(){
    const term = (($('[data-cdg-search]').val() || '') + '').toLowerCase();
    const visibleOnly = $('[data-cdg-visible-only]').is(':checked');
    let shown = 0;
    $('.cdg-list-row').each(function(){
      const row = $(this);
      const matchText = (row.data('search') || '').toString().indexOf(term) !== -1;
      const matchVisible = !visibleOnly || row.data('active').toString() === '1';
      const show = matchText && matchVisible;
      row.toggleClass('is-filtered', !show);
      if(show) shown++;
    });
    $('[data-cdg-empty]').prop('hidden', shown !== 0);
  }
  $('[data-cdg-search], [data-cdg-visible-only]').on('input change', filterRows);

  $('.cdg-copy-shortcode').on('click', function(){
    const target = document.getElementById($(this).data('copy-target'));
    if(!target) return;
    const text = target.textContent;
    if(navigator.clipboard){
      navigator.clipboard.writeText(text).then(function(){toast(CDGStudioAdmin.copyOk);}, function(){toast(CDGStudioAdmin.copyFail);});
    } else {
      const tmp = $('<textarea>').val(text).appendTo('body').select();
      document.execCommand('copy'); tmp.remove(); toast(CDGStudioAdmin.copyOk);
    }
  });

  const list = $('#cdg-chiffres-list[data-reorder="1"]');
  if(list.length){
    list.sortable({
      handle: '.cdg-handle',
      placeholder: 'cdg-sort-placeholder',
      items: '.cdg-list-row',
      update: function(){
        const ids = list.find('.cdg-list-row').map(function(){return $(this).data('id');}).get();
        $.post(CDGStudioAdmin.ajaxUrl, { action:'cdg_chiffres_reorder', nonce:CDGStudioAdmin.nonce, ids:ids })
          .done(function(){toast('Ordre enregistré.');})
          .fail(function(){toast('Ordre non enregistré.');});
      }
    });
  }

  $('[data-cdg-open-preview]').on('click', function(){
    $('[data-cdg-preview-modal]').prop('hidden', false);
  });
  $('[data-cdg-close-preview]').on('click', function(){
    $('[data-cdg-preview-modal]').prop('hidden', true);
  });
  $('[data-cdg-modal-device]').on('click', function(){
    const device = $(this).data('cdg-modal-device');
    $('[data-cdg-modal-device]').removeClass('is-active');
    $(this).addClass('is-active');
    $('[data-cdg-modal-frame]').removeClass('is-desktop is-tablet is-mobile').addClass('is-'+device);
  });
});

/* CDG Studio v0.8 - true admin carousel preview */
(function(){
  function initAdminCarousel(root){
    if (!root || root.dataset.cdgCarouselReady === '1') return;
    root.dataset.cdgCarouselReady = '1';

    const track = root.querySelector('.cdg-admin-carousel-track');
    const slides = Array.from(root.querySelectorAll('.cdg-admin-carousel-slide'));
    const prev = root.querySelector('.cdg-admin-carousel-prev');
    const next = root.querySelector('.cdg-admin-carousel-next');
    const dotsWrap = root.querySelector('.cdg-admin-carousel-dots');
    const frame = root.closest('[data-cdg-modal-frame]');
    if (!track || !slides.length) return;

    let index = 0;
    let timer = null;
    const autoplay = root.dataset.autoplay === '1';
    const interval = parseInt(root.dataset.interval || '3500', 10);

    function perView(){
      if (frame && frame.classList.contains('is-mobile')) return 1;
      if (frame && frame.classList.contains('is-tablet')) return 2;
      return 3;
    }
    function maxIndex(){ return Math.max(0, slides.length - perView()); }

    function refreshDots(){
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';
      for (let i = 0; i <= maxIndex(); i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'cdg-admin-carousel-dot' + (i === index ? ' is-active' : '');
        dot.setAttribute('aria-label', 'Aller au groupe ' + (i + 1));
        dot.addEventListener('click', function(){ index = i; update(); restart(); });
        dotsWrap.appendChild(dot);
      }
    }

    function update(){
      const max = maxIndex();
      if (index > max) index = 0;
      if (index < 0) index = max;
      const gap = parseFloat(getComputedStyle(track).gap) || 0;
      const width = slides[0].getBoundingClientRect().width;
      track.style.transform = 'translateX(-' + (index * (width + gap)) + 'px)';
      root.classList.toggle('is-disabled', slides.length <= perView());
      if (dotsWrap) Array.from(dotsWrap.children).forEach(function(dot, i){ dot.classList.toggle('is-active', i === index); });
    }

    function nextSlide(){ index = index >= maxIndex() ? 0 : index + 1; update(); }
    function prevSlide(){ index = index <= 0 ? maxIndex() : index - 1; update(); }
    function stop(){ if (timer) { clearInterval(timer); timer = null; } }
    function start(){ if (autoplay && slides.length > perView()) timer = setInterval(nextSlide, interval); }
    function restart(){ stop(); start(); }

    if (next) next.addEventListener('click', function(){ nextSlide(); restart(); });
    if (prev) prev.addEventListener('click', function(){ prevSlide(); restart(); });
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    root.cdgRefreshCarousel = function(){ refreshDots(); update(); restart(); };
    refreshDots();
    update();
    start();
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('[data-cdg-admin-carousel]').forEach(initAdminCarousel);

    document.querySelectorAll('[data-cdg-modal-device]').forEach(function(btn){
      btn.addEventListener('click', function(){
        setTimeout(function(){
          document.querySelectorAll('[data-cdg-admin-carousel]').forEach(function(carousel){
            if (typeof carousel.cdgRefreshCarousel === 'function') carousel.cdgRefreshCarousel();
          });
        }, 60);
      });
    });

    document.querySelectorAll('[data-cdg-open-preview]').forEach(function(btn){
      btn.addEventListener('click', function(){
        setTimeout(function(){
          document.querySelectorAll('[data-cdg-admin-carousel]').forEach(function(carousel){
            if (typeof carousel.cdgRefreshCarousel === 'function') carousel.cdgRefreshCarousel();
          });
        }, 80);
      });
    });
  });
})();
