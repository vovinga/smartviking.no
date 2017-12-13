if (!window.console) window.console = {}; //IE fix
if (!window.console.log) window.console.log = function (){}; //IE fix
 
var qc = qc || {};
var focused = window;
qc.event = _.extend({}, Backbone.Events);
qc.statistic = qc.statistic || {};
 
 $.fn.serializeObject = function() {
      var o = {};
      var a = this.serializeArray();
      $.each(a, function() {
          if (o[this.name] !== undefined) {
              if (!o[this.name].push) {
                  o[this.name] = [o[this.name]];
              }
              o[this.name].push(this.value || '');
          } else {
              o[this.name] = this.value || '';
          }
      });
      return o;
    };
function preloaderStart(){
  $('.preloader').delay(500).fadeIn(300);
}
function preloaderStop(){
  $('.preloader').stop(true,true).fadeOut(300);
}

function sformat(pattern, address){
  var result = pattern;
  result = result.replace(/\{firstname\}/g, address.firstname);
  result = result.replace(/\{lastname\}/g, address.lastname);
  result = result.replace(/\{company\}/g, address.company);
  result = result.replace(/\{address_1\}/g, address.address_1);
  result = result.replace(/\{address_2\}/g, address.address_2);
  result = result.replace(/\{city\}/g, address.city);
  result = result.replace(/\{zone\}/g, address.zone);
  result = result.replace(/\{country\}/g, address.country);
  result = result.replace(/\{postcode\}/g, address.postcode);
  result = result.replace(/\{zone_code\}/g, address.zone_code);
  result = result.replace(/^\s*\n/gm, "");
  result = result.replace(/^\s+|\s+$/g, "");
 
  return result;
}
if(typeof $().modal != 'function'){
    /* =========================================================
     * bootstrap-modal.js v2.1.0
     * http://twitter.github.com/bootstrap/javascript.html#modals
     * =========================================================
     * Copyright 2012 Twitter, Inc.
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     * http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     * ========================================================= */


    !function ($) {

      "use strict"; // jshint ;_;


     /* MODAL CLASS DEFINITION
      * ====================== */

      var Modal = function (element, options) {
        this.options = options
        this.$element = $(element)
          .delegate('[data-dismiss="modal"]', 'click.dismiss.modal', $.proxy(this.hide, this))
        this.options.remote && this.$element.find('.modal-body').load(this.options.remote)
      }

      Modal.prototype = {

          constructor: Modal

        , toggle: function () {
            return this[!this.isShown ? 'show' : 'hide']()
          }

        , show: function () {
            var that = this
              , e = $.Event('show')

            this.$element.trigger(e)

            if (this.isShown || e.isDefaultPrevented()) return

            $('body').addClass('modal-open')

            this.isShown = true

            this.escape()

            this.backdrop(function () {
              var transition = $.support.transition && that.$element.hasClass('fade')

              if (!that.$element.parent().length) {
                that.$element.appendTo(document.body) //don't move modals dom position
              }

              that.$element
                .show()

              if (transition) {
                that.$element[0].offsetWidth // force reflow
              }

              that.$element
                .addClass('in')
                .attr('aria-hidden', false)
                .focus()

              that.enforceFocus()

              transition ?
                that.$element.one($.support.transition.end, function () { that.$element.trigger('shown') }) :
                that.$element.trigger('shown')

            })
          }

        , hide: function (e) {
            e && e.preventDefault()

            var that = this

            e = $.Event('hide')

            this.$element.trigger(e)

            if (!this.isShown || e.isDefaultPrevented()) return

            this.isShown = false

            $('body').removeClass('modal-open')

            this.escape()

            $(document).off('focusin.modal')

            this.$element
              .removeClass('in')
              .attr('aria-hidden', true)

            $.support.transition && this.$element.hasClass('fade') ?
              this.hideWithTransition() :
              this.hideModal()
          }

        , enforceFocus: function () {
            var that = this
            $(document).on('focusin.modal', function (e) {
              if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
                that.$element.focus()
              }
            })
          }

        , escape: function () {
            var that = this
            if (this.isShown && this.options.keyboard) {
              this.$element.on('keyup.dismiss.modal', function ( e ) {
                e.which == 27 && that.hide()
              })
            } else if (!this.isShown) {
              this.$element.off('keyup.dismiss.modal')
            }
          }

        , hideWithTransition: function () {
            var that = this
              , timeout = setTimeout(function () {
                  that.$element.off($.support.transition.end)
                  that.hideModal()
                }, 500)

            this.$element.one($.support.transition.end, function () {
              clearTimeout(timeout)
              that.hideModal()
            })
          }

        , hideModal: function (that) {
            this.$element
              .hide()
              .trigger('hidden')

            this.backdrop()
          }

        , removeBackdrop: function () {
            this.$backdrop.remove()
            this.$backdrop = null
          }

        , backdrop: function (callback) {
            var that = this
              , animate = this.$element.hasClass('fade') ? 'fade' : ''

            if (this.isShown && this.options.backdrop) {
              var doAnimate = $.support.transition && animate

              this.$backdrop = $('<div class="modal-backdrop ' + animate + '" />')
                .appendTo(document.body)

              if (this.options.backdrop != 'static') {
                this.$backdrop.click($.proxy(this.hide, this))
              }

              if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

              this.$backdrop.addClass('in')

              doAnimate ?
                this.$backdrop.one($.support.transition.end, callback) :
                callback()

            } else if (!this.isShown && this.$backdrop) {
              this.$backdrop.removeClass('in')

              $.support.transition && this.$element.hasClass('fade')?
                this.$backdrop.one($.support.transition.end, $.proxy(this.removeBackdrop, this)) :
                this.removeBackdrop()

            } else if (callback) {
              callback()
            }
          }
      }


     /* MODAL PLUGIN DEFINITION
      * ======================= */

      $.fn.modal = function (option) {
        return this.each(function () {
          var $this = $(this)
            , data = $this.data('modal')
            , options = $.extend({}, $.fn.modal.defaults, $this.data(), typeof option == 'object' && option)
          if (!data) $this.data('modal', (data = new Modal(this, options)))
          if (typeof option == 'string') data[option]()
          else if (options.show) data.show()
        })
      }

      $.fn.modal.defaults = {
          backdrop: true
        , keyboard: true
        , show: true
      }

      $.fn.modal.Constructor = Modal


     /* MODAL DATA-API
      * ============== */

      $(function () {
        $('body').on('click.modal.data-api', '[data-toggle="modal"]', function ( e ) {
          var $this = $(this)
            , href = $this.attr('href')
            , $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) //strip for ie7
            , option = $target.data('modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

          e.preventDefault()

          $target
            .modal(option)
            .one('hide', function () {
              $this.focus()
            })
        })
      })

    }(window.jQuery);
}
