<!DOCTYPE html>
<html>
	<?php include 'header.php' ?>
	<?php
		$conn = establish_connection();
		$name = $_POST['name'];

		$command = "DELETE FROM `ddl` WHERE `id` = '$name'";
		var_dump($command);
		$ret = mysqli_query($conn, $command);
		if($ret == NULL)
		{
			echo "Deletion failed";
		}
		else
		{
			header("Location: ".$GLOBALS['DIR']);
		}
	?>
	<?php include 'footer.php' ?>
</html>