<?php include ('../includes/header.php') ?>
<?php include ('../includes/session.php') ?>

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
			<div class="title pb-20">
				<h2 class="h3 mb-0">Data Information</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from tblemployees where (role = 'Staff' or role = 'HOD') and (Department = '$session_depart' OR SubDepartment = '$session_depart') AND emp_id != '$session_id'";
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
						if ($session_position == 'CEO') {
							$sql = "SELECT THL.id, TE.emp_id 
									FROM tblhodleave AS THL 
									JOIN tblemployees AS TE ON THL.empid = TE.emp_id 
									WHERE CeoRemarks = :status
									AND TE.SubDepartment = '$session_depart' 
									AND TE.role = 'HOD'";
						} elseif ($session_position == 'Deputy CEO') {
							$sql = "SELECT THL.id, TE.emp_id 
									FROM tblhodleave AS THL 
									JOIN tblemployees AS TE ON THL.empid = TE.emp_id 
									WHERE DceoRemarks = :status
									AND TE.SubDepartment = '$session_depart' 
									AND TE.role = 'HOD'";
						} else {
							$sql = "SELECT TL.id, TE.emp_id 
									FROM tblleave AS TL 
									JOIN tblemployees AS TE ON TL.empid = TE.emp_id 
									WHERE HodRemarks = :status 
									AND TE.Department = '$session_depart' 
									AND TE.role = 'Staff'";
						}

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
						if ($session_position == 'CEO') {
							$sql = "SELECT THL.id, TE.emp_id 
									FROM tblhodleave AS THL 
									JOIN tblemployees AS TE ON THL.empid = TE.emp_id 
									WHERE CeoRemarks = :status
									AND TE.SubDepartment = '$session_depart' 
									AND TE.role = 'HOD'";
						} elseif ($session_position == 'Deputy CEO') {
							$sql = "SELECT THL.id, TE.emp_id 
									FROM tblhodleave AS THL 
									JOIN tblemployees AS TE ON THL.empid = TE.emp_id 
									WHERE DceoRemarks = :status
									AND TE.SubDepartment = '$session_depart' 
									AND TE.role = 'HOD'";
						} else {
							$sql = "SELECT TL.id, TE.emp_id 
									FROM tblleave AS TL 
									JOIN tblemployees AS TE ON TL.empid = TE.emp_id 
									WHERE HodRemarks = :status 
									AND TE.Department = '$session_depart' 
									AND TE.role = 'Staff'";
						}
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
						if ($session_position == 'CEO') {
							$sql = "SELECT THL.id, TE.emp_id 
									FROM tblhodleave AS THL 
									JOIN tblemployees AS TE ON THL.empid = TE.emp_id 
									WHERE CeoRemarks = :status
									AND TE.SubDepartment = '$session_depart' 
									AND TE.role = 'HOD'";
						} elseif ($session_position == 'Deputy CEO') {
							$sql = "SELECT THL.id, TE.emp_id 
									FROM tblhodleave AS THL 
									JOIN tblemployees AS TE ON THL.empid = TE.emp_id 
									WHERE DceoRemarks = :status
									AND TE.SubDepartment = '$session_depart' 
									AND TE.role = 'HOD'";
						} else {
							$sql = "SELECT TL.id, TE.emp_id 
									FROM tblleave AS TL 
									JOIN tblemployees AS TE ON TL.empid = TE.emp_id 
									WHERE HodRemarks = :status 
									AND TE.Department = '$session_depart' 
									AND TE.role = 'Staff'";
						}
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
				<div class="col-lg-6 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Staff Information and Leaves Summary</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
								$query = mysqli_query($conn, "select * from tblemployees where (role = 'Staff' OR role = 'HOD') AND (Department = '$session_depart' OR SubDepartment = '$session_depart') AND emp_id != '$session_id' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
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
													data-color="#265ed7"><?php echo $row['Position_Staff']; ?></span>
												<div class="font-14 weight-600">
													<?php echo $row['FirstName'] . " " . $row['LastName']; ?>
												</div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													<?php echo $row['EmailId']; ?>
												</div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													<?php echo $row['Phonenumber']; ?>
												</div>
											</div>
										</div>
										<div class="font-12 weight-500" data-color="#17a2b8">
											<?php echo $row['Av_leave']; ?>
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
					<h2 class="text-blue h4">LATEST LEAVE APPLICATIONS</h2>
				</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STAFF NAME</th>
								<th>LEAVE TYPE</th>
								<th>APPLIED DATE</th>
								<th>MY REMARKS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php
								if ($session_position == 'CEO') {
									$sql = "SELECT 
									tblhodleave.id as lid,
									tblemployees.FirstName,
									tblemployees.LastName,
									tblemployees.emp_id,
									tblhodleave.LeaveType,
									tblhodleave.PostingDate,
									tblhodleave.CeoRemarks AS HodRemarks
									FROM tblhodleave
									JOIN tblemployees ON tblhodleave.empid = tblemployees.emp_id
									WHERE tblemployees.role = 'HOD' 
									AND tblemployees.SubDepartment = '$session_depart' 
									ORDER BY lid DESC
									LIMIT 5;";
								} elseif ($session_position == 'Deputy CEO') {
									$sql = " SELECT 
									tblhodleave.id as lid,
									tblemployees.FirstName,
									tblemployees.LastName,
									tblemployees.emp_id,
									tblhodleave.LeaveType,
									tblhodleave.PostingDate,
									tblhodleave.DceoRemarks AS HodRemarks
									FROM tblhodleave
									JOIN tblemployees ON tblhodleave.empid = tblemployees.emp_id
									WHERE tblemployees.role = 'HOD' 
									AND tblemployees.SubDepartment = '$session_depart' 
									ORDER BY lid DESC
									LIMIT 5;";
								} else {
									$sql = "SELECT 
									tblleave.id as lid,
									tblemployees.FirstName,
									tblemployees.LastName,
									tblemployees.emp_id,
									tblleave.LeaveType,
									tblleave.PostingDate,
									tblleave.HodRemarks
									FROM tblleave
									JOIN tblemployees ON tblleave.empid = tblemployees.emp_id
									WHERE tblemployees.role = 'Staff' 
									AND tblemployees.Department = '$session_depart'
									ORDER BY lid DESC
									LIMIT 5;";
								}

								$query = $dbh->prepare($sql);
								$query->execute();
								$results = $query->fetchAll(PDO::FETCH_OBJ);
								$cnt = 1;
								if ($query->rowCount() > 0) {
									foreach ($results as $result) {
										?>

										<td class="table-plus">
											<div class="name-avatar d-flex align-items-center">
												<div class="txt mr-2 flex-shrink-0">
													<b><?php echo htmlentities($cnt); ?></b>
												</div>
												<div class="txt">
													<div class="weight-600">
														<?php echo htmlentities($result->FirstName . " " . $result->LastName); ?>
													</div>
												</div>
											</div>
										</td>
										<td><?php echo htmlentities($result->LeaveType); ?></td>
										<td><?php echo htmlentities($result->PostingDate); ?></td>
										<td><?php $stats = $result->HodRemarks;
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
											<div class="table-actions">
												<a title="VIEW"
													href="<?php echo ($session_depart === 'MGMT') ? 'leave_hod_details.php' : 'leave_details.php'; ?>?leaveid=<?php echo htmlentities($result->lid); ?>">
													<i class="dw dw-eye" data-color="#265ed7"></i>
												</a>
											</div>
										</td>
									</tr>
									<?php $cnt++;
									}
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