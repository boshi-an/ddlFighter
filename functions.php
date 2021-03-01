<?php 

function establish_connection()
{
	$servername = "localhost";
	$username = "admin";
	$password = "AnBS392854382.";
	$dbname = "ddl_fighter";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_query($conn, "SET NAMES UTF8");
	return $conn;
}

function diffBetweenTwoDays ($second1, $second2)
{
	return 1.0 * ($second2 - $second1) / 86400;
}

function print_message($left_message, $right_message, $type) //type = "warning" or "success"
{
	?>
	<div class="row justify-content-center mt-6">
		<div class="col-lg-6">
			<div class="alert alert-<?php echo($type); ?> alert-dismissible fade show" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
			<span class="alert-inner--text"><strong><?php echo($left_message); ?></strong><?php echo($right_message); ?></span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">x</span>
			</button>
			</div>
		</div>
		</br>
	</div>
	<?php
}

function parse_date($str)
{
	$tmp = strtotime($str);
	#echo (strtotime("today") - strtotime("this monday")) . '\n';
	if($tmp != false) return $tmp;
	$cur_time = date('U');
	$letter_to_weekname = array("1"=>"moday", "2"=>"tuesday", "3"=>"wednesday", "4"=>"thursday", 
						"5"=>"friday", "6"=>"saturday", "7"=>"sunday", 
						"一"=>"moday", "二"=>"tuesday", "三"=>"wednesday", "四"=>"thursday", 
						"五"=>"friday", "六"=>"saturday", "七"=>"sunday", "日"=>"sunday");
	if(preg_match("/[下]*周[1-7]$/A", $str, $matched))
	{
		$numbers = array();
		$next = array();
		preg_match_all("/[0-9]{1,4}/", $matched[0], $numbers);
		preg_match_all("/下/",$matched[0], $next);
		$now = strtotime("this " . $letter_to_weekname[$numbers[0][0]]);
		#var_dump($next[0]);
		#echo "Case 1:";
		#echo date("Y-m-d", $now + sizeof($next[0]) * 604800);
		return $now + sizeof($next[0]) * 604800;
	}
	else if(preg_match('/[下]*周[一二三四五六七日]$/uA', $str, $matched))
	{
		#var_dump($matched);
		$numbers = array();
		$next = array();
		preg_match_all("/[一二三四五六七日]/u", $matched[0], $numbers);
		echo "Case 2:";
		preg_match_all("/下/", $matched[0], $next);
		#var_dump($numbers);
		$now = strtotime("this " . $letter_to_weekname[$numbers[0][0]]);
		#var_dump($next[0]);
		#echo date("Y-m-d", $now + sizeof($next[0]) * 604800);
		return $now + sizeof($next[0]) * 604800;
	}
	else
	{
		echo "Not in any Case:";
	}
}

?>