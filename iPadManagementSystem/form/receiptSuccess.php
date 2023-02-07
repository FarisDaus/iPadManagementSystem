<?php 
    session_start();
    if(isset($_SESSION['unlock_key'])){
        include("../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
        if(isset($_POST['ID_owner'])){
            $sql_ipadInfo = "SELECT ipad.*,owner.*,ipad_owner.*,department.*,users.* FROM ipad_owner 
            INNER JOIN owner ON owner.ID_owner = ipad_owner.ID_owner 
            INNER JOIN ipad ON ipad.ID_ipad = ipad_owner.ID_ipad 
            INNER JOIN department ON department.ID_dept = owner.ID_dept
            INNER JOIN users ON users.ID_users = ipad_owner.ID_users
            WHERE ipad_owner.ID_owner = '".$_POST['ID_owner']."' ";
            $query_ipadInfo = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo);
            $count_ipadInfo = mysqli_num_rows($query_ipadInfo);
            $ipadInfo = mysqli_fetch_assoc($query_ipadInfo);
            
            if($count_ipadInfo == '0'){
                $sql_ipadInfo = "SELECT owner.*,department.* FROM owner 
                INNER JOIN department ON department.ID_dept = owner.ID_dept
                WHERE owner.ID_owner = '".$_POST['ID_owner']."' ";
                $query_ipadInfo = mysqli_query($dbconn_ipadManagement,$sql_ipadInfo);
                $ipadInfo = mysqli_fetch_assoc($query_ipadInfo);
                
                $ipadInfo['assetType_ipad'] = "Not Assigned";
                $ipadInfo['rfidno_ipad'] = "Not Assigned";
                $ipadInfo['serialNo_ipad'] = "Not Assigned";
                $ipadInfo['remarks_ipad'] = "Not Assigned";
                $ipadInfo['name_users'] = "Not Assigned";
                $ipadInfo['email_users'] = "Not Assigned";
                $ipadInfo['dateassigned_ipadOwner'] = "Not Assigned";
            }
        }
    }
    else{
        header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PNB - iPad Management System Secetary Dept </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../images/logo.png">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/themify-icons.css" rel="stylesheet">
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
        <a href="../" class="brand-logo">
          <img class="logo-abbr" src="../images/logo-text.png" alt="">
          <img class="logo-compact" src="../images/logo-text.png" alt="">
          <img class="brand-title" src="../images/logo-text.png" alt="">
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
                        <span class="success">
                          <i class="ti-user"></i>
                        </span>
                        <div class="media-body">
                          <a href="#">
                            <p>
                              <strong>Martin</strong> has added a <strong>customer</strong> Successfully
                            </p>
                          </a>
                        </div>
                        <span class="notify-time">3:20 am</span>
                      </li>
                    </ul>
                    <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i>
                    </a>
                  </div>
                </li>
                <li class="nav-item dropdown header-profile">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                    <i class="mdi mdi-account"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="./profile.php" class="dropdown-item">
                      <i class="icon-user"></i>
                      <span class="ml-2">Profile </span>
                    </a>
                    <a href="./email-inbox.html" class="dropdown-item">
                      <i class="icon-envelope-open"></i>
                      <span class="ml-2">Inbox </span>
                    </a>
                    <a href="./logout.php" class="dropdown-item">
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
              <a href="../">
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
                  <a href="../form/newIpad.php">New Ipad</a>
                </li>
                <li>
                  <a href="../form/newOwner.php">New Owner</a>
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
                <li>
                  <a class="has-arrow" href="javascript:void()" aria-expanded="false">iPad</a>
                  <ul aria-expanded="false">
                    <li>
                      <a href="../data/iPad/listiPad.php?status=AlliPad">All</a>
                    </li>
                    <li>
                      <a href="../data/iPad/listiPad.php?status=NewiPad">New</a>
                    </li>
                    <li>
                      <a href="../data/iPad/listiPad.php?status=InUseiPad">In Use</a>
                    </li>
                    <li>
                      <a href="../data/iPad/listiPad.php?status=ReturniPad">Returned</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a class="has-arrow" href="javascript:void()" aria-expanded="false">Owner</a>
                  <ul aria-expanded="false">
                    <li>
                      <a href="../data/owner/listOwner.php?status=AllOwner">All</a>
                    </li>
                    <li>
                      <a href="../data/owner/listOwner.php?status=NewOwner">New</a>
                    </li>
                    <li>
                      <a href="../data/owner/listOwner.php?status=ExistingOwner">Existing</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="nav-label">Search</li>
            <li>
              <a href="../search/ipadtracking.php" aria-expanded="false">
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
                  <a href="../admin/adduser.php">Add User</a>
                </li>
                <li>
                  <a href="../admin/existingUser.php">Existing User</a>
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
                        <p class="mb-0">Secetary Department </p>
                        <p class="mb-0" style="margin-top:-4px;"><?php echo $dataUsers['email_users'] ?></p>
                      </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Details</a></li>
                        </ol>
                    </div>
                  </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div class="tab-content">
                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="profile-personal-info">
                                                    <h4 class="text-primary mb-4" style="margin-top:20px;">Owner Information</h4>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo ucwords($ipadInfo['name_owner']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Department <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo ucwords($ipadInfo['name_dept']) ?></span>
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
                    <div class="col-lg-12">
                        <div class="card">
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
                                                        <div class="col-9 font-color-black"><span><?php echo ucwords($ipadInfo['assetType_ipad']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">RFID No. <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $ipadInfo['rfidno_ipad'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Serial No. <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $ipadInfo['serialNo_ipad'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Remarks <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $ipadInfo['remarks_ipad'] ?></span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <?php if($ipadInfo['status_owner'] == "1"){ ?>
                                                    <?php }else{ ?><center>
                                                        <form action="../form/assignIpad.php" method="POST">
                                                            <input type="hidden" name="ID_owner" value="<?php echo $ipadInfo['ID_owner'] ?>">
                                                            <button type="submit" class="btn btn-info">Assign owner &nbsp;<i class="ti ti-tablet"></i></button>
                                                        </form></center>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div class="tab-content">
                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="profile-personal-info">
                                                    <h4 class="text-primary mb-4" style="margin-top:20px;">Delivery Information</h4>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Person In Charge <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo ucwords($ipadInfo['name_users']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $ipadInfo['email_users'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-3">
                                                            <h5 class="f-w-500">Timestamp <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-9 font-color-black"><span><?php echo $ipadInfo['dateassigned_ipadOwner'] ?></span>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div class="tab-content">
                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="profile-personal-info">
                                                    <h4 class="text-primary mb-4" style="margin-top:20px;">Receipt of fixed asset form</h4>
                                                    <div class="row mb-4 justify-content-md-center">
                                                        <div class="col-3">
                                                            <?php if($ipadInfo['status_owner'] == "1"){ ?>
                                                            <form action="../form/fixedAssetForm.php" method="POST">
                                                                <input type="hidden" name="ID_owner" value="<?php echo $ipadInfo['ID_owner'] ?>"/>
                                                                <input type="hidden" name="file" value="gfgpdf"/>
                                                                <button type="submit" class="btn btn-rounded btn-warning btn-download">
                                                                    <span class="btn-icon-left text-warning">
                                                                        <center style="margin-left:10px;"><i class="fa fa-download color-warning"></i></center>
                                                                    </span>Download Form
                                                                </button>
                                                            </form>
                                                            <?php }else{ ?>
                                                                <img width="130%" src="../images/no_pic.png">
                                                            <?php } ?>
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
        <div class="footer">
            <div class="copyright">
                <p>© Hak Cipta 2022 <a href="https://www.pnb.com.my/" target="_blank">Permodalan Nasional Berhad</a>. Hak Cipta Terpelihara. </p>
            </div>
        </div>
    </div>
    
    <script src="../vendor/global/global.min.js"></script>
    <script src="../js/quixnav-init.js"></script>
    <script src="../js/custom.min.js"></script>
    

</body>

</html>