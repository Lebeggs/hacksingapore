<?php include ('../includes/header.php') ?>
<?php include ('../includes/session.php') ?>
<?php $get_id = $_GET['view']; ?>

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

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Staff Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="staff.php">Staff</a></li>
									<li class="breadcrumb-item active" aria-current="page">Staff View</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">View Staff</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<section>
							<?php
							$query = mysqli_query($conn, "select * from tblemployees where emp_id = '$get_id' ") or die(mysqli_error());
							$row = mysqli_fetch_array($query);
							?>

							<div class="row">
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>First Name :</label>
										<input name="firstname" type="text" class="form-control wizard-required"
											required="true" autocomplete="off" readonly
											value="<?php echo $row['FirstName']; ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Last Name :</label>
										<input name="lastname" type="text" class="form-control" required="true"
											autocomplete="off" readonly value="<?php echo $row['LastName']; ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Email Address :</label>
										<input name="email" type="email" class="form-control" required="true"
											autocomplete="off" readonly value="<?php echo $row['EmailId']; ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Staff Position :</label>
										<input name="position_staff" type="text" class="form-control wizard-required"
											required="true" autocomplete="off" readonly
											value="<?php echo $row['Position_Staff'] ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Address :</label>
										<input name="address" type="text" class="form-control" required="true"
											autocomplete="off" readonly value="<?php echo $row['Address']; ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Password :</label>
										<input name="password" type="password" placeholder="**********"
											class="form-control" readonly required="true" autocomplete="off"
											value="<?php echo $row['Password']; ?>">
									</div>
								</div>
							</div>
							<div class="row">								
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Gender :</label>
										<input name="Gender" type="text" class="form-control wizard-required"
											required="true" autocomplete="off" readonly
											value="<?php echo $row['Gender'] ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Phone Number :</label>
										<input name="phonenumber" type="text" class="form-control" required="true"
											autocomplete="off" readonly value="<?php echo $row['Phonenumber']; ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Date Of Birth :</label>
										<input name="dob" type="text" class="form-control" required="true"
											autocomplete="off" readonly value="<?php echo $row['Dob']; ?>">
									</div>
								</div>
							</div>
							<div class="row">								
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Department :</label>
										<input name="Department" type="text" class="form-control wizard-required"
											required="true" autocomplete="off" readonly
											value="<?php echo $row['Department'] ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Sub Department :</label>
										<input name="SubDepartment" type="text" class="form-control wizard-required"
											required="true" autocomplete="off" readonly
											value="<?php echo isset($row['SubDepartment']) ? $row['SubDepartment'] : '-' ?>">
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>User Role :</label>
										<input name="role" type="text" class="form-control wizard-required"
											required="true" autocomplete="off" readonly
											value="<?php echo $row['role'] ?>">
									</div>
								</div>
							</div>

							<?php
							$query = mysqli_query($conn, "select * from tblemployees where emp_id = '$get_id' ") or die(mysqli_error());
							$new_row = mysqli_fetch_array($query);
							?>
							<div class="row">
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label>Staff Leave Days :</label>
										<input name="leave_days" type="text" class="form-control" required="true"
											autocomplete="off" readonly value="<?php echo $new_row['Av_leave']; ?>">
									</div>
								</div>						
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label style="font-size:16px;"><b></b></label>
										<div class="modal-footer justify-content-center">
											<a href="staff.php" class="btn btn-primary">Back</a>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>

			</div>
			<?php include ('../includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<?php include ('../includes/scripts.php') ?>
</body>

</html>