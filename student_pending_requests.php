<?php 
session_start();

include_once 'header.html';?>
<body>
	<?php
		include_once 'db_connection.php';
		include_once 'db_credentials.php';

	    $obj = new DB_connect();
	    $conn = $obj->connect('localhost','php_project',$username,$password);

	    $query = "SELECT firstname, lastname, email, username FROM users where user_reg_status = 0 AND user_type_id = (SELECT u_id FROM type_of_user where user_type = 'Student')";
		
	    $result = $obj->select_records($query);
	    echo "<div class='container'>";
	    echo "<div class='card-columns'>";
	    foreach ($result as $key => $value) {
	     	echo "<div class='card bg-secondary'>";
	     	echo "<div class='card-body text-center'>";
	     	echo '<form>
					    <div class="form-group">
					      First Name :<input type="text" class="form-control" value="'.$value["firstname"].'">
					    </div>
					    <div class="form-group">
					      Last Name :<input type="text" class="form-control" value="'.$value["lastname"].'">
					    </div>
					    <div class="form-group">
					      Username :<input type="text" class="form-control" value="'.$value["username"].'">
					    </div>
					    <div class="form-group">
					      Email:<input type="text" class="form-control" value="'.$value["email"].'">
					    </div>

					    </form>';
			echo '<a href="add_users.php?username='.$value["username"].'"><button>Accept</button></a>';
			echo '<a href="remove_users.php?username='.$value["username"].'"><button>Reject</button></a>';
			echo '<a href="block_users.php?username='.$value["username"].'"><button>Block</button></a>';

	     	echo "</div></div>";
	     } 
	?>	
</body>