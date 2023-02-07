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

    $sql_data = "SELECT * FROM ipad ";
    $query_data = mysqli_query($dbconn_ipadManagement,$sql_data);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>List iPad - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../../images/logo.png">
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
    
    .word {
            width: 200px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
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
                                    <a href="../profile.php" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="../inbox.php" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="../logout.php" class="dropdown-item">
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
                            <li class="breadcrumb-item"><a href="./listiPad.php?status=AlliPad">All Record iPad</a></li>
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
                                <h4 class="card-title">Records of All iPad</h4> <a href="../iPad/listDetailIpadReceipt.php?action=VIEWALL&ACTION=DOWNLOAD" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Download &nbsp;&nbsp;<i class="ti ti-download"></i>&nbsp;&nbsp;&nbsp;</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th><center>Device Name</center></th>
                                                <th><center>Model Name</center></th>
                                                <th><center>Serial No.</center></th>
                                                <th><center>RFID No.</center> </th>
                                                <th><center>Status</center></th>
                                                <th>Box</th>
                                                <th>Adapter</th>
                                                <th>Wire</th>
                                                <th><center>Accesories</center></th>
                                                <th><center>Remarks</center></th>
                                                <th><center>Condition</center></th>
                                                <th><center>Date Register</center></th>
                                                <th><center>Date Last Update</center></th>
                                                <th><center>Date Return</center></th>
                                                <th><center>Action</center></th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_updateIpad">
                                            <?php 
                                                while($dataiPad = mysqli_fetch_array($query_data)){ 
                                                    $dateregistered_ipad = date('d F Y', strtotime($dataiPad['dateregistered_ipad']));
                                                    if($dataiPad['box_ipad'] == "1"){
                                                        $box_ipad = '<i class="fa fa-check-square" style="font-size:22px;color:green"></i>';
                                                    }
                                                    else{
                                                        $box_ipad = '<i class="fa fa-times-rectangle" style="font-size:22px;color:red"></i>';
                                                    }

                                                    if($dataiPad['adapter_ipad'] == "1"){
                                                        $adapter_ipad = '<i class="fa fa-check-square" style="font-size:22px;color:green"></i>';
                                                    }
                                                    else{
                                                        $adapter_ipad = '<i class="fa fa-times-rectangle" style="font-size:22px;color:red"></i>';
                                                    }

                                                    if($dataiPad['wire_ipad'] == "1"){
                                                        $wire_ipad = '<i class="fa fa-check-square" style="font-size:22px;color:green"></i>';
                                                    }
                                                    else{
                                                        $wire_ipad = '<i class="fa fa-times-rectangle" style="font-size:22px;color:red"></i>';
                                                    }
                                                    
                                                    if($dataiPad['remarks_ipad'] == "" || $dataiPad['remarks_ipad'] == "none"){
                                                        $remarks_ipad = '<i class="fa fa-minus" style="font-size:15px;"></i>';
                                                    }
                                                    else{
                                                        $remarks_ipad = ucwords($dataiPad['remarks_ipad']);
                                                    }
                                                    
                                                    if($dataiPad['status_ipad'] == "0"){
                                                        $status_ipad = "<span class='badge badge-success' style='background-color:#f06293;color:white;'>Available</span>";
                                                    }
                                                    else if($dataiPad['status_ipad'] == "1"){
                                                        $status_ipad = "<span class='badge badge-warning' style='background-color:#fa9f1b;color:white;'>In Use</span>";
                                                    }
                                                    
                                                    else if($dataiPad['status_ipad'] == "2"){
                                                        $status_ipad = "<span class='badge badge-danger' style='background-color:#df5645;color:white;'>Returned</span>";
                                                    }
                                                    
                                                    if($dataiPad['condition_ipad'] == "0"){
                                                        $condition_ipad = "<span class='badge badge-success'>New</span>";
                                                    }
                                                    else if($dataiPad['condition_ipad'] == "1"){
                                                        $condition_ipad = "<span class='badge badge-warning'>Used</span>";
                                                    }
                                                    
                                                    if($dataiPad['dateupdated_ipad'] == null){
                                                        $dateupdated_ipad = '<i class="fa fa-minus" style="font-size:15px;"></i>';
                                                    }
                                                    else{
                                                        $dateupdated_ipad = date('d F Y', strtotime($dataiPad['dateupdated_ipad']));
                                                    }
                                                    
                                                    if($dataiPad['datereturned_ipadOwner'] == null){
                                                        $datereturned_ipad = '<i class="fa fa-minus" style="font-size:15px;"></i>';
                                                    }
                                                    else{
                                                        $datereturned_ipad = date('d F Y', strtotime($dataiPad['datereturned_ipadOwner']));
                                                    }
                                            ?>
                                            <tr>
                                                <td ><center><p class="word"><?php echo ucwords($dataiPad['assetType_ipad']); ?></p></center></td>
                                                <td ><center><p class="word"><?php echo ucwords($dataiPad['modelType_ipad']); ?></p></center></td>
                                                <td><center><?php echo strtoupper($dataiPad['serialNo_ipad']) ?></center></td>
                                                <td><center>1020000700<?php echo $dataiPad['rfidno_ipad'] ?>0000</center></td>
                                                <td><center><?php echo $status_ipad ?></center></td>
                                                <td><center><?php echo $box_ipad ?></center></td>
                                                <td><center><?php echo $adapter_ipad ?></center></td>
                                                <td><center><?php echo $wire_ipad ?></center></td>
                                                <td><center>
                                                    <?php if($dataiPad['accesories_ipad'] == "0"){ ?>
                                                        <p class="word"><i class="fa fa-minus" style="font-size:15px;"></i></p>
                                                    <?php }else{ 
                                                        $sqlAcc_data = "
                                                        SELECT ipad.*,Accesories_ipad.* FROM ipad 
                                                        INNER JOIN Accesories_ipad ON Accesories_ipad.ID_ipad = ipad.ID_ipad
                                                        WHERE Accesories_ipad.ID_ipad = '".$dataiPad['ID_ipad']."' ";
                                                        $queryAcc_data = mysqli_query($dbconn_ipadManagement,$sqlAcc_data);
                                                        while($dataAcc_ipad = mysqli_fetch_array($queryAcc_data)){
                                                    ?>
                                                        <p class="word" style="margin-bottom: 0px;"><?php echo $dataAcc_ipad['name_accesories'] ?></p>
                                                    <?php } }?>
                                                    </center>
                                                </td>
                                                <td><center><p class="word"><?php echo $remarks_ipad ?></p></center></td>
                                                <td><center><?php echo $condition_ipad ?></center></td>
                                                <td><center><?php echo $dateregistered_ipad ?></center></td>
                                                <td><center><?php echo $datereturned_ipad ?></center></td>
                                                <td><center><?php echo $dateupdated_ipad ?></center></td>
                                                <td>
                                                    <center>
                                                        <form action="../../form/updateIpad.php" method="POST">
                                                            <input type="hidden" name="serialNo_ipad" value="<?php echo $dataiPad['serialNo_ipad']; ?>">
                                                            <div class="tooltips">
                                                                <span class="tooltiptexts">Update details</span>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="ti ti-pencil-alt"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </center>
                                                </td>
                                            </tr>
                                            <?php }?>
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