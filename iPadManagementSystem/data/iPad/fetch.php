<?php
session_start();
include("../../system/dbconn.php");
mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');

$sql_all = "SELECT * FROM ipad";
$query_all = mysqli_query($dbconn_ipadManagement,$sql_all);
$AlliPad = mysqli_num_rows($query_all);

$sql_own = "
SELECT ipad.*,owner.*,department.*,ipad_owner.* FROM ipad_owner 
INNER JOIN owner ON owner.ID_owner = ipad_owner.ID_owner 
INNER JOIN ipad ON ipad.ID_ipad = ipad_owner.ID_ipad 
INNER JOIN department ON owner.ID_dept = department.ID_dept
WHERE ipad.serialNo_ipad = '".$dataiPad['serialNo_ipad']."' ";
$query_own = mysqli_query($dbconn_ipadManagement,$sql_own);
$data_own = mysqli_fetch_assoc($query_own);

while($data = mysqli_fetch_array($query_all)){ 
    echo '<tr>
        <td>'.$data['assetType_ipad'].'</td>
        <td>'.$data['serialNo_ipad'].'</td>
        <td>'.$data['rfidno_ipad'].'</td>
        <td>'.$data['dateregistered_ipad'].'</td>
        <td width="25%">
            <div class="row">
                <div class="col-lg-2 ">
                    <button type="button" class="btn btn-primary updateIpad" id="'.$data['serialNo_ipad'].'"  >
                        <i class="ti ti-pencil-alt"></i>
                    </button>
                </div>&nbsp;
                <div class="col-lg-2 ">
                    <button type="button" class="btn btn-info viewIpad" id="'.$data['serialNo_ipad'].'">
                        <i class="ti ti-new-window"></i>
                    </button>
                </div>&nbsp;
                <div class="col-lg-2 ">';
                if($data_own['status_ipadOwner'] == '1'){ 
                    echo '<form action="../../form/returniPad.php" method="POST">
                        <input type="hidden" name="serialNo" value="'.$data_own['serialNo_ipad'].'" >
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-share-alt"></i>
                        </button>
                    </form>';
                     }else { 
                    echo '<form action="../../form/assignOwner.php" method="POST">
                        <input type="hidden" name="serialNo" value="'.$data['serialNo_ipad'].'" >
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-user"></i>
                        </button>
                    </form>';
                    }
                echo '</div>&nbsp;
                <div class="col-lg-2 ">
                    <button type="button" class="btn btn-danger deleteIpad" id="'.$data['serialNo_ipad'].'">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        </td>
    </tr>';
 } 

?>

    <!--************* Scripts *******************-->
    <script src="../../vendor/global/global.min.js"></script>
    <script src="../../js/quixnav-init.js"></script>
    <script src="../../js/custom.min.js"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../js/plugins-init/datatables.init.js"></script>
    <script src="../../vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../js/plugins-init/jquery.validate-init.js"></script>
    <script src="../../system/jquery.js"></script>