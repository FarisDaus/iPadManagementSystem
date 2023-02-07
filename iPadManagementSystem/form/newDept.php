<?php 
    
    session_start();

    if(isset($_SESSION['unlock_key'])){
        include("../../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
        $sql_today = "SELECT * FROM department WHERE timestamp_dept LIKE CONCAT(CURRENT_DATE(),'%') ";
        $query_today = mysqli_query($dbconn_ipadManagement,$sql_today);

        $sql_deptDistinct = "SELECT DISTINCT(name_dept),ID_dept FROM department";
        $query_deptDistinct = mysqli_query($dbconn_ipadManagement,$sql_deptDistinct);
    }
    else{
        header("Location: ../");
    }

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>New Department - iPad Management System Company Secretary Department </title>
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
                                    <a class="all-notification" href="../../notification.php">See all notifications (<?php echo $count_noti ?>) <i class="ti-arrow-right"></i>
                                    </a>

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
                                    <a href="../../notification.php" class="dropdown-item">
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
                            <li><a href="./../data/owner/listOwner.php?status=AllOwner" aria-expanded="false">Owner</a></li>
                            <li><a href="../data/dept/listDept.php" aria-expanded="false">Depatment</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-label">Search</li>
                    <li><a href="./../search/ipadtracking.php" aria-expanded="false"><i class="icon ti-search"></i><span class="nav-text">iPad Tracking</span></a></li> 

                    <li class="nav-label">Personal</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-lock"></i><span class="nav-text">Administration</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./../admin/adduser.php">Add Staff</a></li>
                            <li><a href="./../admin/liststaff.php">List Staff</a></li>
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
                            <li class="breadcrumb-item"><a href="./newDept.php">New Department</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row justify-content-md-center countActive">
                    <div class="col-lg-2 col-sm-6">
                      <a href="../data/dept/listDept.php" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-warning">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-microsoft text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">All Dept</div>
                            <div class="stat-digit text-light"> <?php echo $AllDept ?> </div>
                                <div class="tooltips">
                                    <span class="tooltiptexts"><b>All Dept</b><br>Total number of all department include board of director (BOD)</span>
                                    <i class="ti-help-alt"></i>
                                </div>
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
                                <h4 class="card-title">New Department Registration Form</h4> 
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide">
                                        <div class="row">
                                            <div class="col-xl-12" id="formOwner">
                                                <div class="form-group row">
                                                    <label class="col-lg-12 col-form-label" for="val-ownerName">Department / Division
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" id="val-ownerDept" name="val-ownerDept" placeholder="Enter the department / division name..">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-sm-6 btn-submit"><center>
                                                                                    <!-- Go to Function (E) -->
                                                    <button type="button" style="width:15%" class="btn btn-secondary" id="btnNextDept" >Next</button></center>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Today Department Registration</h4> <a href="../data/dept/listDept.php" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;View All Record &nbsp;&nbsp;<i class="ti ti-angle-double-right"></i>&nbsp;&nbsp;&nbsp;</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example2" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date Registration</th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_todayOwnerReg" >
                                            <?php while($data = mysqli_fetch_array($query_today)){ 
                                                $dateregistered_Dept = date('d F Y', strtotime($data['timestamp_dept']));
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($data['name_dept']) ?></td>
                                                <td><?php echo $dateregistered_Dept ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="basicModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Department Registration Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="ownerDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveDept">Submit</button>
                    </div>
                </div>
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