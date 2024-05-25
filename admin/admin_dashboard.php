<?php include ('../includes/header.php') ?>
<?php include ('../includes/session.php') ?>
<head>
<style>
    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-gap: 1em;
        padding: 1em;
        background: #f3f3f3;
        border-radius: 1em;
    }
    .day {
        background: #fff;
        padding: 1em;
        border-radius: 0.5em;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .day h2 {
        margin: 0;
        font-size: 1.2em;
        color: #333;
    }
    .day p {
        margin: 0.5em 0 0;
        font-size: 0.9em;
        color: #666;
    }
</style>
</head>

<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="" alt=""></div>
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
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4 user-icon">
						<img src="../vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">

						<?php $query = mysqli_query($conn, "select * from tblemployees where emp_id = '$session_id'") or die(mysqli_error());
						$row = mysqli_fetch_array($query);
						?>

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome back <div class="weight-600 font-30 text-blue">
								<?php echo $row['FirstName'] . " " . $row['LastName']; ?>
							</div>
						</h4>
					</div>
				</div>
			</div>
			<div class='calendar'>
			<?php
// 1. Query the database to get all the leave records for the current month.
$query = mysqli_query($conn, "SELECT * FROM tblleave WHERE MONTH(FromDate) = MONTH(CURRENT_DATE()) AND YEAR(FromDate) = YEAR(CURRENT_DATE())") or die(mysqli_error());

$leaves = array();
while ($row = mysqli_fetch_array($query)) {
    for ($date = strtotime($row['FromDate']); $date <= strtotime($row['ToDate']); $date = strtotime('+1 day', $date)) {
        $leaves[date('Y-m-d', $date)][] = $row['empid'];
    }
}

// 2. Create a calendar for the current month.
$daysInMonth = date('t');
for ($day = 1; $day <= $daysInMonth; $day++) {
    $date = date('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

    // 3. Check if there are any leave records that include that day.
    if (isset($leaves[$date])) {
        // 4. Add the names of the employees on leave to that day on the calendar.
        echo "<div class='day'>";
        echo "<h2>$day</h2>";
        foreach ($leaves[$date] as $employeeId) {
            $query = mysqli_query($conn, "SELECT * FROM tblemployees WHERE emp_id = '$employeeId'") or die(mysqli_error());
            $row = mysqli_fetch_array($query);
            echo "<p>{$row['FirstName']} {$row['LastName']} is on leave</p>";
        }
        echo "</div>";
    } else {
        echo "<div class='day'><h2>$day</h2></div>";
    }
}
?>
</div>
			<div class="title pb-20">
				<h2 class="h3 mb-0">Data Information</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from tblemployees";
						$query = $dbh->prepare($sql);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$empcount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($empcount); ?></div>
								<div class="font-14 text-secondary weight-500">Total Staffs</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status = 1;
						$sql = "SELECT id FROM tblleave WHERE HodRemarks = :status UNION ALL SELECT id FROM tblhodleave WHERE CEORemarks = :status AND DceoRemarks = :status;";
						$query = $dbh->prepare($sql);
						$query->bindParam(':status', $status, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$leavecount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Approved Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy fa fa-hourglass"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status = 0;
						$sql = "SELECT id FROM tblleave WHERE HodRemarks = :status UNION ALL SELECT id FROM tblhodleave WHERE CEORemarks = :status OR DceoRemarks = :status;";
						$query = $dbh->prepare($sql);
						$query->bindParam(':status', $status, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$leavecount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Pending Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy fa fa-hourglass-end" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status = 2;
						$sql = "SELECT id FROM tblleave WHERE HodRemarks = :status UNION ALL SELECT id FROM tblhodleave WHERE CEORemarks = :status AND DceoRemarks = :status;";
						$query = $dbh->prepare($sql);
						$query->bindParam(':status', $status, PDO::PARAM_STR);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$leavecount = $query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo ($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Rejected Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy fa fa-hourglass-o"
										aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Department Heads</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc"
										data-color="#17a2b8"></i></a>
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
								$query = mysqli_query($conn, "select * from tblemployees where role='HOD' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
								while ($row = mysqli_fetch_array($query)) {
									$id = $row['emp_id'];
									?>

									<li class="d-flex align-items-center justify-content-between">
										<div class="name-avatar d-flex align-items-center pr-2">
											<div class="avatar mr-2 flex-shrink-0">
												<img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>"
													class="border-radius-100 box-shadow" width="50" height="50" alt="">
											</div>
											<div class="txt">
												<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5"
													data-color="#265ed7"><?php echo $row['Department']; ?></span>
												<div class="font-14 weight-600">
													<?php echo $row['FirstName'] . " " . $row['LastName']; ?>
												</div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													<?php echo $row['EmailId']; ?>
												</div>
											</div>
										</div>
										<div class="font-12 weight-500" data-color="#17a2b8">
											<?php echo $row['Phonenumber']; ?>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Application Setup</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc"
										data-color="#17a2b8"></i></a>
							</div>
						</div>

						<div id="application-chart"></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Staff</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy ion-disc"
										data-color="#17a2b8"></i></a>
							</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
								$query = mysqli_query($conn, "select * from tblemployees where role = 'Staff' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
								while ($row = mysqli_fetch_array($query)) {
									$id = $row['emp_id'];
									?>

									<li class="d-flex align-items-center justify-content-between">
										<div class="name-avatar d-flex align-items-center pr-2">
											<div class="avatar mr-2 flex-shrink-0">
												<img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>"
													class="border-radius-100 box-shadow" width="50" height="50" alt="">
											</div>
											<div class="txt">
												<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5"
													data-color="#265ed7"><?php echo $row['Department']; ?></span>
												<div class="font-14 weight-600">
													<?php echo $row['FirstName'] . " " . $row['LastName']; ?>
												</div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													<?php echo $row['EmailId']; ?>
												</div>
											</div>
										</div>
										<div class="font-12 weight-500" data-color="#17a2b8">
											<?php echo $row['Phonenumber']; ?>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-blue h4">LATEST STAFF LEAVE APPLICATIONS</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>HOD STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.Sign,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.HodSign,tblleave.HodDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id order by lid desc limit 5";
								$query = mysqli_query($conn, $sql) or die(mysqli_error());
								while ($row = mysqli_fetch_array($query)) {
									$cnt = 1;
									?>

									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="txt mr-2 flex-shrink-0">
												<b><?php echo htmlentities($cnt); ?></b>
											</div>
											<div class="txt">
												<div class="weight-600">
													<?php echo $row['FirstName'] . " " . $row['LastName']; ?>
												</div>
											</div>
										</div>
									</td>
									<td><?php echo $row['LeaveType']; ?></td>
									<td><?php echo $row['PostingDate']; ?></td>
									<td><?php $stats = $row['HodRemarks'];
									if ($stats == 1) {
										?>
											<span style="color: green">Approved</span>
										<?php }
									if ($stats == 2) { ?>
											<span style="color: red">Rejected</span>
										<?php }
									if ($stats == 0) { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
												href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item"
													href="leave_details.php?leaveid=<?php echo $row['lid']; ?>"><i
														class="dw dw-eye"></i> View</a>
												<a class="dropdown-item"
													href="admin_dashboard.php?leaveid=<?php echo $row['lid']; ?>"><i
														class="dw dw-delete-3"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								<?php $cnt++;
								} ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-box mb-30">
				<div class="pd-20">
					<h2 class="text-blue h4">LATEST HOD LEAVE APPLICATIONS</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>CEO STATUS</th>
								<th>DCEO STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								$sql = "SELECT tblhodleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblhodleave.LeaveType,tblhodleave.ToDate,tblhodleave.FromDate,tblhodleave.PostingDate,tblhodleave.RequestedDays,tblhodleave.DaysOutstand,tblhodleave.Sign,tblhodleave.WorkCovered,tblhodleave.CeoRemarks,tblhodleave.DceoRemarks, tblhodleave.CeoSign, tblhodleave.DceoSign, tblhodleave.CeoDate, tblhodleave.DceoDate, tblhodleave.num_days from tblhodleave join tblemployees on tblhodleave.empid=tblemployees.emp_id order by lid desc limit 5";
								$query = mysqli_query($conn, $sql) or die(mysqli_error());
								while ($row = mysqli_fetch_array($query)) {
									$cnt = 1;
									?>

									<td class="table-plus">
										<div class="name-avatar d-flex align-items-center">
											<div class="txt mr-2 flex-shrink-0">
												<b><?php echo htmlentities($cnt); ?></b>
											</div>
											<div class="txt">
												<div class="weight-600">
													<?php echo $row['FirstName'] . " " . $row['LastName']; ?>
												</div>
											</div>
										</div>
									</td>
									<td><?php echo $row['LeaveType']; ?></td>
									<td><?php echo $row['PostingDate']; ?></td>
									<td><?php $stats = $row['CeoRemarks'];
									if ($stats == 1) {
										?>
											<span style="color: green">Approved</span>
										<?php }
									if ($stats == 2) { ?>
											<span style="color: red">Rejected</span>
										<?php }
									if ($stats == 0) { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</td>
									<td><?php $stats = $row['DceoRemarks'];
									if ($stats == 1) {
										?>
											<span style="color: green">Approved</span>
										<?php }
									if ($stats == 2) { ?>
											<span style="color: red">Rejected</span>
										<?php }
									if ($stats == 0) { ?>
											<span style="color: blue">Pending</span>
										<?php } ?>
									</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
												href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item"
													href="leave_hod_details.php?leaveid=<?php echo $row['lid']; ?>"><i
														class="dw dw-eye"></i> View</a>
												<a class="dropdown-item"
													href="admin_dashboard.php?leaveid=<?php echo $row['lid']; ?>"><i
														class="dw dw-delete-3"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								<?php $cnt++;
								} ?>
						</tbody>
					</table>
				</div>
			</div>

			<?php include ('../includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include ('../includes/scripts.php') ?>
</body>

</html>