var NitroResourceLoader = (function() {
  var autoRemoveBaseCss = {BASE_CSS_AUTO_REMOVE};

  var stylesQueue = [];
  var styleQueueSize = 0;

  var scriptsQueue = [];
  var scriptQueueSize = 0;

  var onloadScript = function(e) {
    if (--scriptQueueSize == 0) {
      var inlineScripts = document.getElementsByClassName('nitropack-inline-script');
      for (var x = 0; x < inlineScripts.length; x++) {
        var script = document.createElement('script');
        script.innerHTML = inlineScripts[x].innerHTML;
        document.head.appendChild(script);
      }
    }
  }

  var loadQueuedScripts = function() {
    var scriptSrc = scriptsQueue.shift();

    while (scriptSrc) {
      scriptQueueSize++;
      var script = document.createElement('script');
      script.src = scriptSrc;
      script.async = false;
      script.onload = onloadScript;
      document.head.appendChild(script);

      scriptSrc = scriptsQueue.shift();
    }
  }

  var loadQueuedStyles = function() {
    var stylesParent = document.getElementById('nitro-deferred-styles');
    var div = document.createElement('div');
    div.innerHTML = stylesParent.textContent;
    styleQueueSize = div.children.length;
    document.body.appendChild(div);
  }

  return {
    setAutoRemoBaseCss: function (flag) {
      autoRemoveBaseCss = flag;
    },
    registerScript: function(src) {
      scriptsQueue.push(src);
    },
    registerStyle: function(href, rel, media) {
      stylesQueue.push({
        href: href,
        rel: rel,
        media: media
      });
    },
    onLoadStyle: function(style) {
      if (style.rel == 'preload') {
        style.rel = style.getAttribute('nitro-rel');
      } else if (--styleQueueSize == 0) {
        loadQueuedScripts();
      }
    },
    loadQueuedResources: function() {
      var raf = requestAnimationFrame || mozRequestAnimationFrame ||
          webkitRequestAnimationFrame || msRequestAnimationFrame;

      if (raf) raf(function() { window.setTimeout(loadQueuedStyles, 0); });
      else window.addEventListener('load', loadQueuedStyles);
    }
  }
})();
