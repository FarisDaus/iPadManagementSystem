<?php
    
    session_start();
    if(isset($_SESSION['unlock_key'])){
        include("../../../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
    }
    else{
        header("Location: ../");
    }

    if($_GET['status'] == "AlliPad"){
        $id = '';
        $name = "All iPad";
        $a = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
        $b = "";
        $c = "";
        $d = "";
    }else if($_GET['status'] == "NewiPad"){
        $id = '0';
        $name = "New iPad";
        $a = "";
        $b = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
        $c = "";
        $d = "";
    }else if($_GET['status'] == "InUseiPad"){
        $id = '1';
        $name = "In Use iPad";
        $a = "";
        $b = "";
        $c = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
        $d = "";
    }else if($_GET['status'] == "ReturniPad"){
        $id = '2';
        $name = "Returned iPad";
        $a = "";
        $b = "";
        $c = "";
        $d = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
    }

    $sql_data = "SELECT * FROM ipad WHERE status_ipad = '".$id."' ";
    $query_data = mysqli_query($dbconn_ipadManagement,$sql_data);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>List iPad - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../../../system/images/logo.png">
    <link href="../../../system/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../../system/css/style.css" rel="stylesheet">
    <link href="../../../system/css/themify-icons.css" rel="stylesheet">
    <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
    <link href="../../../system/css/themify-icons.css" rel="stylesheet">

</head>
<style>
    .ti{
        font-weight:700;
        font-size:13px;
    }    
</style>
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
            <a href="../" class="brand-logo">
                <img class="logo-abbr" src="../../../system/images/logo-text.png" alt="">
                <img class="logo-compact" src="../../../system/images/logo-text.png" alt="">
                <img class="brand-title" src="../../../system/images/logo-text.png" alt="">
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
                                    <a href="../../../notification.php" class="dropdown-item">
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
                    <li><a href="../../"><i class="icon ti-layout-grid2"></i><span class="nav-text">Dashboard</span></a></li> 
                    <li class="nav-label">Form</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="true"><i class="icon ti-write"></i><span class="nav-text">Registration</span></a>
                        <ul aria-expanded="true">
                            <li><a href="../../form/newIpad.php">New Ipad</a></li>
                            <li><a href="../../form/newOwner.php">New User</a></li>
                            <li><a href="../../form/newDept.php">New Department</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Data</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-archive"></i><span class="nav-text">Record</span></a>
                        <ul aria-expanded="false">
                            <li><a href="../iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                            <li><a href="../owner/listOwner.php?status=AllOwner" aria-expanded="false">User</a></li>
                            <li><a href="../dept/listDept.php" aria-expanded="false">Department</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-label">Search</li>
                    <li><a href="../../search/ipadtracking.php" aria-expanded="false"><i class="icon ti-search"></i><span class="nav-text">iPad Tracking</span></a></li> 

                    <li class="nav-label">Personal</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-lock"></i><span class="nav-text">Administration</span></a>
                        <ul aria-expanded="false">
                            <li><a href="../../admin/adduser.php">Add Staff</a></li>
                            <li><a href="../../admin/listuser.php">List Staff</a></li>
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
                            <li class="breadcrumb-item"><a href="./listiPad.php?status=AlliPad">Record</a></li>
                            <li class="breadcrumb-item"><a href="./listiPad.php?status=AlliPad">iPad</a></li>
                            <li class="breadcrumb-item"><a href="./listiPad.php?status=<?php echo $_GET['status'] ?>"><?php echo $name ?></a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row justify-content-md-center countActive">
                    <div class="col-lg-2 col-sm-6">
                      <a href="./listiPad.php?status=AlliPad" class="card boxShadow">
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
                      <a href="./listiPad.php?status=NewiPad" class="card boxShadow">
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
                      <a href="./listiPad.php?status=InUseiPad" class="card boxShadow">
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
                      <a href="./listiPad.php?status=ReturniPad" class="card boxShadow">
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Records of <?php echo $name ?></h4> <a href="../iPad/viewAll.php" class="btn btn-info" style="position: absolute;right: 165px;">&nbsp;&nbsp;&nbsp;View All &nbsp;&nbsp;<i class="ti ti-eye"></i>&nbsp;&nbsp;&nbsp;</a> <a href="../iPad/listIpadReceipt.php?action=<?php echo $_GET['status'] ?>&ACTION=DOWNLOAD" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Download &nbsp;&nbsp;<i class="ti ti-download"></i>&nbsp;&nbsp;&nbsp;</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Device Name</th>
                                                <th>Serial No.</th>
                                                <th>RFID No. </th>
                                                <th>Date Registered</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_updateIpad">
                                            <?php if($id == ""){
                                                    while($dataiPad = mysqli_fetch_array($query_all)){ 
                                                        
                                                    $dateregistered_ipad = date('d F Y', strtotime($dataiPad['dateregistered_ipad']));
                                                        
                                                    $sql_own = "
                                                    SELECT ipad.*,owner.*,department.*,rental_return.* FROM rental_return 
                                                    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
                                                    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
                                                    INNER JOIN department ON owner.ID_dept = department.ID_dept
                                                    WHERE ipad.serialNo_ipad = '".$dataiPad['serialNo_ipad']."' ";
                                                    $query_own = mysqli_query($dbconn_ipadManagement,$sql_own);
                                                    $data_own = mysqli_fetch_assoc($query_own);
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords(mb_strimwidth($dataiPad['assetType_ipad'], 0, 28, "...")); ?> <?php if($dataiPad['status_ipad'] == '0'){ ?><span class="badge badge-warning" style="background:#f06293 !important;color:white;">Available</span><?php  }else if($dataiPad['status_ipad'] == '1'){?> <span class="badge badge-success" style="background:#fa9f1b !important;color:white;">In Use</span> <?php }else{ ?><span class="badge badge-success" style="background:#df5645 !important;color:white;">Returned</span><?php } ?> </td>
                                                <td><?php echo strtoupper($dataiPad['serialNo_ipad']) ?></td>
                                                <td>1020000700<?php echo $dataiPad['rfidno_ipad'] ?></td>
                                                <td><?php echo $dateregistered_ipad ?></td>
                                                <td width="25%">
                                                    <div class="row">
                                                        <div class="col-lg-2 ">
                                                            <form action="../../form/updateIpad.php" method="POST">
                                                                <input type="hidden" name="serialNo_ipad" value="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Update details</span>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="ti ti-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/iPad/infoDetails.php" method="POST">
                                                                <input type="hidden" name="serialNo_ipad" value="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">view details</span>
                                                                    <button type="submit" class="btn btn-info">
                                                                        <i class="ti ti-new-window"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <?php if($dataiPad['status_ipad'] == '1'){ ?>
                                                            <form action="../../form/returniPad.php" method="POST">
                                                                <input type="hidden" name="ipadID" value="<?php echo $dataiPad['ID_ipad'] ?>" >
                                                                <button type="submit" class="btn btn-warning">
                                                                    <i class="ti ti-share-alt"></i>
                                                                </button>
                                                            </form>
                                                            <?php }else { ?>
                                                            <form action="../../form/assignOwner.php" method="POST">
                                                                <input type="hidden" name="serialNo" value="<?php echo $dataiPad['serialNo_ipad'] ?>" >
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Assign User</span>
                                                                    <button type="submit" class="btn btn-success">
                                                                        <i class="ti ti-user"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <?php } ?>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <div class="tooltips">
                                                              <span class="tooltiptexts">Delete iPad</span>
                                                              <button type="button" class="btn btn-danger deleteIpad" id="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                                 <i class="ti ti-trash"></i>
                                                              </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }
                                            }else{ 
                                                while($dataiPad = mysqli_fetch_array($query_data)){
                                                    
                                                $sql_own = "
                                                    SELECT ipad.*,owner.*,department.*,rental_return.* FROM rental_return 
                                                    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
                                                    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
                                                    INNER JOIN department ON owner.ID_dept = department.ID_dept
                                                    WHERE ipad.serialNo_ipad = '".$dataiPad['serialNo_ipad']."' ";
                                                    $query_own = mysqli_query($dbconn_ipadManagement,$sql_own);
                                                    $data_own = mysqli_fetch_assoc($query_own);
                                                    
                                                    $dateregistered_ipad = date('d F Y', strtotime($dataiPad['dateregistered_ipad']));
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords(mb_strimwidth($dataiPad['assetType_ipad'], 0, 28, "...")); ?> <?php if($dataiPad['status_ipad'] == '0'){ ?><span class="badge badge-warning" style="background:#f06293 !important;color:white;">Available</span><?php  }else if($dataiPad['status_ipad'] == '1'){?> <span class="badge badge-success" style="background:#fa9f1b !important;color:white;">In Use</span> <?php }else{ ?><span class="badge badge-success" style="background:#df5645 !important;color:white;">Returned</span><?php } ?></td>
                                                <td><?php echo strtoupper($dataiPad['serialNo_ipad']) ?></td>
                                                <td>1020000700<?php echo $dataiPad['rfidno_ipad'] ?></td>
                                                <td><?php echo $dateregistered_ipad ?></td>
                                                <td width="25%">
                                                    <div class="row">
                                                        <div class="col-lg-2 ">
                                                            <form action="../../form/updateIpad.php" method="POST">
                                                                <input type="hidden" name="serialNo_ipad" value="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                                <input type="hidden" name="rfidno_ipad" value="<?php echo $dataiPad['rfidno_ipad']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Update details</span>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="ti ti-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/iPad/infoDetails.php" method="POST">
                                                                <input type="hidden" name="serialNo_ipad" value="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">view details</span>
                                                                    <button type="submit" class="btn btn-info">
                                                                        <i class="ti ti-new-window"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <?php if($dataiPad['status_ipad'] == '1'){ ?>
                                                            <form action="../../form/returniPad.php" method="POST">
                                                                <input type="hidden" name="ipadID" value="<?php echo $dataiPad['ID_ipad'] ?>" >
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Return iPad</span>
                                                                    <button type="submit" class="btn btn-warning">
                                                                    <i class="ti ti-share-alt"></i>
                                                                </button>
                                                                </div>
                                                            </form>
                                                            <?php }else { ?>
                                                            <form action="../../form/assignOwner.php" method="POST">
                                                                <input type="hidden" name="serialNo" value="<?php echo $dataiPad['serialNo_ipad'] ?>" >
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Assign User</span>
                                                                    <button type="submit" class="btn btn-success">
                                                                        <i class="ti ti-user"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <?php } ?>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/iPad/infoDetails.php" method="POST">
                                                                <input type="hidden" name="serialNo_ipad" value="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">view details</span>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Large modal -->
        <div class="modal fade bd-example-modal-lg" id="ipadViewmodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">iPad & User Information</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="card-body" id="ipadViewDetails">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
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
    
    <script src="../../../system/vendor/global/global.min.js"></script>
    <script src="../../../system/js/quixnav-init.js"></script>
    <script src="../../../system/js/custom.min.js"></script>
    <script src="../../../system/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../../system/js/plugins-init/datatables.init.js"></script>
    <script src="../../../system/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../../system/js/plugins-init/jquery.validate-init.js"></script>
    <script src="../../../system/jquery.js"></script>

</body>

</html>