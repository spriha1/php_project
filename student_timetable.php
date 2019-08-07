<?php
	session_start();
	if (isset($_SESSION["username"])) {
		require_once 'header_dashboard.html';
		include_once 'student_sidenav.php';
		include_once 'db_credentials.php';
		include_once 'db_connection.php';
		include_once 'static_file_version.php';
?>
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<!-- <input class="date" id="date" type="date"> -->
						<input class="datepicker">
						<button type="button" id="share" class="btn btn-success pull-right">Share</button>
					</div>
					<div class="box-body">
						<input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>">
						<input type="hidden" id="user_type" value="student">
						<table id="timetable" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Subject</th>
									<th>Teacher</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody class="timetable">
							</tbody>
						</table>
						<table style="display:none">
						<tr class="editable" task_id="" style="display:none;">
							<td class="name"></td>
							<td class="teacher"></td>
							<td class="timer"></td>
							<td>
								<button class="btn btn-info start">Start</button>
								<button class="btn btn-info stop" task_id="">Stop</button>
								<button class="btn btn-info pause">Pause</button>
								<button class="btn btn-info resume">Resume</button>
							</td>
						</tr>
					</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php 
	$file = 'profile_footer';
	include_once 'footer.php'; 
?>
<script src="<?php autoVer('/scripts/timetable.js'); ?>"></script>

</body>
</html>
<?php
}

else {
	header("Location:index.php");
}
?>