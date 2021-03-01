<!DOCTYPE html>
<html>
	<?php include 'header.php' ?>
	<?php
	$conn = establish_connection();
	$sql_command = "SELECT *  FROM `ddl` WHERE `importance` = 1";
	$result = mysqli_query($conn, $sql_command);
	$list_per_day = array();
	$list_week_name = array('Sun', 'Mon', 'Tue', 'Wen', 'Thr', 'Fri', 'Sat');
	$today_weekday = date("w");
	$today_Uday = date("U");
	$todo = array();
	for($i=0; $i<7; $i++) array_push($list_per_day, array());
	while($row = mysqli_fetch_assoc($result)) {
		$weekday = date("w",strtotime($row["end"]));
		$Uday = date("U", strtotime($row["end"]));
		$diff_day = diffBetweenTwoDays($today_Uday, $Uday);
		if($diff_day<=7 && $diff_day>=0) {
			array_push($list_per_day[$weekday], $row);
		}
		array_push($todo, $row);
	}
	?>

	<body>
		<section class="section section-hero section-shaped">
			<!-- Background circles -->
			<div class="shape shape-style-1 shape-primary">
				<span class="span-150"></span>
				<span class="span-50"></span>
				<span class="span-50"></span>
				<span class="span-75"></span>
				<span class="span-100"></span>
				<span class="span-75"></span>
				<span class="span-50"></span>
				<span class="span-100"></span>
				<span class="span-50"></span>
				<span class="span-100"></span>
			</div>
			<div class="container shape-container d-flex align-items-center">
				<div class="col">
					<div class="row align-items-center justify-content-center">
						<div class="col-lg-6 text-center">
							<h1 class="text-white">DDL Fighter</h1>
							<hr/>
							<p class="lead text-white"><?php echo "Today: " . date("y-m-d l");?></p>
						</div>
					</div>
				</div>
			</div>

			<div class="container mt-5">
				<div class="card shadow">
					<div class="card-body">
						<div class="container">
							<div class="row align-content-around">
								<?php
								for($i=0; $i<7; $i++) {
									$pos = ($today_weekday + $i) % 7;
									?>
									<div class="col align-items-center">
										<p><button type="button" class="btn btn-outline-primary"><?php echo $list_week_name[$pos];?></button></p>
										<?php
										foreach($list_per_day[$pos] as $item) {
											echo sprintf('<p><button type="button" class="btn btn-outline-primary">%s</button></p>', $item["name"]);
										}
										?>
									</div>
									<?php
								}
								?>
							</div>
							<hr></hr>
							<?php
							foreach($todo as $item) {
								$Ubegin = date("U", strtotime($item["begin"]));
								$Uend = date("U", strtotime($item["end"]));
								$percentage = 1.0 * ($today_Uday - $Ubegin) / ($Uend - $Ubegin) * 100;
								$line_color = "bg-primary";
								$button_color = "btn-primary";
								$button_type = "No-use";
								$button = "Finished";
								if($percentage > 100) {$line_color = "bg-default"; $button = "Expired"; $button_color = "btn-defaut"; $button_type = "Expired"; }
								else if($percentage >= 80) $line_color = "bg-danger";
								else if($percentage >= 40) $line_color = "bg-warning";
								?>
								<div class="row align-items-center">
									<div class="col-sm-2">
										<small class="text-uppercase text-muted font-weight-bold"><?php echo $item["name"]; ?></small>
										<small class="progress-percentage"><?php echo ceil(min($percentage, 100));?>%</small>
									</div>
									<div class="progress-wrapper col-sm-9 mt-1 mb-1">
										<div class="progress">
											<div class="progress-bar <?php echo $line_color; ?>" role="progressbar" aria-valuenow="<?php echo $percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo min($percentage, 100);?>%;"></div>
										</div>
									</div>
									<?php
										if($button_type == "Expired")
										{
											?>
											<div class="col-sm-1">
												<form method="post" action="removeexpired.php" name="remove-expired">
													<button type="submit" class="btn btn-sm <?php echo $button_color; ?> mt-1 mb-1" type="button" name="name" value="<?php echo $item["id"]; ?>"><?php echo $button; ?></button>
												</form>
											</div>
											<?php
										}
										else
										{
											?>
											<div class="col-sm-1">
												<button class="btn btn-sm <?php echo $button_color; ?> mt-1 mb-1" type="button"><?php echo $button; ?></button>
											</div>
											<?php
										}
									?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="container mt-5">
				<div class="card shadow">
					<div class="card-body">
						<div class="container">
							<form method="post" action="addddl.php" name="add_form">
								<div class="row align-content-around">
									<div class="col mt-1 mb-1">
										<div class="form-group">
											<input type="text" name="name" placeholder="名称" class="form-control" required="required">
										</div>
									</div>
									<div class="col mt-1 mb-1">
										<div class="form-group">
											<input type="text" name="date" placeholder="日期(一个可以理解的日期)" class="form-control" required="required">
										</div>
									</div>
								</div>
								<div class="row justify-content-center">
									<button type="submit" class="btn btn-primary">提交</button>
									<a href="index.php"><button type="button" class="btn btn-primary"> 取消 </button></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include 'footer.php' ?>
	</body>
</html>