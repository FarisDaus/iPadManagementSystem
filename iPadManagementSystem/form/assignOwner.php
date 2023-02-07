<?php 
    
    session_start();
    if(isset($_SESSION['unlock_key'])){
        include("../../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
        //for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
        if(isset($_POST['serialNo'])){
            $sql_ipadInfo = "SELECT * FROM ipad WHERE serialNo_ipad = '".$_POST['serialNo']."' ";
            $query_ipadInfo = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo);
            $ipadInfo = mysqli_fetch_assoc($query_ipadInfo);
        }
        else if($_SESSION['serialNo']){
            $sql_ipadInfo = "SELECT * FROM ipad WHERE serialNo_ipad = '".$_SESSION['serialNo']."' ";
            $query_ipadInfo = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo);
            $ipadInfo = mysqli_fetch_assoc($query_ipadInfo);
        }
		
    }
    else{
        header("Location: ./login.php");
    }

    
    //for display the name department in distinct
    $sql_deptDistinct = "SELECT DISTINCT(name_dept),ID_dept FROM department";
	$query_deptDistinct = mysqli_query($dbconn_ipadManagement,$sql_deptDistinct);
	
    //for display the name owner in distinct
	$sql_ownerDistinct = "SELECT DISTINCT(name_owner),ID_owner,status_owner FROM owner";
	$query_ownerDistinct = mysqli_query($dbconn_ipadManagement,$sql_ownerDistinct);



?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Assign User - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../../system/images/logo.png">
    <link href="../../system/css/style.css" rel="stylesheet">
    <link href="../../system/css/themify-icons.css" rel="stylesheet">
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
                            <li><a href="./newOwner.php">New Owner</a></li>
                            <li><a href="./newDept.php">New Department</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Data</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-archive"></i><span class="nav-text">Record</span></a>
                        <ul aria-expanded="false">
                            <li><a href="../data/iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                            <li><a href="../data/owner/listOwner.php?status=AllOwner" aria-expanded="false">User</a>
                            <li><a href="../data/dept/listDept.php" aria-expanded="false">Department</a>
                        </ul>
                    </li>
                    
                    <li class="nav-label">Search</li>
                    <li><a href="../search/ipadtracking.php" aria-expanded="false"><i class="icon ti-search"></i><span class="nav-text">iPad Tracking</span></a></li> 

                    <li class="nav-label">Personal</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-lock"></i><span class="nav-text">Administration</span></a>
                        <ul aria-expanded="false">
                            <li><a href="../admin/adduser.php">Add User</a></li>
                            <li><a href="../admin/existingUser.php">Existing User</a></li>
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
                        <h4><?php echo ucwords($dataUsers['name_users']) ?></h4>
                        <p class="mb-0">Company Secretary Department </p>
                        <p class="mb-0" style="margin-top:-4px;"><?php echo $dataUsers['email_users'] ?></p>
                      </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../data/iPad/listiPad.php?status=AlliPad">Record</a></li>
                            <li class="breadcrumb-item"><a href="../data/iPad/listiPad.php?status=AlliPad">iPad</a></li>
                            <li class="breadcrumb-item"><a href="#">Assign User</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row justify-content-md-center countActive">
                    <div class="col-lg-2 col-sm-6">
                      <a href="../data/iPad/listiPad.php?status=AlliPad" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-warning" style="<?php echo $a ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-tablet text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">All iPad</div>
                            <div class="stat-digit text-light"> <?php echo $AlliPad ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>All iPad</b><br>Total number of all iPad include available, in use & returned</span>
                                <i class="ti-help-alt"></i>
                              </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                      <a href="../data/iPad/listiPad.php?status=NewiPad" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-03" style="<?php echo $b ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-tablet text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">Available iPad</div>
                            <div class="stat-digit text-light"> <?php echo $NewiPad ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>Available iPad</b><br>An iPad that's available to borrow</span>
                                <i class="ti-help-alt"></i>
                              </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                      <a href="../data/iPad/listiPad.php?status=InUseiPad" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-danger" style="<?php echo $c ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-tablet text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">In Use iPad</div>
                            <div class="stat-digit text-light"> <?php echo $InUseiPad ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>In Use iPad</b><br>An iPad being borrowed</span>
                                <i class="ti-help-alt"></i>
                              </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                      <a href="../data/iPad/listiPad.php?status=ReturniPad" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-02" style="<?php echo $d ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-tablet text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">Returned iPad </div>
                            <div class="stat-digit text-light"> <?php echo $ReturnediPad ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>Returned iPad</b><br>An iPad that has been returned and hasn't been borrowed by any users</span>
                                <i class="ti-help-alt"></i>
                              </div>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card boxShadow">
                            <div class="card-header">
                                <h4 class="card-title">Ipad Information</h4>
                            </div>
                            <div class="card-body">
                                <table class='table table-bordered table-responsive-sm' style="min-width: 28rem !important;">
                                    <thead>
                                        <tr>
                                            <th colspan='2' style='text-align:center;'>iPad Information</th>
                                        </tr>
                                        <tr>
                                            <th >Device Name</th>
                                            <td><?php echo ucwords($ipadInfo['assetType_ipad']) ?></td>
                                        </tr>
                                        <tr>
                                            <th >Model Name</th>
                                            <td><?php echo ucwords($ipadInfo['modelType_ipad']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>RFID No.</th>
                                            <td>1020000700<?php echo $ipadInfo['rfidno_ipad'] ?>0000</td>
                                        </tr>
                                        <tr>
                                            <th>Serial No.</th>
                                            <td><?php echo strtoupper($ipadInfo['serialNo_ipad']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td><?php
                                                    if($ipadInfo['remarks_ipad'] == "" || $ipadInfo['remarks_ipad'] == "None") {
                                                        echo'None';
                                                    }
                                                    else{
                                                        echo $ipadInfo['remarks_ipad'];
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Condition</th>
                                            <td><?php
                                                    if($ipadInfo['condition_ipad'] == "0") {
                                                        echo'New';
                                                    }
                                                    else{
                                                        echo 'Used';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Box</th>
                                            <td>
                                                <?php 
                                                    if($ipadInfo['box_ipad'] == '1'){ 
                                                        echo 'Include';
                                                    }
                                                    else{
                                                        echo'Not Include';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Adapter</th>
                                            <td>
                                                <?php 
                                                    if($ipadInfo['adapter_ipad'] == '1'){ 
                                                        echo 'Include';
                                                    }
                                                    else{
                                                        echo'Not Include';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Cable</th>
                                            <td>
                                                <?php 
                                                    if($ipadInfo['wire_ipad'] == '1'){ 
                                                        echo 'Include';
                                                    }
                                                    else{
                                                        echo'Not Include';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Other Acces.</th>
                                            <td>
                                                <?php 
                                                    if($ipadInfo['accesories_ipad'] == '1'){ 
                                                        echo ucwords($ipadInfo['otherAccessories_ipad']);
                                                    }
                                                    else{
                                                        echo'Not Include';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card boxShadow">
                            <div class="card-header">
                                <h4 class="card-title">User Information</h4> <a href="newOwner.php" class="btn btn-primary">&nbsp;&nbsp;Add new User &nbsp;&nbsp;<i class="ti ti-plus"></i>&nbsp;&nbsp;</a>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide">
                                        <div class="row">
                                            <div class="col-xl-12">
												<?php if($AllOwner > 0){ ?>
                                                <div class="form-group row">
                                                    <label class="col-lg-12 col-form-label" for="val-ownerNameSelect">Name 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-12">
                                                        <select class="form-control val-ownerID SelectOwnerIDform" id="val-ownerID"  name="val-ownerID">
                                                            <option value="">Please select</option>
                                                            <?php while( $dataOwner = mysqli_fetch_array($query_ownerDistinct)){
                                                                if($dataOwner['status_owner'] == '1'){
                                                            ?>
                                                                <option value="<?php echo $dataOwner['ID_owner'] ?>" disabled><?php echo ucwords($dataOwner['name_owner']) ?></option>
                                                            <?php }else{ ?>
																<option value="<?php echo $dataOwner['ID_owner'] ?>"><?php echo ucwords($dataOwner['name_owner']) ?></option>
															<?php } }	?>
                                                        </select><br>
                                                        <table class="table table-bordered" id="detailsOwner" ></table>
                                                    </div>
                                                    
                                                </div>
                                                <input type="hidden" name="val-ipadID" id="val-ipadID" value="<?php echo $ipadInfo['ID_ipad'] ?>" >
                                                <div class="col-lg-12 col-sm-6 btn-submit"><center><br>
                                                    <button type="button" style="width:15%" class="btn btn-secondary" id="btnNextAssignOwner" >Next</button></center>
                                                </div>
												<?php }else{ ?>
                                                <center>
												    <img width="60%" src="../../system/images/no_pic.png">
                                                    <div class="no_records">No Owner record found!</div>
                                                    <a href="newOwner.php" class="btn btn-primary">&nbsp;&nbsp;Add new Owners &nbsp;&nbsp;<i class="ti ti-plus"></i>&nbsp;&nbsp;</a><br><br>
                                                </center>
												<?php } ?>
												
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="basicModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign User Registration</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="ownerDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveAssignOwner">Submit</button>
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