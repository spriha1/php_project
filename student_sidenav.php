<?php include_once 'header.html'; ?>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <p style="font-size: 20px; color:#f1f1f1;">Welcome <?php echo $_SESSION['firstname'] ?></p>
  <a href="profile.php">My Profile</a>
  <a href="logout.php">Logout</a>
</div>
<span style="font-size:30px;cursor:pointer;color: #ffffff" onclick="openNav()">&#9776; </span>

<script src="sidenav.js">
</script>
   
</body>
</html> 
