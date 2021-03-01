<!DOCTYPE html>
<html>
	<?php include 'header.php' ?>
	<?php
		$conn = establish_connection();
		$name = $_POST['name'];
		$date = $_POST['date'];
		$precise_time_stamp = parse_date($date);
		$precise_time = date("Y-m-d h:i:s", $precise_time_stamp);
		var_dump($precise_time);
		
		$sql_command_insert = "INSERT INTO `ddl` (`id`, `name`, `begin`, `end`, `importance`, `type`) VALUES (CURRENT_TIMESTAMP, '$name', CURRENT_TIMESTAMP, '$precise_time', '1', 'unfinished')";
		echo "\n";
		echo $sql_command_insert;
		echo "\n";
		$ret = mysqli_query($conn, $sql_command_insert);
		if($ret == NULL)
		{
			echo "Insertion failed";
		}
		else
		{
			header("Location: " . $GLOBALS['DIR']);
		}
	?>
	<?php include 'footer.php' ?>
</html>