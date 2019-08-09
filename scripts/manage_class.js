$(document).ready(function() {

	$.get('display_class.php', function(result) {
		var response = JSON.parse(result);
		var length = response.length;
		for (var i = 0; i < length; i++) {
			let element = $(".clone").clone(true).css('display', 'block').removeClass('clone');
			element.find('.text').text(response[i].class);
			element.attr('class_id', response[i].class);
			element.appendTo('.append_class');
		}
	});
		
	$(".add_item").click(function(event) {
		event.preventDefault();
		$('#append_teacher').html("");
		$('.append_teacher #class').val("");
		$('.append_teacher .subject').val('');
		$('.append_teacher .subject').select2('destroy').select2();
		$(".add_class").css("display", "block");
	});

	$('.subject').on('select2:select', function (e) {
	    var data = e.params.data;
	    var id = data.id; //value of options
	    var text = data.text;

	    $.post('fetch_teachers.php', {subject_id: id}, function(result) {
	    	var response = JSON.parse(result);
	    	let element = $(".editable").clone(true).css('display', 'block').removeClass('editable');
			element.find('label').text(text);
			element.find('label').attr('for', id);
			element.find('select').attr('name', id);

	    	for(var i = 0; i < response.length; i++)
	    	{
	    		let element2 = $(".editable option").clone(true);
	    		// element.closest('select').removeClass('teacher');
	    		console.log(element)
				element2.attr('value', response[i].id);
				element2.html(response[i].firstname);
				element2.appendTo(element.find('select'))
	    	}

			element.appendTo('#append_teacher');

	    });
	});

	$('.subject').on('select2:unselect', function(e) {
		var data = e.params.data;
	    var id = data.id;
		$('.append_teacher label[for='+id+']').remove();
		$('.append_teacher select[name='+id+']').remove();

	})

	$("#add").click(function(event) {
		event.preventDefault();
		$(".add_class").css("display", "none");
		$.post('add_class.php', $('#add_class').serialize(), function(result) {
			var response = JSON.parse(result);
			console.log(response[0].class);
			let element = $(".clone").clone(true).css('display', 'block').removeClass('clone');
			element.find('.text').text(response[0].class);
			element.attr('class_id', response[0].class);
			element.appendTo('.append_class');
		});
		// $('.subject').text("");
		// $('#class').val("");
	});

	$(".remove").click(function(event) {
		//event.preventDefault();
		var class_id = $(this).closest('li').attr('class_id');
		$.post('remove_class.php', {class_id: class_id}, function() {
			$("ul li[class_id=" + class_id + "]").remove();
		});
	});

	$('.edit').click(function(event) {
		var class_id = $(this).closest('li').attr('class_id');
		$('._add_class').css('display', 'none');
		$('#edit_subject').css('display', 'none');
		$('#edit_subject select').val("");
		$("._add_class").find('form input').val(class_id);
		$.post('fetch_class_details.php', {class: class_id}, function(result) {
			var response = JSON.parse(result);
			var length = response.length;
			console.log(response[0].class)
			$('#view_subjects').html("");
			for (var i = 0; i < length; i++) 
			{
				console.log(response[i].name);
				var element = $('.subjects_body').clone(true).css('display', 'table-row').removeClass('subjects_body');
				element.find('.subject_name').text(response[i].name);
				element.find('.teacher').text(response[i].firstname);
				element.attr('subject_id', response[i].subjectid);
				element.attr('class_id', response[i].class);

				element.appendTo('#view_subjects');
			}
		});
	});

	$(".remove_subject").click(function(event) {
		//event.preventDefault();
		var class_id = $(this).closest('tr').attr('class_id');
		var subject_id = $(this).closest('tr').attr('subject_id');

		$.post('remove_class_subject.php', {class_id: class_id, subject_id: subject_id}, function() {
			$("table tr[subject_id=" + subject_id + "]").remove();
		});
	});

	$(".add_subject").click(function(event) {
		event.preventDefault();
		$('#_append_teacher').html("");
		$('._append_teacher ._subject').val('');
		$('._append_teacher ._subject').select2('destroy').select2();
		$("._add_class").css("display", "block");
	});

	$('._subject').on('select2:select', function (e) {
	    var data = e.params.data;
	    var id = data.id; //value of options
	    var text = data.text;
	    $.post('fetch_teachers.php', {subject_id: id}, function(result) {
	    	var response = JSON.parse(result);
	    	let element = $("._editable").clone(true).css('display', 'block').removeClass('_editable');
			element.find('label').text(text);
			element.find('label').attr('for', id);
			element.find('select').attr('name', id);

	    	for(var i = 0; i < response.length; i++)
	    	{
	    		let element2 = $("._editable option").clone(true);
	    		// element.closest('select').removeClass('teacher');
	    		console.log(element)
				element2.attr('value', response[i].id);
				element2.html(response[i].firstname);
				element2.appendTo(element.find('select'))
	    	}
			element.appendTo('#_append_teacher');

	    });
	});

	$('._subject').on('select2:unselect', function(e) {
		var data = e.params.data;
	    var id = data.id;
		$('._append_teacher label[for='+id+']').remove();
		$('._append_teacher select[name='+id+']').remove();

	})

	$("#_add").click(function(event) {
		event.preventDefault();
		$("._add_class").css("display", "none");
		console.log($('#_add_class').serialize());
		$.post('add_class_subject.php', $('#_add_class').serialize(), function(result) {
			var response = JSON.parse(result);
			var element = $('.subjects_body').clone(true).css('display', 'table-row').removeClass('subjects_body');
			element.find('.subject_name').text(response[0].name);
			element.find('.teacher').text(response[0].firstname);
			element.attr('subject_id', response[0].subjectid);
			element.attr('class_id', response[0].class);
			element.appendTo('#view_subjects');

		});
		// $('.subject').text("");
		// $('#class').val("");
	});

	$('.edit_subject').click(function() {
		$('#edit_subject').css('display', 'block');
		var subject_id = $(this).closest('tr').attr('subject_id');
		var class_id = $(this).closest('tr').attr('class_id');
		$('#edit_subject select').attr('subject_id', subject_id);
		$('#edit_subject select').attr('class_id', class_id);
		$('#edit_subject select').html("");

		$.post('fetch_teachers.php', {subject_id: subject_id}, function(result) {
			var response = JSON.parse(result);
	    	for(var i = 0; i < response.length; i++)
	    	{
	    		let element = $("#edit_subject ._clone").clone(true).removeClass('_clone');
	    		// element.closest('select').removeClass('teacher');
	    		console.log(element);
				element.attr('value', response[i].id);
				element.html(response[i].firstname);
				element.appendTo('.teacher_')
	    	}

		});

	});

	$('#edit_subject button').click(function(){
		$('#edit_subject').css('display', 'none');
		var subject_id = $('#edit_subject select').attr('subject_id');
		var class_id = $('#edit_subject select').attr('class_id');
		var teacher_id = $('#edit_subject select').val();
		$.post('update_teacher.php', {subject_id: subject_id, class_id: class_id, teacher_id: teacher_id}, function(result) {
			var response = JSON.parse(result);
			$('.modal-body tr[subject_id='+subject_id+'] .teacher').text(response[0].firstname);
		});

	})
})

	

	




// function load_display_data() {
// 	$.get('display_subjects.php', function(result) {
// 		var response = JSON.parse(result);
// 		var length = response.length;
// 		for (var i = 0; i < length; i++) {
// 			let element = $(".editable").clone(true).css('display', 'block').removeClass('editable');
// 			element.attr('subject_id', response[i].id);
// 			element.appendTo('.todo');
// 			subject_id = response[i].id;
// 			$("ul li[subject_id=" + subject_id + "] .text").html(response[i].name);
// 		}
// 	});
// }
