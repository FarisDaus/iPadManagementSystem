<?php 
    session_start();
    if(isset($_SESSION['unlock_key'])){
        include("../../../system/dbconn.php");
        mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
        
		//for display the information of user login
		$sql_users = "SELECT * FROM users WHERE email_users = '".$_SESSION['unlock_key']."' ";
		$query_users = mysqli_query($dbconn_ipadManagement,$sql_users);
		$dataUsers = mysqli_fetch_assoc($query_users);
        
        if(isset($_POST['ownerID'])){
            $sql_OwnerInfo = "SELECT ipad.*,owner.*,rental_return.*,department.*,return.*,users.* FROM rental_return 
            INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
            INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
            INNER JOIN department ON department.ID_dept = owner.ID_dept
            INNER JOIN return ON return.ID_return = rental_return.ID_return 
            INNER JOIN users ON owner.ID_users = users.ID_users
            WHERE owner.ID_owner = '".$_POST['ownerID']."' && rental_return.status_IpadOwner = '2' ";
            $query_OwnerInfo = mysqli_query($dbconn_ipadManagement,$sql_OwnerInfo);
            $count_OwnerInfo = mysqli_num_rows($query_OwnerInfo);
           
            $sql_OwnerInfo3 = "SELECT ipad.*,owner.*,rental_return.*,department.*,users.* FROM rental_return 
            INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
            INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
            INNER JOIN department ON department.ID_dept = owner.ID_dept
            INNER JOIN users ON owner.ID_users = users.ID_users
            WHERE owner.ID_owner = '".$_POST['ownerID']."' && rental_return.status_IpadOwner = '1' ";
            $query_OwnerInfo3 = mysqli_query($dbconn_ipadManagement,$sql_OwnerInfo3);
            $count_OwnerInfo3 = mysqli_num_rows($query_OwnerInfo3);

            $sql_OwnerInfo2 = "SELECT owner.*,department.*,users.* FROM owner
            INNER JOIN department ON department.ID_dept = owner.ID_dept
            INNER JOIN users ON owner.ID_users = users.ID_users
            WHERE owner.ID_owner = '".$_POST['ownerID']."' ";
            $query_OwnerInfo2 = mysqli_query($dbconn_ipadManagement,$sql_OwnerInfo2);
            $data_OwnerInfo2 = mysqli_fetch_assoc($query_OwnerInfo2);
            
            $i = 0; 
            
            
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
    <title>Info Details - iPad Management System Company Secretary Department </title>
    <link rel="icon" type="image/png" sizes="5x5" href="../../../system/images/logo.png">
    <link href="../../../system/css/style.css" rel="stylesheet">
    <link href="../../../system/css/themify-icons.css" rel="stylesheet">
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
        <a href="../../" class="brand-logo">
          <img class="logo-abbr" src="../../../system/images/logo-text.png" alt="">
          <img class="logo-compact" src="../../../system/images/logo-text.png" alt="">
          <img class="brand-title" src="../../../system/images/logo-text.png" alt="">
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
              <a href="../../">
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
                <li><a href="../../form/newIpad.php">New Ipad</a></li>
                <li><a href="../../form/newOwner.php">New User</a></li>
                <li><a href="../../form/newOwner.php">New Department</a></li>
              </ul>
            </li>
            <li class="nav-label">Data</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="icon ti-archive"></i>
                <span class="nav-text">Record</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="../../data/iPad/listiPad.php?status=AlliPad" aria-expanded="false">iPad</a></li>
                <li><a href="../../data/owner/listOwner.php?status=AllOwner" aria-expanded="false">User</a></li>
                  <li><a href="../dept/listDept.php" aria-expanded="false">Department</a></li>
              </ul>
            </li>
            <li class="nav-label">Search</li>
            <li>
              <a href="../../search/ipadtracking.php" aria-expanded="false">
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
                  <a href="../../admin/adduser.php">Add Staff</a>
                </li>
                <li>
                  <a href="../../admin/listuser.php">List Staff</a>
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
                            <li class="breadcrumb-item"><a href="../owner/listOwner.php?status='AllOwner'">Record</a></li>
                            <li class="breadcrumb-item"><a href="../owner/listOwner.php?status='AllOwner'">User</a></li>
                            <li class="breadcrumb-item"><a href="#">User Details</a></li>
                        </ol>
                    </div>
                  </div>
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
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo ucwords($data_OwnerInfo2['name_owner']) ?> (<?php echo ucwords($data_OwnerInfo2['name_dept']) ?>)</h5>
                        </div>
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home1">Owner Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile1">iPad Information</a>
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
                                                                        <div class="row mb-4">
                                                                            <div class="col-3">
                                                                                <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="col-9 font-color-black"><span><?php echo ucwords($data_OwnerInfo2['name_owner']) ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-3">
                                                                                <h5 class="f-w-500">Department <span class="pull-right">:</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="col-9 font-color-black"><span><?php echo ucwords($data_OwnerInfo2['name_dept']) ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-3">
                                                                                <h5 class="f-w-500">Timestamp Registered <span class="pull-right">:</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="col-9 font-color-black"><span><?php echo ucwords($data_OwnerInfo2['dateregistered_owner']) ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-3">
                                                                                <h5 class="f-w-500">Status <span class="pull-right">:</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="col-9 font-color-black">
                                                                                <span>
                                                                                    <?php if($data_OwnerInfo2['status_owner'] == '0'){ ?>
                                                                                        <span>New Owner</span>
                                                                                    <?php  }else if($data_OwnerInfo2['status_owner'] == '1'){ ?>
                                                                                        <span>Existing Owner</span>
                                                                                    <?php }else if($data_OwnerInfo2['status_owner'] == '2'){ ?>
                                                                                        <span>Senior Owner</span>
                                                                                    <?php } ?>
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
                                                        <?php if($count_OwnerInfo3 > 0){
                                                                while($data = mysqli_fetch_array($query_OwnerInfo3)){ 
                                                                    $dateregistered_ipad = date('d F Y', strtotime($data['dateregistered_ipad']));
                                                                    $i++;
                                                        ?>
                                                         <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm">
                                                                <form action="../../data/ipad/acknowledgementReceipt.php" method="POST" class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Date Assign iPad</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <span style="color:black;font-weight:500">Enter Date :</span><br>
                                                                        <input type="date" class="form-control" name="dateAssign" required>
                                                                        <input type="hidden" name="actions" value="<?php echo $data['ID_rentalReturn'] ?>">
                                                                        <input type="hidden" name="ACTION" value="DOWNLOAD">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade bd-example-modal-sm-2" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm">
                                                                <form action="../../data/ipad/acknowledgementReceipt.php" method="POST" class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Date Assign iPad</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <span style="color:black;font-weight:500">Enter Date :</span><br>
                                                                        <input type="date" class="form-control" name="dateAssign" required>
                                                                        <input type="hidden" name="actions" value="<?php echo $data['ID_rentalReturn'] ?>">
                                                                        <input type="hidden" name="ACTION" value="VIEW">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary" target="blank">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

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
                                                                                                    <h4 class="text-primary mb-4" style="margin-top:20px;">User Information</h4>
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
                                                                                                            <h5 class="f-w-500">Department <span class="pull-right">:</span>
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
                                                                            <img src="../../../system/images/return.png" width="22%" style="position:absolute;right:90px;top:180px;">
                                                                        <?php } ?>
                                                                        <div class="col-lg-12">
                                                                            <div class="card-body">
                                                                                <div class="profile-tab">
                                                                                    <div class="custom-tab-1">
                                                                                        <div class="tab-content">
                                                                                            <div id="about-me" class="tab-pane fade active show">
                                                                                                <div class="profile-personal-info">
                                                                                                    <h4 class="text-primary mb-4">Staff In Charge Information</h4>
                                                                                                    <div class="row mb-4">
                                                                                                        <div class="col-3">
                                                                                                            <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                                                                            </h5>
                                                                                                        </div>
                                                                                                        <div class="col-9 font-color-black"><span><?php echo ucwords($data['name_users']) ?></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row mb-4">
                                                                                                        <div class="col-3">
                                                                                                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                                                                            </h5>
                                                                                                        </div>
                                                                                                        <div class="col-9 font-color-black"><span><?php echo $data['email_users'] ?></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row mb-4">
                                                                                                        <div class="col-3">
                                                                                                            <h5 class="f-w-500">Date Assigned <span class="pull-right">:</span>
                                                                                                            </h5>
                                                                                                        </div>
                                                                                                        <div class="col-9 font-color-black"><span><?php echo $dateregistered_ipad ?></span>
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
                                                                                                                        <button type='button' class='btn btn-rounded btn-warning btn-download' data-toggle='modal' data-dismiss='modal' data-target='.bd-example-modal-sm'>&nbsp;&nbsp;&nbsp;&nbsp;Download&nbsp;<i class='ti ti-download color-warning'></i></button>&nbsp;
                                                                                                                        <button type='button' class='btn btn-rounded btn-info btn-download' data-toggle='modal' data-dismiss='modal' data-target='.bd-example-modal-sm-2'>&nbsp;&nbsp;&nbsp;&nbsp;View&nbsp;<i class='ti ti-eye color-warning' ></i></button><br><br><br>
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
                                                                                    <div class="card-header">
                                                                                        <h4 class="text-primary mb-4" style="margin-top:20px;">Return Fixed asset receipt</h4>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div class="profile-tab">
                                                                                            <div class="custom-tab-1">
                                                                                                <div class="tab-content">
                                                                                                    <div id="about-me" class="tab-pane fade active show">
                                                                                                        <div class="profile-personal-info">
                                                                                                            <div class="row mb-4 justify-content-md-center">
                                                                                                                <div class='col-lg-12 mb-12'>
                                                                                                                        <center>
                                                                                                                            <button type='button' class='btn btn-rounded btn-warning btn-download' data-toggle='modal' data-dismiss='modal' data-target='.bd-example-modal-sm'>&nbsp;&nbsp;&nbsp;Download Form &nbsp;&nbsp;<i class='ti ti-download color-warning'></i>&nbsp;&nbsp;&nbsp;</button>
                                                                                                                            &nbsp;&nbsp;&nbsp;
                                                                                                                            <button type='button' class='btn btn-rounded btn-info btn-download' data-toggle='modal' data-dismiss='modal' data-target='.bd-example-modal-sm-2'>&nbsp;&nbsp;&nbsp;View Form &nbsp;&nbsp;<i class='ti ti-eye color-warning' ></i>&nbsp;&nbsp;&nbsp;</button>
                                                                                                                            &nbsp;&nbsp;&nbsp;<br><br>

                                                                                                                            <button type='file' class='btn btn-rounded btn-success btn-download'>
                                                                                                                               &nbsp;&nbsp;&nbsp;Upload Form &nbsp;&nbsp;<i class='ti ti-upload color-success'></i>&nbsp;&nbsp;&nbsp;
                                                                                                                            </button>
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
                                                            <center><img src="../../../system/images/no_pic.png" width="40%" ></center>
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
            <div class="row">
                
            </div>
        </div>
    </div>
        <div class="footer">
            <div class="copyright">
                <p>© Hak Cipta 2022 <a href="https://www.pnb.com.my/" target="_blank">Permodalan Nasional Berhad</a>. Hak Cipta Terpelihara. </p>
            </div>
        </div>
    </div>
    
    <script src="../../../system/vendor/global/global.min.js"></script>
    <script src="../../../system/js/quixnav-init.js"></script>
    <script src="../../../system/js/custom.min.js"></script>
    

</body>

</html>