<?php
	require_once('config.php');

	include $BASEDIR . 'header/header.php';

	$conn = new mysqli($server, $usernamedb, $passworddb, $database);
	if($conn->connect_errno) {
		die('Could not connect: ' .$conn->connect_error);
	}
	
	
	$sql = "SELECT * FROM opdrachten";
	$result = $conn->query($sql);
	
	if(isset($_POST['submitAll'])) {
		if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['level']) && isset($_POST['category']) && isset($_POST['requirements']) && isset($_POST['template']) && isset($_POST['youtubeId'])){
			$name = $conn->real_escape_string($_POST['name']);
			$description = $conn->real_escape_string($_POST['description']);
			$level = $conn->real_escape_string($_POST['level']);
			$category = $conn->real_escape_string($_POST['category']);
			$requirements = $conn->real_escape_string($_POST['requirements']);
			$templatecode = $conn->real_escape_string($_POST['template']);
			$youtubeid = $conn->real_escape_string($_POST['youtubeId']);
			$sql = "INSERT INTO `opdrachten` (`id`, `naam`, `description`, `moeilijkheidsgraad`, `categorie`, `requirements`, `templatecode`, `youtubeid`) VALUES (NULL, '$name', '$description', '$level', '$category', '$requirements', '$templatecode', '$youtubeid')";
			$conn->query($sql);
			header("refresh:0;url=docent_opdr.php");
		}
	}
	
	mysqli_close($conn);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

<div class="extrainfoheader_docent">
	<!-- <div style='margin-top: 40px;'>&nbsp</div> -->

	<div class="extrainfosub_docent">
		<h5>Opdrachten: <small><a href="newassignment.php" style="color: #B30000; float: right; margin-top: 3px;">Opdracht toevoegen</a></small> </h5>
    </div>

    <?php
    if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			?>
			<tr>
				<li><a href=<?php echo "docent_opdr.php?opdr="; echo $row["id"]; ?>><?php echo $row["naam"]; ?></a></li>
			</tr>
			<?php
		}
	}else{
		echo "<tr><td>Nog geen opdrachten ingevoerd</td></tr>";
	}
	?>
	
</div>

<br />
<h1>Opdracht Toevoegen: </h1>
<hr class="hr"/>
<br />

	<form action="" name="formvalues" method="post">
    	<label>Naam</label>: <input type="text" name="name" value=""/>	
    	<br />
    	<label>Ondertitel</label>: <input type="text" name="description" value=""/>	
    	<br />
    	<label>Moeilijkheidsgraad</label>: <input type="number" name="level" value=""/>
    	<br />
    	<label>Categorie</label>: <input type="text" name="category" value=""/>
    	<br />
    	<label>Requirements</label>:
        <textarea rows="5" cols="10" name="requirements" id="textarea" class="codetextarea_docent_requirements"></textarea>
    	<br />
    	<label>Youtube-ID</label>: <input type="text" name="youtubeId" value=""/>
    	<br />
    	<label>Template Code</label>:
        <textarea rows="5" cols="10" name="template" id="textarea" class="codetextarea_docent"></textarea>
    	<br />
        <br />
    	<input type="submit" name="submitAll" value="Save" />
	</form>

</body>
</html>