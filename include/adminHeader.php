<div class="navbar navbar-fixed-top bs-docs-nav" role="banner">

    <div class="conjtainer">
      <!-- Menu button for smallar screens -->
      <div class="navbar-header">
		  <button class="navbar-toggle btn-navbar" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
			<span>Menu</span>
		  </button>
		  <!-- Site name for smallar screens -->
		  <a href="/staff" class="navbar-brand hidden-lg">FootWearManager</a>
		</div> 



      <!-- Navigation starts -->
      <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">

        <ul class="nav navbar-nav">

          <!-- Upload to server link. Class "dropdown-big" creates big dropdown -->
          <li class="dropdown dropdown-big">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-success"><i class="fa fa-cloud-upload"></i></span> Upload to Cloud</a>
            <!-- Dropdown -->
            <ul class="dropdown-menu">
              <li>
                <!-- Progress bar -->
                <p>Photo Upload in Progress</p>
                <!-- Bootstrap progress bar -->
                <div class="progress progress-striped active">
					<div class="progress-bar progress-bar-info"  role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
						<span class="sr-only">40% Complete</span>
					</div>
			    </div>

                <hr />

                <!-- Progress bar -->
                <p>Video Upload in Progress</p>
                <!-- Bootstrap progress bar -->
                <div class="progress progress-striped active">
					<div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
						<span class="sr-only">80% Complete</span>
					</div>
			    </div>

                <hr />

                <!-- Dropdown menu footer -->
                <div class="drop-foot">
                  <a href="#">View All</a>
                </div>

              </li>
            </ul>
          </li>

          <!-- Sync to server link -->
          <li class="dropdown dropdown-big">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger"><i class="fa fa-refresh"></i></span> Sync with Server</a>
            <!-- Dropdown -->
            <ul class="dropdown-menu">
              <li>
                <!-- Using "icon-spin" class to rotate icon. -->
                <p><span class="label label-info"><i class="fa fa-cloud"></i></span> Syncing Members Lists to Server</p>
                <hr />
                <p><span class="label label-warning"><i class="fa fa-cloud"></i></span> Syncing Bookmarks Lists to Cloud</p>

                <hr />

                <!-- Dropdown menu footer -->
                <div class="drop-foot">
                  <a href="#">View All</a>
                </div>

              </li>
            </ul>
          </li>

        </ul>

        <!-- Search form -->
        <form class="navbar-form navbar-left" role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
        <!-- Links -->
        <ul class="nav navbar-nav pull-right">
          <li class="dropdown pull-right">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <i class="fa fa-user"></i> <?php echo $user->getEmail() . ' (' . $user->getRoleName() . ')'; ?> <b class="caret"></b>
            </a>
			
            <!-- Dropdown menu -->
            <ul class="dropdown-menu">
              <li><a href="settings.php"><i class="fa fa-cogs"></i> Settings</a></li>
              <li><a href="/staff/logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </li>

        </ul>
      </nav>

    </div>
  </div>


<!-- Header starts -->
  <header>
    <div class="container">
      <div class="row">

        <!-- Logo section -->
        <div class="col-md-4">
          <!-- Logo. -->
          <div class="logo">
            <h1><a href="#">FootWear<span class="bold">Manager</span></a></h1>
            <p class="meta">Logged in as <?php echo $user->getRoleName(); ?>.</p>
          </div>
          <!-- Logo ends -->
        </div>

        <!-- Data section -->

		<?php
		
		$orders = $mysqli->query("SELECT * FROM `Order` WHERE 1")->fetch_row()[0];
		$customers = $mysqli->query("SELECT COUNT(*) FROM User, Role WHERE role_name = 'C' AND User.role_id = Role.id;")->fetch_row()[0];
		$staff = $mysqli->query("SELECT COUNT(*) FROM User, Role WHERE role_name = 'C' AND User.role_id != Role.id;")->fetch_row()[0];
		
		?>
		
        <div class="col-md-4" style="float:right; text-align:right;">
          <div class="header-data">

            <!-- Traffic data -->
            <div class="hdata">
              <div class="mcol-left">
                <!-- Icon with red background -->
                <i class="fa fa-signal bred"></i>
              </div>
              <div class="mcol-right">
                <!-- Number of visitors -->
                <p><a style="text-align: left;"><?php echo $orders; ?></a> <em>Orders</em></p>
              </div>
              <div class="clearfix"></div>
            </div>

            <!-- Members data -->
            <div class="hdata">
              <div class="mcol-left">
                <!-- Icon with blue background -->
                <i class="fa fa-user bblue"></i>
              </div>
              <div class="mcol-right">
                <!-- Number of users -->
                <p><a style="text-align: left;"><?php echo $customers; ?></a> <em>Customers</em></p>
              </div>
              <div class="clearfix"></div>
            </div>

            <!-- revenue data -->
            <div class="hdata">
              <div class="mcol-left">
                <!-- Icon with green background -->
                <i class="fa fa-money bgreen"></i>
              </div>
              <div class="mcol-right">
                <!-- Number of Staff -->
                <p><a style="text-align: left;"><?php echo $staff; ?></a><em style="text-align: left;">Staff</em></p>
              </div>
              <div class="clearfix"></div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </header>

<!-- Header ends -->

<div class="content">
  	<!-- Sidebar -->
	<div class="sidebar">
		<div class="sidebar-dropdown">
			<a href="#">Navigation</a>
		</div>
		
		<!--- Sidebar navigation -->
		<!-- If the main navigation has sub navigation, then add the class "has_sub" to "li" of main navigation. -->
		<ul id="nav">
		<li><a href="/staff"><i class="fa fa-home"></i>Stock Levels</a></li>
		<li><a href="metaData.php"><i class="fa fa-home"></i>Demographics</a></li>
		<li><a href="products.php"><i class="fa fa-bar-chart-o"></i>Manage Products</a></li>
		<li><a href="orders.php"><i class="fa fa-bar-chart-o"></i>Customer Orders</a></li>
		<!-- class="open" -->
		<?php
		
		if($_SESSION['role'] >= 3)
		{
			?>
			<li><a href="suppliers.php"><i class="fa fa-bar-chart-o"></i>Suppliers</a></li>
			<li><a href="customers.php"><i class="fa fa-bar-chart-o"></i>Manage Customers</a></li>
			<?php
		}
		
		if($_SESSION['role'] >= 4)
		{
			?>
			<li><a href="addstaff.php"><i class="fa fa-bar-chart-o"></i>Add Staff</a></li>
			<li><a href="managestaff.php"><i class="fa fa-bar-chart-o"></i>Manage Staff</a></li>
			<?php
		}
		
		?>
		</ul>
	</div>
	
<!-- We will close these divs in the following document -->