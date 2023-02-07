<?php 
    
    session_start();

    if(isset($_SESSION['unlock_key'])){
        include("../../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
        $sql_today = "SELECT * FROM owner WHERE dateregistered_owner LIKE CONCAT(CURRENT_DATE(),'%') ";
        $query_today = mysqli_query($dbconn_ipadManagement,$sql_today);

        $sql_deptDistinct = "SELECT DISTINCT(name_dept),ID_dept FROM department";
        $query_deptDistinct = mysqli_query($dbconn_ipadManagement,$sql_deptDistinct);
        
        if(isset($_POST['serialNo_ipad'])){
            $sql_ipadInfo = "SELECT ipad.*,Accesories_ipad.* FROM ipad
            INNER JOIN Accesories_ipad ON Accesories_ipad.ID_ipad = ipad.ID_ipad
            WHERE ipad.serialNo_ipad = '".$_POST['serialNo_ipad']."' ";
            $query_ipadInfo = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo);
            $data_ipadInfo = mysqli_fetch_assoc($query_ipadInfo);
            $count_ipadInfo = mysqli_num_rows($query_ipadInfo);
            
            $sql_ipadInfo3 = "SELECT ipad.*,owner.*,rental_return.*,department.*,users.*,rental.*,Accesories_ipad.* FROM rental_return 
            INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
            INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
            INNER JOIN department ON department.ID_dept = owner.ID_dept
            INNER JOIN rental ON rental_return.ID_rental = rental.ID_rental
            INNER JOIN users ON owner.ID_users = users.ID_users
            INNER JOIN Accesories_ipad ON Accesories_ipad.ID_ipad = ipad.ID_ipad
            WHERE ipad.rfidno_ipad = '".$_POST['serialNo_ipad']."' ";
            $query_ipadInfo3 = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo3);
            $count_ipadInfo3 = mysqli_num_rows($query_ipadInfo3);
            
            if($count_ipadInfo == 0){
                $sql_ipadInfo = "SELECT ipad.*,Accesories_ipad.* FROM ipad
                INNER JOIN Accesories_ipad ON Accesories_ipad.ID_ipad = ipad.ID_ipad
                WHERE ipad.rfidno_ipad = '".$_POST['serialNo_ipad']."' ";
                $query_ipadInfo = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo);
                $data_ipadInfo = mysqli_fetch_assoc($query_ipadInfo);
                $count_ipadInfoR = mysqli_num_rows($query_ipadInfo);

                $sql_ipadInfo3 = "SELECT ipad.*,owner.*,rental_return.*,department.*,users.*,Accesories_ipad.*,rental.* FROM rental_return 
                INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
                INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
                INNER JOIN department ON department.ID_dept = owner.ID_dept
                INNER JOIN users ON owner.ID_users = users.ID_users
                INNER JOIN rental ON rental_return.ID_rental = rental.ID_rental
                INNER JOIN Accesories_ipad ON Accesories_ipad.ID_ipad = ipad.ID_ipad
                WHERE ipad.rfidno_ipad = '".$_POST['serialNo_ipad']."' ";
                $query_ipadInfo3 = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo3);
                $count_ipadInfo3 = mysqli_num_rows($query_ipadInfo3);
                
                
            }

            
            $i = 0;
        }
        
        $dateregistereds = date('d F Y', strtotime($data_ipadInfo['dateregistered_ipad']));
        
    }
    else{
        header("Location: ../../login.php");
    }

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>iPad Tracking - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../../system/images/logo.png">
    <link href="../../system/css/style.css" rel="stylesheet">
    <link href="../../system/css/themify-icons.css" rel="stylesheet">
    <!-- Datatable -->
    <link href="../../system/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

</head>

<body id="top">
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="../" class="brand-logo">
                <img class="logo-abbr" src="../../system/images/logo-text.png" alt="">
                <img class="logo-compact" src="../../system/images/logo-text.png" alt="">
                <img class="brand-title" src="../../system/images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        
        <div class="header ">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left"></div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-user"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul>
                                    <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="../../profile.php" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="../../inbox.php" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="../../logout.php" class="dropdown-item">
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
                    <li><a href="../"><i class="icon ti-layout-grid2"></i><span class="nav-text">Dashboard</span></a></li> 
                    <li class="nav-label">Form</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="true"><i class="icon ti-write"></i><span class="nav-text">Registration</span></a>
                        <ul aria-expanded="true">
                            <li><a href="./newIpad.php">New Ipad</a></li>
                            <li><a href="./newOwner.php">New User</a></li>
                            <li><a href="./newDept.php">New Department</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Data</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-archive"></i><span class="nav-text">Record</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./../data/iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                            <li><a href="./../data/owner/listOwner.php?status=AllOwner" aria-expanded="false">User</a></li>
                            <li><a href="../data/dept/listDept.php" aria-expanded="false">Department</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-label">Search</li>
                    <li><a href="./../search/ipadtracking.php" aria-expanded="false"><i class="icon ti-search"></i><span class="nav-text">iPad Tracking</span></a></li> 

                    <li class="nav-label">Personal</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-lock"></i><span class="nav-text">Administration</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./../admin/adduser.php">Add Staff</a></li>
                            <li><a href="./../admin/listuser.php">List Staff</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0 boxShadow">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, <?php echo ucwords($dataUsers['name_users']) ?></h4>
                            <p class="mb-0">Company Secretary Department </p>
                            <p class="mb-0" style="margin-top:-4px;"><?php echo $dataUsers['email_users'] ?></p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Registration</a></li>
                            <li class="breadcrumb-item"><a href="./newOwner.php">New User</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row justify-content-md-center countActive">
                    <div class="col-lg-2 col-sm-6">
                      <a href="../data/owner/listOwner.php?status=AllOwner" class="card boxShadow">
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
                      <a href="../data/iPad/listiPad.php?status=AlliPad" class="card boxShadow">
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
                      <a href="../admin/listuser.php" class="card boxShadow">
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
                      <a href="../data/dept/listDept.php" class="card boxShadow">
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
                    <div class="col-lg-12">
                        <div class='alert alert-success solid ' id="successAlert" style="display:none"><strong>Success!</strong> New Owner User Registration is Sucessfully!</div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card boxShadow">
                            <div class="card-header">
                                <h4 class="card-title">iPad Tracking</h4> 
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" method="POST">
                                        <div class="row">
                                            <div class="col-xl-12" id="formOwner">
                                                <div class="form-group row">
                                                    <label class="col-lg-12 col-form-label" for="val-ownerName">Serial No. / RFID No. 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" name="serialNo_ipad" placeholder="Enter the Serial No. / RFID No..">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-sm-6 btn-submit"><center>
                                                                                    <!-- Go to Function (E) -->
                                                    <button type="submit" style="width:15%" class="btn btn-secondary" ><i class="ti ti-search"></i>&nbsp;&nbsp;&nbsp;Find&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></center>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(isset($_POST['serialNo_ipad']) && $_POST['serialNo_ipad'] != "" ){ ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <?php if($count_ipadInfoR != 0 || $count_ipadInfoR == "" && $count_ipadInfo != 0){ ?>
                            <div class="card-header">
                                <h5 class="card-title"><?php echo strtoupper($data_ipadInfo['serialNo_ipad']) ?> (1020000700<?php echo $data_ipadInfo['rfidno_ipad'] ?>)</h5>
                            </div>
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home1">iPad Information</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#profile1">Owner Information</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="home1" role="tabpanel">
                                            <div class="pt-4">
                                                <div class="col-lg-12">
                                                    <div class="card-body">
                                                        <div class="profile-tab">
                                                            <div class="custom-tab-1">
                                                                <div class="tab-content">
                                                                    <div id="about-me" class="tab-pane fade active show">
                                                                        <div class="profile-personal-info">
                                                                            <h4 class="text-primary mb-4" style="margin-top:20px;">iPad Information</h4>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Asset Type <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black"><span><?php echo ucwords($data_ipadInfo['assetType_ipad']) ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">RFID No. <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black"><span>1020000700<?php echo $data_ipadInfo['rfidno_ipad'] ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Serial No. <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black"><span><?php echo strtoupper($data_ipadInfo['serialNo_ipad']) ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Remarks <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black"><span><?php if($data_ipadInfo['remarks_ipad'] == ""){echo'None';}else{echo $data_ipadInfo['remarks_ipad'];} ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Status <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black">
                                                                                    <span>
                                                                                        <?php 
                                                                                            if($data_ipadInfo['status_ipad'] == '0'){ 
                                                                                                echo 'New iPad';
                                                                                            }
                                                                                            else if($data_ipadInfo['status_ipad'] == '1'){
                                                                                                echo'In Use iPad';
                                                                                            }
                                                                                             else{
                                                                                                echo'Returned iPad';
                                                                                             }
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Condition <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black">
                                                                                    <span>
                                                                                        <?php 
                                                                                            if($data_ipadInfo['condition_ipad'] == '0'){ 
                                                                                                echo 'New iPad';
                                                                                            }
                                                                                            else if($data_ipadInfo['condition_ipad'] == '1'){
                                                                                                echo'Used iPad';
                                                                                            }
                                                                                             else{
                                                                                                echo'Returned iPad';
                                                                                             }
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Register Date <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black"><span><?php echo $dateregistereds ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Box <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black">
                                                                                    <span>
                                                                                        <?php 
                                                                                            if($data_ipadInfo['box_ipad'] == '0'){ 
                                                                                                echo 'Not Include';
                                                                                            }
                                                                                            else{
                                                                                                echo'Include';
                                                                                            }
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Adapter <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black">
                                                                                    <span>
                                                                                        <?php 
                                                                                            if($data_ipadInfo['adapter_ipad'] == '0'){ 
                                                                                                echo 'Not Include';
                                                                                            }
                                                                                            else{
                                                                                                echo'Include';
                                                                                            }
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Wire <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black">
                                                                                    <span>
                                                                                        <?php 
                                                                                            if($data_ipadInfo['cable_ipad'] == '0'){ 
                                                                                                echo 'Not Include';
                                                                                            }
                                                                                            else{
                                                                                                echo'Include';
                                                                                            }
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mb-4">
                                                                                <div class="col-3">
                                                                                    <h5 class="f-w-500">Other Acc. <span class="pull-right">:</span>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-9 font-color-black">
                                                                                    <span>
                                                                                        <?php 
                                                                                            if($data_ipadInfo['accesories_ipad'] == '0'){ 
                                                                                                echo 'None';
                                                                                            }
                                                                                            else{
                                                                                                echo $data_ipadInfo['name_accesories'] ;
                                                                                            }
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile1">
                                            <div class="pt-4">
                                                <div class="col-lg-12">
                                                        <div class="card-body">
                                                            <?php if($count_ipadInfo3 > 0){
                                                                    while($data = mysqli_fetch_array($query_ipadInfo3)){ 
                                                                        $dateregistered = date('d F Y', strtotime($data['dateassigned']));
                                                                        $i++;
                                                            ?>
                                                            <div id="accordion-six" class="accordion accordion-with-icon">
                                                                <div class="accordion__item">
                                                                    <div class="accordion__header collapsed" data-toggle="collapse" data-target="#accordion<?php echo $i ?>">
                                                                        <span class="accordion__header--icon"></span>
                                                                        <span class="accordion__header--text"><?php echo ucwords($data['name_owner']) ?> <?php if($data['status_ipadOwner'] == '2'){ ?><span class="badge badge-danger">Returned</span><?php  }if($data['status_ipadOwner'] == '1'){?> <span class="badge badge-success">In Use</span> <?php } ?></span>
                                                                        <span class="accordion__header--indicator indicator_bordered"></span>
                                                                    </div>
                                                                    <div id="accordion<?php echo $i ?>" class="collapse accordion__body" data-parent="#accordion-six">
                                                                        <div class="accordion__body--text">
                                                                            <div class="col-lg-12">
                                                                                <div class="card-body">
                                                                                    <div class="profile-tab">
                                                                                        <div class="custom-tab-1">
                                                                                            <div class="tab-content">
                                                                                                <div id="about-me" class="tab-pane fade active show">
                                                                                                    <div class="profile-personal-info">
                                                                                                        <h4 class="text-primary mb-4" style="margin-top:20px;">iPad Information</h4>
                                                                                                        <div class="row mb-4">
                                                                                                            <div class="col-3">
                                                                                                                <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                                                                                </h5>
                                                                                                            </div>
                                                                                                            <div class="col-9 font-color-black"><span><?php echo ucwords($data['name_owner']) ?></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row mb-4">
                                                                                                            <div class="col-3">
                                                                                                                <h5 class="f-w-500">Department. <span class="pull-right">:</span>
                                                                                                                </h5>
                                                                                                            </div>
                                                                                                            <div class="col-9 font-color-black"><span><?php echo ucwords($data['name_dept']) ?></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php if($data['status_ipadOwner'] == '2'){ ?>
                                                                                <img src="../../system/images/return.png" width="22%" style="position:absolute;right:90px;top:180px;">
                                                                            <?php } ?>
                                                                            <div class="col-lg-12">
                                                                                <div class="card-body">
                                                                                    <div class="profile-tab">
                                                                                        <div class="custom-tab-1">
                                                                                            <div class="tab-content">
                                                                                                <div id="about-me" class="tab-pane fade active show">
                                                                                                    <div class="profile-personal-info">
                                                                                                        <h4 class="text-primary mb-4">Loan Information</h4>
                                                                                                        <div class="row mb-4">
                                                                                                            <div class="col-3">
                                                                                                                <h5 class="f-w-500">Staff Name <span class="pull-right">:</span>
                                                                                                                </h5>
                                                                                                            </div>
                                                                                                            <div class="col-9 font-color-black"><span><?php echo ucwords($data['name_users']) ?></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row mb-4">
                                                                                                            <div class="col-3">
                                                                                                                <h5 class="f-w-500">Date Assign <span class="pull-right">:</span>
                                                                                                                </h5>
                                                                                                            </div>
                                                                                                            <div class="col-9 font-color-black"><span><?php echo $dateregistered ?></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" style="margin-top:15px;">
                                                                                <div class="col-lg-6">
                                                                                    <div style="border: 1px solid rgba(0, 0, 0, 0.09);" >
                                                                                        <div class="card-body">
                                                                                            <div class="profile-tab">
                                                                                                <div class="custom-tab-1">
                                                                                                    <div class="tab-content">
                                                                                                        <div id="about-me" class="tab-pane fade active show">
                                                                                                            <div class="profile-personal-info">
                                                                                                                <div class="row mb-4 justify-content-md-center">
                                                                                                                <div class='col-lg-12 mb-12'>
                                                                                                                    <center>
                                                                                                                        <div class='alert alert-dark'><center><b>Fixed asset receipt</b></center></div>
                                                                                                                        <button type='button' class='btn btn-rounded btn-warning btn-download addDateDownloadSearch' id='<?php echo $data['ID_rentalReturn'] ?>' >&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></button>&nbsp;
                                                                                                                        <button type='button' class='btn btn-rounded btn-info btn-download addDateViewSearch' id='<?php echo $data['ID_rentalReturn'] ?>' >&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></button><br><br><br>
                                                                                                                        <div class='alert alert-dark'><b>Upload Fixed asset receipt</b></div>
                                                                                                                        <?php if($data['fixedassetform'] == ""){?>
                                                                                                                        <div id='load'>
                                                                                                                            <button type='button' id='myButton' onclick='myFunction()' class='btn btn-rounded btn-success btn-download'>&nbsp;&nbsp;&nbsp;&nbsp;Upload&nbsp;<i class='ti ti-upload color-success'></i></button>
                                                                                                                            <form id='uploadFile' method='POST' enctype='multipart/form-data'>
                                                                                                                                <div id='myDIV' style='display:none'>
                                                                                                                                    <div class='input-group'>
                                                                                                                                        <div class='custom-file'>
                                                                                                                                            <input type='file' id='pdfFile' name='pdfFile' class='custom-file-input'>
                                                                                                                                            <input type='hidden' id='status' name='status' value='submitFile'>
                                                                                                                                            <input type='hidden' id='fileID' name='fileID' value='<?php echo $data['ID_rentalReturn'] ?>'>
                                                                                                                                            <label class='custom-file-label' >Choose file</label>
                                                                                                                                        </div>
                                                                                                                                        <div class='input-group-append'>
                                                                                                                                            <input class='btn btn-primary' type='submit' name='submit' value='Submit' >
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </form>
                                                                                                                            <div id='pdfFile-error' class='invalid-feedback animated fadeInUp' style='display: none;'>Please select the file</div>
                                                                                                                        </div>
                                                                                                                        <?php }else{  ?>
                                                                                                                                <a href='../../../system<?php echo $data['fixedassetform'] ?>' class='btn btn-rounded btn-warning btn-download' download>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></a>&nbsp;
                                                                                                                                <a href='../../../system<?php echo $data['fixedassetform'] ?>' type='button' class='btn btn-rounded btn-info btn-download' target='blank'>&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></a>&nbsp;
                                                                                                                                <button type='button' class='btn btn-rounded btn-danger btn-download' >&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;<i class='ti ti-trash color-warning' ></i></button>
                                                                                                                        <?php  }  ?>
                                                                                                                    </center>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <div style="border: 1px solid rgba(0, 0, 0, 0.09);" >
                                                                                        <div class="card-body">
                                                                                            <div class="profile-tab">
                                                                                                <div class="custom-tab-1">
                                                                                                    <div class="tab-content">
                                                                                                        <div id="about-me" class="tab-pane fade active show">
                                                                                                            <div class="profile-personal-info">
                                                                                                                <div class="row mb-4 justify-content-md-center">
                                                                                                                <div class='col-lg-12 mb-12'>
                                                                                                                    <center>
                                                                                                                        <div class='alert alert-dark'><center><b>Return Fixed asset receipt</b></center></div>
                                                                                                                        <?php if($data['ID_return'] != Null){?>
                                                                                                                        <button type='button' class='btn btn-rounded btn-warning btn-download' data-toggle='modal' data-dismiss='modal' data-target='.bd-example-modal-sm'>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></button>&nbsp;
                                                                                                                        <button type='button' class='btn btn-rounded btn-info btn-download' data-toggle='modal' data-dismiss='modal' data-target='.bd-example-modal-sm-2'>&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></button><br><br><br>
                                                                                                                        <div class='alert alert-dark'><b>Upload Return Fixed asset receipt</b></div>
                                                                                                                        <?php if($data['returnfixedassetform'] == ""){?>
                                                                                                                        <div id='load'>
                                                                                                                            <button type='button' id='myButton' onclick='myFunction()' class='btn btn-rounded btn-success btn-download'>&nbsp;&nbsp;&nbsp;&nbsp;Upload&nbsp;<i class='ti ti-upload color-success'></i></button>
                                                                                                                            <form id='uploadFileReturn' method='POST' enctype='multipart/form-data'>
                                                                                                                                <div id='myDIV' style='display:none'>
                                                                                                                                    <div class='input-group'>
                                                                                                                                        <div class='custom-file'>
                                                                                                                                            <input type='file' id='pdfFile' name='pdfFile' class='custom-file-input'>
                                                                                                                                            <input type='hidden' id='status' name='status' value='submitFileReturn'>
                                                                                                                                            <input type='hidden' id='fileID' name='fileID' value='<?php echo $data['ID_rentalReturn'] ?>'>
                                                                                                                                            <label class='custom-file-label' >Choose file</label>
                                                                                                                                        </div>
                                                                                                                                        <div class='input-group-append'>
                                                                                                                                            <input class='btn btn-primary' type='submit' name='submit' value='Submit' >
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </form>
                                                                                                                            <div id='pdfFile-error' class='invalid-feedback animated fadeInUp' style='display: none;'>Please select the file</div>
                                                                                                                        </div>
                                                                                                                        <?php }else{  ?>
                                                                                                                                <a href='../../../system<?php echo $data['returnfixedassetform'] ?>' class='btn btn-rounded btn-warning btn-download' download>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></a>&nbsp;
                                                                                                                                <a href='../../../system<?php echo $data['returnfixedassetform'] ?>' type='button' class='btn btn-rounded btn-info btn-download' target='blank'>&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></a>&nbsp;
                                                                                                                                <button type='button' class='btn btn-rounded btn-danger btn-download' >&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;<i class='ti ti-trash color-warning' ></i></button>
                                                                                                                        <?php  } }else{ ?>
                                                                                                                          <form action="../form/returniPad.php" method="POST">
                                                                                                                            <input type="hidden" name="ipadID" value="<?php echo $data['ID_ipad'] ?>">
                                                                                                                            <button type="submit" class="btn btn-dark">Return iPad &nbsp;<i class="ti ti-back-left"></i></button>
                                                                                                                          </form>
                                                                                                                        <?php }?>
                                                                                                                        
                                                                                                                    </center>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php }}else{ ?>
                                                                <center><img src="../../system/images/no_pic.png" width="40%" ></center>
                                                            <?php } ?>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }else{ ?>
                                <center><img src="../../system/images/no_pic.png" width="35%" style="padding-top:30px;padding-bottom:30px;" ></center>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        
        <div class="modal fade bd-example-modal-sm" id="basicModalDateView" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <form action="../data/ipad/acknowledgementReceipt.php" method="POST" class="modal-content">
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
                <form action="../data/ipad/acknowledgementReceipt.php" method="POST" class="modal-content">
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
                <p>© Hak Cipta 2022 <a href="https://www.pnb.com.my/" target="_blank">Permodalan Nasional Berhad</a>. Hak Cipta Terpelihara.</p>
            </div>
        </div>
    </div>
    
    <script src="../../system/vendor/global/global.min.js"></script>
    <script src="../../system/js/quixnav-init.js"></script>
    <script src="../../system/js/custom.min.js"></script>
    <script src="../../system/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../system/js/plugins-init/jquery.validate-init.js"></script>
    <script src="../../system/jquery.js"></script>
    <script src="../../system/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../system/js/plugins-init/datatables.init.js"></script>
    
</body>
</html>