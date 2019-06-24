import 'bootstrap/dist/css/bootstrap.css'
import 'font-awesome/css/font-awesome.css'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'
import '../less/styles.less'

import 'jquery-cookie'
import 'jquery-countdown'
import ProgressBar from 'progressbar.js'
import '../plugins/back-to-top/back-to-top'
import '../plugins/jquery-placeholder/jquery.placeholder'
import 'bootstrap-hover-dropdown'
import 'slick-carousel'
import utils from '../utils'

window.jQuery = window.$ = jQuery
window.CubingChina = {
  utils
}

$(function() {
  $(document).on('change', '#disclaimer', function() {
    $('#submit-button').prop('disabled', !this.checked);
  }).on('change', '.registration-events', function() {
    const extra = $(this).parent().parent().parent().parent().find('.extra-info')
    console.log(extra)
    extra[this.checked ? 'addClass' : 'removeClass']('show')
  });
  $('.registration-events').trigger('change');
  $('input, textarea').placeholder();
  $('.wrapper table:not(.table)').addClass('table table-bordered table-condensed').parent().addClass('table-responsive');
  $('.slider-wrapper').slick({
    autoplay: true,
    dots: true,
    mobileFirst: true,
    adaptiveHeight: true
  });
  $('[data-toggle="tooltip"]').tooltip()
  if (!('ontouchstart' in window)) {
    (function() {
      var win = $(window);
      var winHeight = win.height();
      $('.table-responsive table').each(function() {
        var table = $(this);
        var tableParent = table.parent();
        var scroll = $('<div>');
        var scrollParent = $('<div class="table-responsive">');
        var tableWidth = table.width();
        var tableHeight = table.height();
        var tableParentWidth = tableParent.width();
        var tableParentHeight = tableParent.height();
        var offset = tableParent.offset();
        table.removeAttr('style width height');
        scroll.css({
          height: 1,
          width: tableWidth
        });
        scrollParent.append(scroll).insertAfter(tableParent).css({
          position: 'fixed'
        }).on('scroll', function() {
          tableParent[0].scrollLeft = this.scrollLeft;
        });
        tableParent.on('scroll', function() {
          scrollParent[0].scrollLeft = this.scrollLeft;
        });
        win.on('scroll', function() {
          if (tableWidth <= tableParentWidth || tableHeight < winHeight * 2 || winHeight + win.scrollTop() > offset.top + tableParentHeight) {
            scrollParent.hide();
          } else {
            scrollParent.show().scrollLeft(tableParent.scrollLeft());
          }
        }).on('resize', function() {
          scrollParent.css({
            width: tableParentWidth,
            bottom: -parseInt(tableParent.css('margin-bottom'))
          });
          win.trigger('scroll');
          winHeight = win.height();
          tableWidth = table.width();
          tableHeight = table.height();
          tableParentWidth = tableParent.width();
          tableParentHeight = tableParent.height();
          offset = tableParent.offset();
        }).trigger('resize');
      });
    })();
  }
  var i = 0, lastTime = Date.now()
  $('.countdown-timer').each(function() {
    var that = $(this), containers = [
      {
        key: 'days',
        total: that.data('totalDays') || 30,
        offsetKey: 'totalDays',
        progressOptions: {
            color: '#d9534f',
            trailColor: 'rgba(217, 83, 79, 0.5)'
        }
      },
      {
        key: 'hours',
        total: 24,
        progressOptions: {
            color: '#f0ad4e',
            trailColor: 'rgba(240, 164, 78, 0.5)'
        }
      },
      {
        key: 'minutes',
        total: 60,
        progressOptions: {
            color: '#5cb85c',
            trailColor: 'rgba(92, 184, 92, 0.5)'
        }
      },
      {
        key: 'seconds',
        total: 60,
        progressOptions: {
            color: '#5bc0de',
            trailColor: 'rgba(91, 192, 222, 0.5)'
        }
      }
    ]
    containers.forEach(container => {
      container.dom = that.find('.' + container.key)
      container.offsetKey = container.offsetKey || container.key
      container.progress = new ProgressBar.Circle(container.dom.nextAll('.progress-container').get(0), $.extend({
        strokeWidth: 3,
        trailWidth: 1,
        duration: 1000
      }, container.progressOptions))
    })

    that.countdown(new Date(lastTime + that.data('remaining'))).on('update.countdown', e => {
      var offset = e.offset
      containers.forEach(container => {
        container.dom.text(offset[container.offsetKey])
        container.progress.animate(offset[container.offsetKey] / container.total)
      })
    })
  })
  setInterval(() => {
    if (parseInt((Date.now() - lastTime) / 1000) == ++i) {
      return
    }
    i = 0
    lastTime = Date.now()
    $('.countdown-timer').each(function() {
      var that = $(this)
      that.countdown(new Date(lastTime + that.data('remaining')))
    })
  }, 1000)
});
