<?php
	session_start();
	if (isset($_SESSION["username"])) {
		require_once 'header_dashboard.html';
		include_once 'teacher_sidenav.php';
		include_once 'db_credentials.php';
		include_once 'db_connection.php';
		include_once 'static_file_version.php';
        
        $date = strval(date("Y-m-d"));

		$obj = new DB_connect();

		$query = "SELECT task_id FROM teacher_tasks JOIN tasks ON (tasks.id = teacher_tasks.task_id) WHERE teacher_id = ".$_SESSION['id']." AND of_date LIKE '%".$date."%'";
		$result = $obj->select_records($conn, $query);
?>
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<input class="date" id="date" type="date">
						<button type="button" id="share" class="btn btn-success pull-right">Share</button>
					</div>
					<div class="box-body">
						<input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>">
						<table id="timetable" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th></th>
									<th>Subject</th>
									<th>Class</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result as $key => $value) {
									$query2 = "SELECT class, name FROM subjects INNER JOIN tasks ON (tasks.subject_id = subjects.id) WHERE tasks.id = ".$value['task_id'];
									$result2 = $obj->select_records($conn, $query2);
									foreach ($result2 as $key => $value2) { 
									$count = 1; ?>
									<tr task_id="<?php echo $value['task_id']; ?>">
										<td><?php echo $count; ?></td>
										<td><?php echo $value2['name']; ?></td>
										<td><?php echo $value2['class']; ?></td>
										<td class="timer"></td>
										<td>
											<button class="btn btn-info start">Start</button>
											<button class="btn btn-info stop" task_id=<?php echo $value['task_id'] ?>>Stop</button>
											<button class="btn btn-info pause">Pause</button>
											<button class="btn btn-info resume">Resume</button>
										</td>
									</tr>
								<?php $count++; } } ?>
							</tbody>
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