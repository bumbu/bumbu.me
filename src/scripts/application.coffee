jQuery ->
  jQuery('#icon-logo').on('click', (ev) -> 
  	ev.preventDefault()

  	jQuery('#panel-main').toggleClass('open')
  )