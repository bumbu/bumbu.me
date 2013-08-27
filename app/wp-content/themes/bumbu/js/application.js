(function() {
  jQuery(function() {
    return jQuery('#icon-logo').on('click', function(ev) {
      ev.preventDefault();
      return jQuery('#panel-main').toggleClass('open');
    });
  });

}).call(this);
