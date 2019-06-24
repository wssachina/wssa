$(function() {
  var options = window.registrationOptions;
  var regulations = options.regulations;
  var specialRegulations = {}
  var fee = $('#fee');
  $(document).on('change', '#disclaimer', function() {
    $('#submit-button').prop('disabled', !this.checked);
  }).on('change', '.registration-events', function() {
    updateFee()
    const extra = $(this).parent().parent().parent().parent().find('.extra-info')
    console.log(extra)
    extra[this.checked ? 'addClass' : 'removeClass']('show')
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
