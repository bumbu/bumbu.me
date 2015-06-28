jQuery ->
  $body = jQuery('body')

  jQuery('#sidebar-trigger').click (ev)->
    ev.preventDefault()

    $body.toggleClass('sidebar-open')

