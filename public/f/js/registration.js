$(function() {
  var options = window.registrationOptions;
  var regulations = options.regulations;
  var specialRegulations = {}
  var fee = $('#fee');
  $(document).on('change', '#disclaimer', function() {
    $('#submit-button').prop('disabled', !this.checked);
  }).on('change', '.registration-events', function() {
    updateFee()
    const childEvents = $(this).parent().parent().siblings('.child-events')
    childEvents[this.checked ? 'removeClass' : 'addClass']('hide')
    if (!this.checked) {
      childEvents.find('input').prop('checked', false)
    }
  });
  function updateFee() {
    var totalFee = options.basicFee;
    if ($('#Registration_has_entourage').val() == 1) {
      totalFee += options.entourageFee;
    }
    $('.registration-events:checked').each(function() {
      totalFee += $(this).data('fee');
    });
    if (totalFee > 0) {
      fee.removeClass('hide').find('#totalFee').text(totalFee);
    } else {
      fee.addClass('hide');
    }
  }
  $('.registration-events').trigger('change');

  $.each(options.unmetEvents, function(event, qualifyingTime) {
    $('.registration-events[value="' + event + '"]').parent().addClass('bg-danger').data('qualifyingTime', qualifyingTime);
  })
})
