<?php 
    
    session_start();

    if(isset($_SESSION['unlock_key'])){
        include("../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
    }
    else{
        header("Location: ../");
    }

    //owner yang available
    $sql_availableOwner = "SELECT owner.*,department.* FROM owner INNER JOIN department 
    ON owner.ID_dept = department.ID_dept WHERE owner.status_owner = '0'";
    $query_availableOwner = mysqli_query($dbconn_ipadManagement,$sql_availableOwner);
    $count_availableOwner = mysqli_num_rows($query_availableOwner);

    //owner yang sedang pinjam
    $sql_InUseIpad = "SELECT ipad.*,owner.*,rental_return.* FROM rental_return 
    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
    WHERE ipad.status_ipad = '1' AND rental_return.status_ipadOwner = '1' ";
    $query_InUseIpad = mysqli_query($dbconn_ipadManagement,$sql_InUseIpad);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PNB - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../system/images/logo.png">
    <link href="../system/css/style.css" rel="stylesheet">
    <link href="../system/css/themify-icons.css" rel="stylesheet">
      
        <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css"> 
      
   
  </head>
  <body>
    <div id="preloader">
      <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
      </div>
    </div>
    <div id="main-wrapper">
      <div class="nav-header">
        <a href="./" class="brand-logo">
          <img class="logo-abbr" src="../system/images/logo-text.png" alt="">
          <img class="logo-compact" src="../system/images/logo-text.png" alt="">
          <img class="brand-title" src="../system/images/logo-text.png" alt="">
        </a>
        <div class="nav-control">
          <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
          </div>
        </div>
      </div>
      <div class="header ">
        <div class="header-content">
          <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
              <div class="header-left">
                    <a href="../dashboard.php" class="fa fa-home" style="font-size:30px;padding-top:2px;"></a>
                </div>
              <ul class="navbar-nav header-right">
                <li class="nav-item dropdown notification_dropdown">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                    <i class="mdi mdi-bell"></i>
                    <div class="pulse-css"></div>
                  </a>
                  
                  <div class="dropdown-menu dropdown-menu-right">
                    <?php if($count_noti > 0){ 
                       while($data_noti = mysqli_fetch_array($query_noti)){
                            $name_noti=explode(' ', $data_noti['name_noti']);
                            $name_noti=$name_noti[0];
    
                            $dateregistered = date('h:i A', strtotime($data_noti['timeStamp_noti']));

                      ?>
                    <ul class="list-unstyled">
                      <li class="media dropdown-item">
                        <span class="success">
                          <i class="ti-bell"></i> 
                        </span>
                        <div class="media-body">
                          <a href="#">
                            <p>
                              <strong><?php echo $name_noti ?></strong> <?php echo $data_noti['details_noti']; ?>
                            </p>
                          </a>
                        </div>
                        <span class="notify-time" style="text-align:right"><?php echo $dateregistered; ?></span>
                      </li>
                    </ul>
                      
                <?php }}else{ ?><center>
                   <img style="padding:30px" src="../system/images/no_pic.png" width="100%"> </center>
                <?php   } ?>
                    <a class="all-notification" href="../notification.php">See all notifications (<?php echo $count_noti ?>) <i class="ti-arrow-right"></i>
                    </a>
                    
                  </div>
                </li>
                <li class="nav-item dropdown header-profile">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                    <i class="mdi mdi-account"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="../profile.php" class="dropdown-item">
                      <i class="icon-user"></i>
                      <span class="ml-2">Profile </span>
                    </a>
                    <a href="../notification.php" class="dropdown-item">
                      <i class="icon-bell"></i>
                      <span class="ml-2">Notification </span>
                    </a>
                    <a onclick="doSomething()" href="#" class="dropdown-item">
                      <i class="icon-key"></i>
                      <span class="ml-2">Logout </span>
                    </a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
      <div class="quixnav">
        <div class="quixnav-scroll">
          <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
              <a href="./">
                <i class="icon ti-layout-grid2"></i>
                <span class="nav-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-label">Form</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-write"></i>
                <span class="nav-text">Registration</span>
              </a>
              <ul aria-expanded="false">
                <li>
                  <a href="./form/newIpad.php">New Ipad</a>
                </li>
                <li>
                  <a href="./form/newOwner.php">New User</a>
                </li>
                <li>
                  <a href="./form/newDept.php">New Department</a>
                </li>
              </ul>
            </li>
            <li class="nav-label">Data</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-archive"></i>
                <span class="nav-text">Record</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="./data/iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                <li>
                  <a href="./data/owner/listOwner.php?status=AllOwner" aria-expanded="false">User</a>
                </li>
                <li>
                  <a href="./data/dept/listDept.php" aria-expanded="false">Department</a>
                </li>
              </ul>
            </li>
            <li class="nav-label">Search</li>
            <li>
              <a href="./search/ipadtracking.php" aria-expanded="false">
                <i class="icon ti-search"></i>
                <span class="nav-text">iPad Tracking</span>
              </a>
            </li>
            <?php if($dataUsers['status_users'] != '0'){ ?>
            <li class="nav-label">Personal</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-lock"></i>
                <span class="nav-text">Administration</span>
              </a>
              <ul aria-expanded="false">
                <li>
                  <a href="./admin/adduser.php">Add Staff</a>
                </li>
                <li>
                  <a href="./admin/listuser.php">List Staff</a>
                </li>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="content-body">
        <div class="container-fluid">
          <div class="row page-titles mx-0 boxShadow">
            <div class="col-sm-6 p-md-0">
              <div class="welcome-text">
                <h4><?php echo ucwords($dataUsers['name_users']) ?></h4>
                <p class="mb-0">Company Secretary Department </p>
                <p class="mb-0" style="margin-top:-4px;"><?php echo $dataUsers['email_users'] ?></p>
              </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="./">Dashboard</a>
                </li>
              </ol>
            </div>
          </div>
          <div class="row justify-content-md-center countActive">
            <div class="col-lg-2 col-sm-6">
              <a href="data/owner/listOwner.php?status=AllOwner" class="card boxShadow">
                <div class="stat-widget-one card-body bg-info">
                  <div class="stat-icon d-inline-block">
                    <i class="ti-user text-light border-light"></i>
                  </div><br>
                  <div class="stat-content d-inline-block">
                    <div class="stat-text text-light">Total User</div>
                    <div class="stat-digit text-light"> <?php echo $AllOwner ?> </div>
                        <div class="tooltips">
                            <span class="tooltiptexts" style="width:240px !important;left: -135px !important;" >
                                <table class="table-count" >
                                    <tr>
                                        <th>Total</th>
                                        <th>New</th>
                                        <th>Existing</th>
                                        <th>Former</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $AllOwner ?></td>
                                        <td><?php echo $NewOwner ?></td>
                                        <td><?php echo $ExistingOwner ?></td>
                                        <td><?php echo $OldOwner ?></td>
                                    </tr>
                                </table>
                            </span>
                            <i class="ti-help-alt"></i>
                        </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-2 col-sm-6">
              <a href="data/iPad/listiPad.php?status=AlliPad" class="card boxShadow">
                <div class="stat-widget-one card-body bg-03">
                  <div class="stat-icon d-inline-block">
                    <i class="ti-tablet text-light border-light"></i>
                  </div><br>
                  <div class="stat-content d-inline-block">
                    <div class="stat-text text-light">Total iPad</div>
                    <div class="stat-digit text-light"> <?php echo $AlliPad ?> </div>
                      <div class="tooltips">
                        <span class="tooltiptexts" style="width:270px !important;left: -165px !important;" >
                                <table class="table-count" >
                                    <tr>
                                        <th>Total</th>
                                        <th>Available</th>
                                        <th>In&nbsp;Use</th>
                                        <th>Returned</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $AlliPad ?></td>
                                        <td><?php echo $NewiPad ?></td>
                                        <td><?php echo $InUseiPad ?></td>
                                        <td><?php echo $ReturnediPad ?></td>
                                    </tr>
                                </table>
                            </span>
                        <i class="ti-help-alt"></i>
                      </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-2 col-sm-6">
              <a href="./admin/listuser.php" class="card boxShadow">
                <div class="stat-widget-one card-body bg-05">
                  <div class="stat-icon d-inline-block">
                    <i class="ti-briefcase text-light border-light"></i>
                  </div><br>
                  <div class="stat-content d-inline-block">
                    <div class="stat-text text-light">Total Staff</div>
                    <div class="stat-digit text-light"> <?php echo $AllUsers ?> </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-2 col-sm-6">
              <a href="./data/dept/listDept.php" class="card boxShadow">
                <div class="stat-widget-one card-body bg-06">
                  <div class="stat-icon d-inline-block">
                    <i class="ti-microsoft text-light border-light"></i>
                  </div><br>
                  <div class="stat-content d-inline-block">
                    <div class="stat-text text-light">Total Dept</div>
                    <div class="stat-digit text-light"> <?php echo $AllDept ?> </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          
          <div class="row">
            <div class="col-xl-4 col-lg-6 col-xxl-6 col-md-12">
              <div class="card boxShadow available">
                <div class="card-header">
                  <h4 class="card-title">Available iPad (<?php echo ($ReturnediPad + $NewiPad) ?>)
                    <div class="tooltips">
                        <span class="tooltiptexts"><b>Available iPad</b><br>List of new & returned iPad</span>
                        <i class="ti-help-alt"></i>
                    </div>
                  </h4>
                  <a href="./form/newIpad.php" class="btn btn-primary">&nbsp;&nbsp;Add new iPad &nbsp;&nbsp;<i class="ti ti-plus"></i>&nbsp;&nbsp;</a>
                </div>
                <div class="card-body" style="height: 360px;">
                  <div class="recent-comment m-t-15"> 
					<?php 
						if($NewiPad > 0 || $ReturnediPad > 0){
                            $sql_ipadAvai = "SELECT * FROM ipad WHERE status_ipad != '1' ";
                            $query_ipadAvai = mysqli_query($dbconn_ipadManagement,$sql_ipadAvai);
							while(($availableIpad = mysqli_fetch_array($query_ipadAvai))){
					?> 
					<div class="media">
                      <div class="media-left">
                        <i class="ti-tablet " style="font-size:30px;position:relative;left:10px;top:3px;color:#252525;"></i>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"> <?php echo ucwords(mb_strimwidth($availableIpad['assetType_ipad'], 0, 34, "...")); ?> </h4>
                        <p> 1020000700<?php echo $availableIpad['rfidno_ipad'] ?> <?php if($availableIpad['condition_ipad'] == '0'){ ?><span class="badge badge-new">New</span><?php  }else{?> <span class="badge badge-warning">Used</span> <?php }?></p>
                        <div class="comment-date">
                            <button type="button" class="btn btn-info AssignUser" id="<?php echo $availableIpad['ID_ipad'] ?>">Assign User &nbsp;<i class="ti ti-user"></i></button>
                        </div>
                      </div>
                    </div> <?php } ?> <center>
                    </center> <?php }else{ ?> <center><br>
                      <img width="70%" src="../system/images/no_pic.png">
                      <br>
                      <br>
                      <br>
                    </center> <?php }?> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-xxl-6 col-md-12">
              <div class="card boxShadow available">
                <div class="card-header">
                  <h4 class="card-title">Available Users (<?php echo ($NewOwner + $OldOwner) ?>)
                    <div class="tooltips">
                        <span class="tooltiptexts"><b>Available Users</b><br>List of new & former Users</span>
                        <i class="ti-help-alt"></i>
                    </div>
                  </h4>
                    <a href="./form/newOwner.php" class="btn btn-primary">&nbsp;&nbsp;Add new User &nbsp;&nbsp;<i class="ti ti-plus"></i>&nbsp;&nbsp;</a>
                </div>
                <div class="card-body" style="height: 360px;">
                  <div class="recent-comment m-t-15"> 
					<?php 
						if($NewOwner > 0 || $OldOwner > 0){
                            $sql_ownerAvai = "SELECT owner.*,department.* FROM owner
                            INNER JOIN department ON owner.ID_dept = department.ID_dept
                            WHERE owner.status_owner != '1' ";
                            $query_ownerAvai = mysqli_query($dbconn_ipadManagement,$sql_ownerAvai);
							while(($availableOwner = mysqli_fetch_array($query_ownerAvai))){
					?> 
					<div class="media">
                      <div class="media-left">
                        <i class="ti-user " style="font-size:30px;position:relative;left:10px;top:3px;color:#252525;"></i>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"> <?php echo ucwords(mb_strimwidth($availableOwner['name_owner'], 0, 29, "...")); ?> </h4>
                        <p> <?php echo ucwords($availableOwner['name_dept']) ?> <?php if($availableOwner['status_owner'] == '0'){ ?><span class="badge badge-new">New</span><?php  }else{?> <span class="badge badge-warning">Former</span> <?php }?></p>
                        <div class="comment-date">
                            <button type="submit" class="btn btn-info AssignIpad" id="<?php echo $availableOwner['ID_owner'] ?>">Assign iPad &nbsp;<i class="ti ti-tablet"></i></button>
                        </div>
                      </div>
                    </div> <?php } ?> <center>
                    </center> <?php }else{ ?> <center><br>
                      <img width="70%" src="../system/images/no_pic.png">
                      <br>
                      <br>
                      <br>
                    </center> <?php }?> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col-xl-4 col-lg-6 col-xxl-6 col-md-12">
              <div class="card boxShadow available">
                <div class="card-header">
                  <h4 class="card-title">In Use iPad (<?php echo ($InUseiPad) ?>)
                    <div class="tooltips">
                        <span class="tooltiptexts"><b>Return iPad</b><br>List of In Use iPad & Existing User</span>
                        <i class="ti-help-alt"></i>
                    </div>
                  </h4>
                </div>
                <div class="card-body" style="height: 360px;z-index:1;">
                  <div class="recent-comment m-t-15"> 
					<?php 
						if($InUseiPad > 0){
							while(($data_InUseIpad = mysqli_fetch_array($query_InUseIpad))){
					?> 
						<div class="media">
						  <div class="media-left">
							<i class="ti-tablet " style="font-size:30px;position:relative;left:10px;top:3px;color:#252525;"></i>
						  </div>
						  <div class="media-body">
							<h4 class="media-heading"> <?php echo ucwords(mb_strimwidth($data_InUseIpad['name_owner'], 0, 26, "...")); ?> </h4>
							<p> 1020000700<?php echo $data_InUseIpad['rfidno_ipad'] ?> <?php if($data_InUseIpad['status_ipad'] == '1'){ ?><span class="badge badge-inuse">In Use</span><?php  }?></p>
							<div class="comment-date availableButton">
                                <table style="border:none;">
                                    <td style="border-bottom:1px solid white !important;">
                                      <div class="tooltips">
                                          <div class="tooltiptexts">View details</div>
                                            <button type="submit" class="btn btn-success viewDetailsInUse" id="<?php echo $data_InUseIpad['ID_rentalReturn'] ?>" ><i class="ti-new-window" style="font-weight:900 !important"></i></button>
                                      </div> 
                                    </td>
                                    <td style="border-bottom:1px solid white !important;">&nbsp;&nbsp;&nbsp;</td>
                                    <td style="border-bottom:1px solid white !important;">
                                      <form action="form/returniPad.php" method="POST">
                                        <input type="hidden" name="ipadID" value="<?php echo $data_InUseIpad['ID_ipad'] ?>">
                                        <button type="submit" class="btn btn-dark">Return iPad &nbsp;<i class="ti ti-back-left"></i></button>
                                      </form>
                                    </td>
                                </table>
							</div>
						  </div>
						</div> 
					<?php } ?> 
					<center>
                    </center> 
					<?php }else{ ?> <center><br>
                      <img width="70%" src="../system/images/no_pic.png">
                      <br>
                    </center> <?php }?> </div>
                </div>
              </div>
            </div> 
            <div class="col-xl-4 col-lg-6 col-xxl-6 col-md-12">
              <div class="card boxShadow available">
                <div class="card-header">
                  <h4 class="card-title">Department/Division 
                    <div class="tooltips">
                        <span class="tooltiptexts"><b>Department</b><br>List of all department / division registered</span>
                        <i class="ti-help-alt"></i>
                    </div>
                  </h4>
                <a href="./form/newDept.php" class="btn btn-primary">&nbsp;&nbsp;Add new Dept/Div &nbsp;&nbsp;<i class="ti ti-plus"></i>&nbsp;&nbsp;</a>
                </div>
                <div class="card-body" style="height: 360px;">
                  <div class="recent-comment m-t-15"> 
					<?php 
						if($AllDept > 0){
							while(($data_Dept = mysqli_fetch_array($query_Dept))){
					?> 
						<div class="media">
						  <div class="media-left">
							<i class="ti-microsoft" style="font-size:30px;position:relative;left:10px;top:3px;color:#252525;"></i>
						  </div>
						  <div class="media-body">
							<h4 class="media-heading" style="position:relative;top:8px;"> <?php echo ucwords(mb_strimwidth($data_Dept['name_dept'], 0, 34, "...")); ?> </h4>
							<div class="comment-date availableButton">
                                <table style="border:none;">
                                    <td style="border-bottom:1px solid white !important;">&nbsp;&nbsp;&nbsp;</td>
                                    <td style="border-bottom:1px solid white !important;">
                                    </td>
                                </table>
							</div>
						  </div>
						</div> 
					<?php } ?> 
					<center>
                    </center> 
					<?php }else{ ?> <center><br>
                      <img width="70%" src="../system/images/no_pic.png">
                      <br>
                    </center> <?php }?> </div>
                </div>
              </div>
            </div> 
          </div>
          <div class="row">
           <div class="col-xl-12 col-lg-12 col-xxl-12 col-md-12">
              <div class="card boxShadow available">
                <div class="card-header">
                  <h4 class="card-title">Staff (<?php echo ($AllUsers) ?>)
                    <div class="tooltips">
                        <span class="tooltiptexts"><b>Staff</b><br>List of all staff registered</span>
                        <i class="ti-help-alt"></i>
                    </div>
                  </h4><a href="./admin/adduser.php" class="btn btn-primary">&nbsp;Add New Staff &nbsp;<i class="ti ti-plus"></i></a>
                </div>
                <div class="card-body" style="height: 360px;">
                  <div class="recent-comment m-t-15"> 
					<?php 
						if($AllUsers > 0){
							while(($data_Users = mysqli_fetch_array($query_Users))){
					?> 
						<div class="media">
						  <div class="media-left">
							<i class="ti-briefcase " style="font-size:30px;position:relative;left:10px;top:3px;color:#252525;"></i>
						  </div>
						  <div class="media-body">
							<h4 class="media-heading"> <?php echo ucwords(mb_strimwidth($data_Users['name_users'], 0, 34, "...")); ?> </h4>
							<p> <?php echo $data_Users['email_users'] ?> <?php if($data_Users['status_users'] == '0'){ ?><span class="badge badge-secondary">Normal Member</span><?php  }else if($data_Users['status_users'] == '1'){?><span class="badge badge-secondary">Administrator</span><?php }else{ ?><span class="badge badge-secondary">Developer</span><?php }?></p>
							
						  </div>
						</div> 
					<?php } ?> 
					<center>
                    </center> 
					<?php }else{ ?> <center><br>
                      <img width="70%" src="../system/images/no_pic.png">
                      <br>
                    </center> <?php }?> 
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
      </div>
        
        <!-- Modal -->
        <div class="modal bd-example-modal-lg fade" id="basicModal">
            <div class="modal-dialog modal-lg" role="document">
                <form class="modal-content" id="basicModalDetails"></form>
            </div>
        </div>
        
        <div class="modal fade bd-example-modal-sm" id="basicModalDateView" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <form action="data/ipad/acknowledgementReceipt.php" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date Assign iPad</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="basicModalDetailsView">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade bd-example-modal-sm-2" id="basicModalDateDownload" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <form action="data/ipad/acknowledgementReceipt.php" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date Assign iPad</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="basicModalDetailsDownload">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" target="blank">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        
      <div class="footer">
        <div class="copyright">
          <p>© Hak Cipta 2022 <a href="https://www.pnb.com.my/" target="_blank">Permodalan Nasional Berhad</a>. Hak Cipta Terpelihara. </p>
        </div>
      </div>
    </div>
      
    <script src="../system/vendor/global/global.min.js"></script>
    <script src="../system/js/quixnav-init.js"></script>
    <script src="../system/js/custom.min.js"></script>
    <script src="../system/jquery.js"></script>
    <script src="../system/vendor/moment/moment.min.js"></script>
      
    <script>
      function myFunction() {
          var x = document.getElementById("myDIV");
          var y = document.getElementById("myButton");
            
            x.style.display = "block";
            y.style.display = "none";
        }
    </script>
      

  </body>
</html>