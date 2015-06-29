jQuery ->
  $body = jQuery('body')
  $main = jQuery('#main')
  lastScrollTop = 0

  jQuery('#sidebar-trigger').click (ev)->
    ev.preventDefault()

    if $body.hasClass('sidebar-open')
      $body.removeClass('sidebar-open')
      $main.css 'margin-top', 0
      $body.scrollTop(lastScrollTop)
    else
      lastScrollTop = $body.scrollTop()
      $body.addClass('sidebar-open')
      $main.css 'margin-top', "-#{lastScrollTop}px"
