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

    if($_GET['status'] == "AllOwner"){
        $id = '';
        $name = "All User";
        $a = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
        $b = "";
        $c = "";
        $d = "";
    }else if($_GET['status'] == "NewOwner"){
        $id = 0;
        $a = "";
        $b = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
        $c = "";
        $d = "";
        $name = "New User";
    }else if($_GET['status'] == "ExistingOwner"){
        $id = 1;
        $a = "";
        $b = "";
        $c = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
        $d = "";
        $name = "Existing User";
    }else if($_GET['status'] == "SeniorOwner"){
        $id = 2;
        $name = "Former User";
        $a = "";
        $b = "";
        $c = "";
        $d = "box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;";
    }

    $sql_data = "SELECT owner.*,department.* FROM owner 
    INNER JOIN department ON owner.ID_dept = department.ID_dept ";
    $query_data = mysqli_query($dbconn_ipadManagement,$sql_data);

    $sql_data2 = "SELECT owner.*,department.* FROM owner 
    INNER JOIN department ON owner.ID_dept = department.ID_dept WHERE owner.status_owner = '".$id."' ";
    $query_data2 = mysqli_query($dbconn_ipadManagement,$sql_data2);

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
            <a href="index.html" class="brand-logo">
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
                                    <a href="./app-profile.html" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="./page-login.html" class="dropdown-item">
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
                            <li><a href="../../form/newOwner.php">New Owner</a></li>
                            <li><a href="../../form/newDept.php">New Department</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Data</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon ti-archive"></i><span class="nav-text">Record</span></a>
                        <ul aria-expanded="false">
                            <li><a href="../iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                            <li><a href="./listOwner.php?status=AllOwner" aria-expanded="false">User</a></li>
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
                            <li class="breadcrumb-item"><a href="./listOwner.php?status=AllOwner">Record</a></li>
                            <li class="breadcrumb-item"><a href="./listOwner.php?status=AllOwner">User</a></li>
                            <li class="breadcrumb-item"><a href="./listOwner.php?status=<?php echo $_GET['status'] ?>"><?php echo $name ?></a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row justify-content-md-center countActive">
                    <div class="col-lg-2 col-sm-6">
                      <a href="../owner/listOwner.php?status=AllOwner" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-warning" style="<?php echo $a ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-user text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">All User</div>
                            <div class="stat-digit text-light"> <?php echo $AllOwner ?> </div>
                                <div class="tooltips">
                                    <span class="tooltiptexts"><b>All User</b><br>Total number of all users include new, exisiting & former</span>
                                    <i class="ti-help-alt"></i>
                                </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                      <a href="../owner/listOwner.php?status=NewOwner" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-03" style="<?php echo $b ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-user text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">New User</div>
                            <div class="stat-digit text-light"> <?php echo $NewOwner ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>New User</b><br>Users who have never received an iPad</span>
                                <i class="ti-help-alt"></i>
                              </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                      <a href="../owner/listOwner.php?status=ExistingOwner" class="card boxShadow">
                        <div class="stat-widget-one card-body countActive bg-danger" style="<?php echo $c ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-user text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">Existing User</div>
                            <div class="stat-digit text-light"> <?php echo $ExistingOwner ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>Existing User</b><br>Users who currently borrow an iPad</span>
                                <i class="ti-help-alt"></i>
                              </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                      <a href="../owner/listOwner.php?status=SeniorOwner" class="card boxShadow">
                        <div class="stat-widget-one card-body bg-02" style="<?php echo $d ?>">
                          <div class="stat-icon d-inline-block">
                            <i class="ti-user text-light border-light"></i>
                          </div><br>
                          <div class="stat-content d-inline-block">
                            <div class="stat-text text-light">Former User</div>
                            <div class="stat-digit text-light"> <?php echo $OldOwner ?> </div>
                              <div class="tooltips">
                                <span class="tooltiptexts"><b>Former User</b><br>Users who have returned an iPad and not received a new iPad</span>
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
                                <h4 class="card-title">Records of <?php echo $name ?></h4> <a href="../../../system/File/iPadList.xlsx" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Download &nbsp;&nbsp;<i class="ti ti-download"></i>&nbsp;&nbsp;&nbsp;</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Owner</th>
                                                <th>Department </th>
                                                <th>Timestamp Reg.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($id == ''){
                                                    while($dataOwner = mysqli_fetch_array($query_data)){ 
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($dataOwner['name_owner']) ?> <?php if($dataOwner['status_owner'] == '0'){ ?><span class="badge badge-warning">New</span><?php  }else if($dataOwner['status_owner'] == '1'){?> <span class="badge badge-success">Existing</span> <?php } else if($dataOwner['status_owner'] == '2') {?> <span class="badge badge-danger">Former</span> <?php } ?></td>
                                                <td><?php echo ucwords($dataOwner['name_dept']) ?></td>
                                                <td><?php echo $dataOwner['dateregistered_owner'] ?></td>
                                                <td width="25%">
                                                    <div class="row">
                                                        <div class="col-lg-2 ">
                                                            <form action="../../form/updateOwner.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Update details</span>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="ti ti-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/owner/infoDetails.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">view details</span>
                                                                    <button type="submit" class="btn btn-info">
                                                                        <i class="ti ti-new-window"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <?php if($dataOwner['status_owner'] == '1'){ ?>
                                                            <form action="../../form/returniPad.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner'] ?>" >
                                                                <button type="submit" class="btn btn-warning">
                                                                    <i class="ti ti-share-alt"></i>
                                                                </button>
                                                            </form>
                                                            <?php }else { ?>
                                                            <form action="../../form/assignIpad.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner'] ?>" >
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Assign iPad</span>
                                                                    <button type="submit" class="btn btn-success">
                                                                        <i class="ti ti-tablet"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <?php } ?>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/iPad/infoDetails.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Delete Owner</span>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } }else{
                                                    while($dataOwner = mysqli_fetch_array($query_data2)){
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($dataOwner['name_owner']) ?> </td>
                                                <td><?php echo ucwords($dataOwner['name_dept']) ?></td>
                                                <td><?php echo $dataOwner['dateregistered_owner'] ?></td>
                                                <td width="25%">
                                                    <div class="row">
                                                        <div class="col-lg-2 ">
                                                            <form action="../../form/updateOwner.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Update details</span>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="ti ti-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/owner/infoDetails.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">view details</span>
                                                                    <button type="submit" class="btn btn-info">
                                                                        <i class="ti ti-new-window"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <?php if($dataOwner['status_owner'] == '1'){ ?>
                                                            <form action="../../form/returniPad.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner'] ?>" >
                                                                <button type="submit" class="btn btn-warning">
                                                                    <i class="ti ti-share-alt"></i>
                                                                </button>
                                                            </form>
                                                            <?php }else { ?>
                                                            <form action="../../form/assignIpad.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataOwner['ID_owner'] ?>" >
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Assign iPad</span>
                                                                    <button type="submit" class="btn btn-success">
                                                                        <i class="ti ti-tablet"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <?php } ?>
                                                        </div>&nbsp;
                                                        <div class="col-lg-2 ">
                                                            <form action="../../data/owner/infoDetails.php" method="POST">
                                                                <input type="hidden" name="ownerID" value="<?php echo $dataiPad['ID_owner']; ?>">
                                                                <div class="tooltips">
                                                                    <span class="tooltiptexts">Delete Owner</span>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } }?>
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

</body>

</html>