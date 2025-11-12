const accordion = {};

accordion.accordion = function ($root) {
  $root = $root || $(document);

  // ensure jQuery object
  if (!($root instanceof jQuery)) {
    $root = $($root);
  }

  // collect .accordion containers: those di dalam root, plus root sendiri jika dia .accordion
  let $containers = $root.find('.accordion');
  if ($root.filter('.accordion').length) {
    $containers = $containers.add($root.filter('.accordion'));
  }

  $containers.each(function () {
    const $container = $(this);
    const type = $container.data('type');

    // show content for active lists
    $container.find('.accordion__list.active > .accordion__list--content').show();

    // remove previous handlers to avoid double-bind
    $container.off('click.accordion').on('click.accordion', '.accordion__list--button', function (e) {
      e.stopPropagation();

      const $parent = $(this).closest('.accordion__list');
      const $content = $parent.children('.accordion__list--content');

      if (!$parent.hasClass('active')) {
        if (type !== 'multiple') {
          // slide up only direct children lists' content
          $container.find('>.accordion__list .accordion__list--content').slideUp(200);
          $container.find('>.accordion__list').removeClass('active');
        }

        $parent.addClass('active');
        $content.slideDown(200);
      } else {
        $parent.removeClass('active');
        $content.slideUp(200);
      }
    });
  });
};

export default accordion;
