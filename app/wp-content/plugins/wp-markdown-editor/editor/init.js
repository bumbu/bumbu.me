function escape(html, encode) {
  return html
    .replace(!encode ? /&(?!#?\w+;)/g : /&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

var renderer = new marked.Renderer()

renderer.code = function(code, lang, escaped) {
  lang = lang || ''
  var tokens = lang.split('|')
  var preClass = ''
  var preAttributes = ''

  // Lang is first token always
  if (tokens.length && tokens[0]) {
    lang = tokens[0]
    tokens.splice(0, 1)
  } else {
    lang = 'none'
  }

  preClass = this.options.langPrefix + escape(lang);

  tokens.forEach(function(token) {
    var tokenParts = token.split('=')
    var tokenKey = tokenParts[0]
    var tokenValue = tokenParts.length > 1 ? tokenParts[1] : ''

    switch(tokenKey) {
      case 'ln':
      case 'line-numbers':
        preClass += ' line-numbers'
        break;
      case 'lno':
      case 'line-numbers-offset':
        preAttributes += ' data-start="' + escape(tokenValue) + '"'
        break;
      case 'hl':
      case 'highlight-lines':
        preAttributes += ' data-line="' + escape(tokenValue) + '"'
        break;
      case 'hlo':
      case 'highlight-lines-offset':
        preAttributes += ' data-line-offset="' + escape(tokenValue) + '"'
        break;
    }
  })

  return '<pre class="' + preClass + '" ' + preAttributes + '><code>'
    + (escaped ? code : escape(code, true))
    + '\n</code></pre>\n';
};

marked.setOptions({
  renderer: renderer,
  gfm: true,
  tables: true,
  breaks: true,
  pedantic: false,
  sanitize: false,
  smartLists: true,
  smartypants: false,
  langPrefix: 'language-'
});

// Clone current textarea.
// Store rendered content in original textarea
// Store markdown in new textarea

var contentEl = document.getElementById("content")
var clonedEl = document.createElement(contentEl.tagName)

for (var attr = 0; attr < contentEl.attributes.length; attr++) {
  clonedEl.setAttribute(contentEl.attributes[attr].name, contentEl.attributes[attr].value)
}

// Change ID so that there will be no clashes
clonedEl.setAttribute('id', 'content_filtered')
clonedEl.setAttribute('name', 'content_filtered')
contentEl.style.display = 'none'

contentEl.parentNode.insertBefore(clonedEl, contentEl)
clonedEl.value = contentEl.value
contentEl.value = marked(contentEl.value)


// Init the editor
var simplemde = new SimpleMDE({
  spellChecker: false,
  element: document.getElementById("content_filtered"),
  previewRender: function(plainText) {
    return marked(plainText);
  }
});

simplemde.codemirror.on("change", function(){
  contentEl.value = marked(simplemde.value())
});

// Change zIndex when toggle full screen
var change_zIndex = function(editor) {
  // Give it some time to finish the transition
  setTimeout(function() {
    var cm = editor.codemirror;
    var wrap = cm.getWrapperElement();
    if(/fullscreen/.test(wrap.previousSibling.className)) {
      document.getElementById("wp-content-editor-container").style.zIndex = 999999;
    } else {
      document.getElementById("wp-content-editor-container").style.zIndex = 1;
    }
  }, 2);
}

var toggleFullScreenButton = document.getElementsByClassName("fa-arrows-alt");
toggleFullScreenButton[0].onclick = function() {
  SimpleMDE.toggleFullScreen(simplemde);
  change_zIndex(simplemde);
}

var toggleSideBySideButton = document.getElementsByClassName("fa-columns");
toggleSideBySideButton[0].onclick = function() {
  SimpleMDE.toggleSideBySide(simplemde);
  change_zIndex(simplemde);
}

var helpButton = document.getElementsByClassName("fa-question-circle");
helpButton[0].href = "http://hoducha.com/markdown-guide.html";

if (typeof jQuery !== "undefined") {
  jQuery(document).ready(function(){
    // Remove the quicktags-toolbar
    document.getElementById("ed_toolbar").style.display = "none";

    // Integrate with WP Media module
    var original_wp_media_editor_insert = wp.media.editor.insert;
    wp.media.editor.insert = function( html ) {
      original_wp_media_editor_insert(html);
      simplemde.codemirror.replaceSelection(html);
    }
  });
}

