$(document).ready(function() {
	$('#holiday').submit(function(event) {
		event.preventDefault();
		$.post('add_holiday.php', $('#holiday').serialize(), function(result) {
			$('#alert').text(result);
			$('#alert').css('display', 'block');

			// $('#spinner').css('display', 'none');
			// $('#alert').text(result).css('display', 'block');
			// $('.datepicker').val('');
			// $('.subject').val('');
			// $('.subject').html('');
			// $('.subject').select2('destroy').select2();
			// $('#class').val('');
		});
	})
})