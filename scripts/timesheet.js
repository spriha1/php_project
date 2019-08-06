$(document).ready(function() {

	$(function () {
		$('#timesheet').DataTable({
		'paging'      : true,
		'lengthChange': true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false
		})
	})
	
	$('.view').click(function() {
		var from_id = $(this).attr('from_id');
		var of_date = $(this).attr('of_date');
		$.post('fetch_timesheet.php', {from_id: from_id, of_date: of_date, timesheet_check: 1}, function(result) {
			var response = JSON.parse(result);
			var length = response.length;
			$('#view_timesheet').html("");

			for (var i = 0; i < length; i++) 
			{
				var element = $('.timesheet_body').clone(true).removeClass('timesheet_body');
				element.find('.number').text(i+1);
				element.find('.subject').text(response[i].name);
				element.find('.class').text(response[i].class);
				var time = new Date(null);
				time.setSeconds(response[i].total_time);
				var total_time = time.toISOString().substr(11, 8);
				element.find('.total_time').text(total_time);
				element.appendTo('#view_timesheet');
			}
			
		});
	})
})