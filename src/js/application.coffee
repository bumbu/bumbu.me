jQuery ->
  $ = jQuery
  $body = $('body')
  $main = $('#main')
  $menuPrimary = $('#menu-primary')
  lastScrollTop = 0
  $sidebarSecondary = $('#sidebar-secondary')

  # Search
  isSearchActive = false
  $sidebarSearch = $('#sidebar-search')
  $sidebarSearchForm = $('#sidebar-search-form')
  $sidebarSearchInput = $sidebarSearchForm.find('input')

  setCookie = (name, value, days) ->
    if days
      date = new Date()
      date.setTime date.getTime() + (days * 24 * 60 * 60 * 1000)
      expires = "; expires=" + date.toGMTString()
    else
      expires = ""
    document.cookie = name + "=" + value + expires + "; path=/"

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
  setCookie('last-active-category', currentActiveId) # Update current category id

  # Enable dynamic menu only if currently selected item is a category
  if categoriesObject? and currentActiveId of categoriesObject
    activateCategory = (id)->
      setCookie('last-active-category', id) # set new current category id

      currentId = $menuPrimary.children('.active').children('a').data('id') || 0
      return false if currentId is id

      category = categoriesObject[id]
      isSearchActive = false

      # Deselect previous menu item
      $menuPrimary.children('.active').removeClass('active')

      # Select new item
      $menuPrimary.find("a[data-id='#{id}']").parent().addClass('active')

      # Set sidebar title
      $sidebarSecondary.find('.header h4').show().text(category.title)
      $sidebarSearchForm.hide()

      # Set sidebar contents
      itemsHtml = ''
      for post in category.posts
        itemsHtml += "<a class='item #{if post.is_active then 'active' else ''}' href='#{post.url}'><span class='title'>#{post.title}</span></a>"
      $sidebarSecondary.find('.items').html(itemsHtml)


    $('#menu-primary').on 'click', '.menu-item a.icon', (ev)->
      id = $(ev.currentTarget).data('id') || 0

      if id of categoriesObject
        ev.preventDefault()
        activateCategory(id)

  $sidebarSearch.click (ev)->
    ev.preventDefault()
    return false if isSearchActive

    isSearchActive = true

    # Deselect previous menu item
    $menuPrimary.children('.active').removeClass('active')

    # Select search icon
    $sidebarSearch.parent().addClass('active')

    # Hide title
    $sidebarSecondary.find('.header h4').hide()
    $sidebarSearchForm.show()
    $sidebarSearchInput.focus()

    # Remove current items
    $sidebarSecondary.find('.items').empty()

  lastAjax = null
  lastAjaxSearch = null

  $sidebarSearchInput.on 'keyup blur change', (ev)->
    ev?.preventDefault?()
    value = $sidebarSearchInput.val()

    return false if value is lastAjaxSearch
    lastAjaxSearch = value

    lastAjax?.abort()

    lastAjax = $.ajax
      url: $sidebarSearchForm.attr('action')
      data:
        q: value
      method: 'GET'
      dataType: 'json'
      success: (posts)->
        # Do not process success if search already closed
        return false unless isSearchActive

          # Set sidebar contents
        itemsHtml = ''
        for post in posts
          itemsHtml += "<a class='item' href='#{post.url}'><span class='title'>#{post.title}</span></a>"
        $sidebarSecondary.find('.items').html(itemsHtml)

        if itemsHtml is ''
          # Show no posts found
          $sidebarSecondary.find('.items').html('<span class="item alert">No posts found matching your search criteria. Please try another request</span>')

      error: (jqXhr, textStatus)->
        if textStatus != 'abort'
          # Show error
          $sidebarSecondary.find('.items').html('<span class="item alert">An unexpected error happened: ' + textStatus + '</span>')

      complete: ->
        lastAjax = null
