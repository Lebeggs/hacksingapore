<?php error_reporting(0); ?>
<?php include ('../includes/header.php') ?>
<?php include ('../includes/session.php') ?>

<?php
// code for update the read notification status
$isread = 1;
$position = $session_position;
$did = intval($_GET['leaveid']);
date_default_timezone_set('Asia/Kolkata');
$admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
$sql = "update tblhodleave set IsRead=:isread where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread', $isread, PDO::PARAM_STR);
$query->bindParam(':did', $did, PDO::PARAM_STR);
$query->execute();

// code for action taken on leave
if (isset($_POST['update'])) {
	$did = intval($_GET['leaveid']);
	$status = $_POST['status'];
	$av_leave = $_POST['av_leave'];
	$num_days = $_POST['num_days'];
	// Getting the signature
	$query = mysqli_query($conn, "select * from tblemployees where emp_id = '$session_id'") or die(mysqli_error());
	$row = mysqli_fetch_assoc($query);

	$signature = $row['signature'];

	$REMLEAVE = $av_leave - $num_days;
	date_default_timezone_set('Asia/Kolkata');
	$admremarkdate = date('Y-m-d ', strtotime("now"));
	
	if ($position == 'CEO' and $status == 2) {
		// Reject leave
		$sql = "update tblhodleave set CeoRemarks=:status,CeoDate=:admremarkdate where id=:did";

		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
		$query->bindParam(':did', $did, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Leave Rejected Successfully!');</script>";
	} elseif ($position == 'CEO' and $status == 1) {
		// Approve leave
		$sql = "update tblhodleave, tblemployees set tblhodleave.CeoRemarks=:status,tblhodleave.CeoSign=:signature, tblhodleave.CeoDate=:admremarkdate, tblhodleave.DaysOutstand=:REMLEAVE, tblemployees.Av_leave=:REMLEAVE WHERE tblhodleave.empid = tblemployees.emp_id AND tblhodleave.id=:did";

		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':signature', $signature, PDO::PARAM_STR);
		$query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
		$query->bindParam(':REMLEAVE', $REMLEAVE, PDO::PARAM_STR);
		$query->bindParam(':did', $did, PDO::PARAM_STR);
		$query->execute();

		if ($query) {
			echo "<script>alert('Leave Approved Successfully!');</script>";
		} else {
			die(mysqli_error());
		}
	}

	if ($position == 'Deputy CEO' and $status == 2) {
		// Reject leave
		$sql = "update tblhodleave set DceoRemarks=:status,DceoDate=:admremarkdate where id=:did";

		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
		$query->bindParam(':did', $did, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Leave Rejected Successfully!');</script>";
	} elseif ($position == 'Deputy CEO' and $status == 1) {
		// Approve leave
		$sql = "update tblhodleave, tblemployees set tblhodleave.DceoRemarks=:status,tblhodleave.DceoSign=:signature, tblhodleave.DceoDate=:admremarkdate, tblhodleave.DaysOutstand=:REMLEAVE, tblemployees.Av_leave=:REMLEAVE WHERE tblhodleave.empid = tblemployees.emp_id AND tblhodleave.id=:did";

		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':signature', $signature, PDO::PARAM_STR);
		$query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
		$query->bindParam(':REMLEAVE', $REMLEAVE, PDO::PARAM_STR);
		$query->bindParam(':did', $did, PDO::PARAM_STR);
		$query->execute();

		if ($query) {
			echo "<script>alert('Leave Approved Successfully!');</script>";
		} else {
			die(mysqli_error());
		}
	}

}

// date_default_timezone_set('Asia/Kolkata');
// $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));

// $sql="update tblleaves set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";

// $query = $dbh->prepare($sql);
// $query->bindParam(':description',$description,PDO::PARAM_STR);
// $query->bindParam(':status',$status,PDO::PARAM_STR);
// $query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
// $query->bindParam(':did',$did,PDO::PARAM_STR);
// $query->execute();
// echo "<script>alert('Leave updated Successfully');</script>";

?>

<style>
	input[type="text"] {
		font-size: 16px;
		color: #0f0d1b;
		font-family: Verdana, Helvetica;
	}

	.btn-outline:hover {
		color: #fff;
		background-color: #524d7d;
		border-color: #524d7d;
	}

	textarea {
		font-size: 16px;
		color: #0f0d1b;
		font-family: Verdana, Helvetica;
	}

	textarea.text_area {
		height: 8em;
		font-size: 16px;
		color: #0f0d1b;
		font-family: Verdana, Helvetica;
	}
</style>

<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="../vendors/images/deskapp-logo-svg.png" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<?php include ('includes/navbar.php') ?>

	<?php include ('../includes/right_sidebar.php') ?>

	<?php include ('includes/left_sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>LEAVE DETAILS</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Leave</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							<div class="dropdown show">
								<a class="btn btn-primary"
									href="report_pdf.php?leave_id=<?php echo $_GET['leaveid'] ?>">
									Generate Report
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Leave Details</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<form method="post" action="">

						<?php
						if (!isset($_GET['leaveid']) && empty($_GET['leaveid'])) {
							header('Location: admin_dashboard.php');
						} else {

							$lid = intval($_GET['leaveid']);
							$sql = "SELECT tblhodleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblhodleave.LeaveType,tblhodleave.ToDate,tblhodleave.FromDate,tblhodleave.PostingDate,tblhodleave.RequestedDays,tblhodleave.DaysOutstand,tblhodleave.Sign,tblhodleave.WorkCovered,tblhodleave.CeoRemarks,tblhodleave.DceoRemarks,tblhodleave.CeoSign,tblhodleave.DceoSign,tblhodleave.CeoDate,tblhodleave.DceoDate,tblhodleave.num_days from tblhodleave join tblemployees on tblhodleave.empid=tblemployees.emp_id where tblhodleave.id=:lid";
							$query = $dbh->prepare($sql);
							$query->bindParam(':lid', $lid, PDO::PARAM_STR);
							$query->execute();
							$results = $query->fetchAll(PDO::FETCH_OBJ);
							$cnt = 1;
							if ($query->rowCount() > 0) {
								foreach ($results as $result) {
									?>

									<div class="row">
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Full Name</b></label>
												<input type="text" class="selectpicker form-control"
													data-style="btn-outline-primary" readonly
													value="<?php echo htmlentities($result->FirstName . " " . $result->LastName); ?>">
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Staff Position</b></label>
												<input type="text" class="selectpicker form-control" data-style="btn-outline-info"
													readonly value="<?php echo htmlentities($result->Position_Staff); ?>">
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Email Address</b></label>
												<input type="text" class="selectpicker form-control" data-style="btn-outline-info"
													readonly value="<?php echo htmlentities($result->EmailId); ?>">
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Leave Type</b></label>
												<input type="text" class="selectpicker form-control" data-style="btn-outline-info"
													readonly value="<?php echo htmlentities($result->LeaveType); ?>">
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Applied Date</b></label>
												<input type="text" class="selectpicker form-control"
													data-style="btn-outline-success" readonly
													value="<?php echo htmlentities($result->PostingDate); ?>">
											</div>
										</div>

										<!-- <div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Approval from previous year </b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->PreviouDays); ?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Leave Entitlement</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->LeaveEntitled); ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size:16px;"><b>Cumulative Leave Entitlement</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="From <?php echo htmlentities($result->CumulativeLeave); ?>">
								</div>
							</div> -->

										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Requested Number of Days</b></label>
												<input type="text" class="selectpicker form-control" data-style="btn-outline-info"
													readonly name="num_days" value="<?php echo htmlentities($result->num_days); ?>">
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Number Days still outstanding</b></label>
												<input type="text" class="selectpicker form-control" data-style="btn-outline-info"
													readonly name="av_leave"
													value="<?php echo htmlentities($result->DaysOutstand); ?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-size:16px;"><b>Leave Period</b></label>
												<input type="text" class="selectpicker form-control" data-style="btn-outline-info"
													readonly
													value="From <?php echo htmlentities($result->FromDate); ?> to <?php echo htmlentities($result->ToDate); ?>">
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Staff Signature</b></label>
												<div class="avatar mr-2 flex-shrink-0">
													<img src="<?php echo '../signature/' . ($result->Sign); ?>" width="60"
														height="40" alt="">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>CEO's Approval</b></label>
												<?php
												if ($result->CeoSign == ""): ?>
													<input type="text" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
												<?php else: ?>
													<div class="avatar mr-2 flex-shrink-0">
														<img src="<?php echo '../signature/' . ($result->CeoSign); ?>" width="100"
															height="40" alt="">
													</div>
												<?php endif ?>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>DCEO's Approval</b></label>
												<?php
												if ($result->DceoSign == ""): ?>
													<input type="text" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
												<?php else: ?>
													<div class="avatar mr-2 flex-shrink-0">
														<img src="<?php echo '../signature/' . ($result->DceoSign); ?>" width="100"
															height="40" alt="">
													</div>
												<?php endif ?>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Date For CEO's Action</b></label>
												<?php
												if ($result->CeoDate == ""): ?>
													<input type="text" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
												<?php else: ?>
													<div class="avatar mr-2 flex-shrink-0">
														<input type="text" class="selectpicker form-control"
															data-style="btn-outline-primary" readonly
															value="<?php echo htmlentities($result->CeoDate); ?>">
													</div>
												<?php endif ?>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Date For DCEO's Action</b></label>
												<?php
												if ($result->DceoDate == ""): ?>
													<input type="text" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
												<?php else: ?>
													<div class="avatar mr-2 flex-shrink-0">
														<input type="text" class="selectpicker form-control"
															data-style="btn-outline-primary" readonly
															value="<?php echo htmlentities($result->DceoDate); ?>">
													</div>
												<?php endif ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Leave Status From CEO</b></label>
												<?php $stats = $result->CeoRemarks; ?>
												<?php
												if ($stats == 1): ?>
													<input type="text" style="color: green;" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
													<?php
												elseif ($stats == 2): ?>
													<input type="text" style="color: red; font-size: 16px;"
														class="selectpicker form-control" data-style="btn-outline-primary" readonly
														value="<?php echo "Rejected"; ?>">
													<?php
												else: ?>
													<input type="text" style="color: blue;" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
												<?php endif ?>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label style="font-size:16px;"><b>Leave Status From DCEO</b></label>
												<?php $ad_stats = $result->DceoRemarks; ?>
												<?php
												if ($ad_stats == 1): ?>
													<input type="text" style="color: green;" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
													<?php
												elseif ($ad_stats == 2): ?>
													<input type="text" style="color: red; font-size: 16px;"
														class="selectpicker form-control" data-style="btn-outline-primary" readonly
														value="<?php echo "Rejected"; ?>">
													<?php
												else: ?>
													<input type="text" style="color: blue;" class="selectpicker form-control"
														data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
												<?php endif ?>
											</div>
										</div>
										<?php
										if (!($stats == 1 and $ad_stats == 1)) {

											?>
											<div class="col-md-12">
												<div class="form-group">
													<label style="font-size:16px;"><b></b></label>
													<div class="modal-footer justify-content-center">
														<button class="btn btn-primary" id="action_take" data-toggle="modal"
															data-target="#success-modal">Take&nbsp;Action</button>
													</div>
												</div>
											</div>

											<form name="adminaction" method="post">
												<div class="modal fade" id="success-modal" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered" role="document">
														<div class="modal-content">
															<div class="modal-body text-center font-18">
																<h4 class="mb-20">Leave take action</h4>
																<select name="status" required class="custom-select form-control">
																	<option value="">Choose your option</option>
																	<option value="1">Approved</option>
																	<option value="2">Rejected</option>
																</select>
															</div>
															<div class="modal-footer justify-content-center">
																<input type="submit" class="btn btn-primary" name="update"
																	value="Submit">
															</div>
														</div>
													</div>
												</div>
											</form>

										<?php } ?>

										<?php $cnt++;
								}
							}
						} ?>
					</form>
				</div>

			</div>

			<?php include ('../includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include ('../includes/scripts.php') ?>
</body>

</html>