jQuery ->
  $ = jQuery
  $body = $('body')
  $main = $('#main')
  $menuPrimary = $('#menu-primary')
  lastScrollTop = 0
  $sidebarSecondary = $('#sidebar-secondary')

  $('#sidebar-trigger').click (ev)->
    ev.preventDefault()

    if $body.hasClass('sidebar-open')
      $body.removeClass('sidebar-open')
      $main.css 'margin-top', 0
      $body.scrollTop(lastScrollTop)
    else
      lastScrollTop = $body.scrollTop()
      $body.addClass('sidebar-open')
      $main.css 'margin-top', "-#{lastScrollTop}px"

  if CATEGORIES?
    categoriesList = $.parseJSON(CATEGORIES)
    categoriesObject = {}
    for category in categoriesList
      categoriesObject[category.id] = category

  currentActiveId = $menuPrimary.children('.active').children('a').data('id') || 0

  # Enable dynamic menu only if currently selected item is a category
  if categoriesObject? and currentActiveId of categoriesObject
    activateCategory = (id)->
      currentId = $menuPrimary.children('.active').children('a').data('id') || 0
      return false if currentId is id

      category = categoriesObject[id]

      # Deselect previous menu item
      $menuPrimary.children('.active').removeClass('active')

      # Select new item
      $menuPrimary.find("a[data-id='#{id}']").parent().addClass('active')

      # Set sidebar title
      $sidebarSecondary.find('.header h4').text(category.title)

      # Set sidebar contents
      itemsHtml = ''
      for post in category.posts
        itemsHtml += "<a class='item #{if post.is_active then 'active' else ''}' href='#{post.url}'><span class='title'>#{post.title}</span></a>"
      $sidebarSecondary.find('.items').html(itemsHtml)


    $('#menu-primary').on 'click', 'a.icon', (ev)->
      id = $(ev.currentTarget).data('id') || 0

      if id of categoriesObject
        ev.preventDefault()
        activateCategory(id)
