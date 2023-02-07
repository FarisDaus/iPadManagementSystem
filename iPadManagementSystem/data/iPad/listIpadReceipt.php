<link href="../../../system/css/style.css" rel="stylesheet">
<style>
    html,body{
        background:white;
    }
</style>
<?php                
    session_start();
    include("../../../system/dbconn.php");
    mysqli_select_db($dbconn_ipadManagement, 'ipadManagement');
    include_once('tcpdf_6_2_13/tcpdf/tcpdf.php');


    if($_GET['action'] == "AlliPad"){
        $id = '';
        $nameFile = 'LIST OF ALL IPAD';
    }else if($_GET['action'] == "NewiPad"){
        $id = '0';
        $nameFile = 'LIST OF NEW IPAD ('.$NewiPad.' iPad) ';
    }else if($_GET['action'] == "InUseiPad"){
        $id = '1';
        $nameFile = 'LIST OF IN USE IPAD ('.$InUseiPad.' iPad) ';
    }else if($_GET['action'] == "ReturniPad"){
        $id = '2';
        $nameFile = 'LIST OF RETURNED IPAD';
    }

$i = '1';

if($id == '1' || $id == '2'){
    $inv_mst_query = "SELECT ipad.*,owner.*,rental_return.*,department.*,users.*,rental.* FROM rental_return 
    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
    INNER JOIN department ON department.ID_dept = owner.ID_dept
    INNER JOIN rental ON rental.ID_rental = rental_return.ID_rental
    INNER JOIN users ON owner.ID_users = users.ID_users 
    WHERE ipad.status_ipad = '".$id."' ORDER BY rfidno_ipad ASC ";
}
else if($id == '0'){
    $inv_mst_query = "SELECT * FROM ipad WHERE status_ipad = '0' ORDER BY rfidno_ipad ASC ";
}
else{
    $inv_mst_query = "SELECT * FROM ipad ORDER BY rfidno_ipad ASC ";
}

$inv_mst_results = mysqli_query($dbconn_ipadManagement,$inv_mst_query);   
$count = mysqli_num_rows($inv_mst_results);  
if($count>0) 
{
	//----- Code for generate pdf
	$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);  
    
	//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
	$PDF_HEADER_LOGO = "./system/images/pnb.png";//any image file. check correct path.
    $PDF_HEADER_LOGO_WIDTH = "105";
    $PDF_HEADER_TITLE = "";
    $PDF_HEADER_STRING = "\n".$nameFile."\n\n\n";
    
    $pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING); 
    
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', '15'));  
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	$pdf->SetDefaultMonospacedFont('helvetica');  
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	$pdf->SetMargins('1', '30', '4');  
	$pdf->setPrintHeader(true);  
	$pdf->setPrintFooter(false);  
	$pdf->SetAutoPageBreak(TRUE, 12);  
	$pdf->SetFont('helvetica', '', 9); 
	//$pdf->AddPage(); //default A4
	$pdf->AddPage('L','A4'); //when you require custome page size 

	
	$content = ''; 

	$content .= '
	<style type="text/css">
        table{
            
            font-family: "Gothic A1", sans-serif;
            color:black;
            letter-spacing:0.5px;
            text-align: justify;
            text-justify: inter-word; 
        }
        
        td {
            vertical-align: middle;text-align:center;
        }
        
        .height{
            line-height: 20.5px !important;
        }
        
        .bg-color{
            background-color:grey !important;
        }
        
        .padding{
            margin-bottom:20px !important;
        }
        
        .border-table{
            border :0.5px solid black;
            text-align:center;
            padding:10px 4px 10px 4px;
        }
        
	</style> 
    
	<table cellpadding="0" cellspacing="6" style="width:100%;">
            <tr>
                <td ></td>
            </tr>
            
            <tr>
                <td>
                    <table ><thead>
                        <tr>
                            <th width="4%" class="border-table" ><b><br><font color="white">h</font><br>No.</b></th>
                            <th width="17%" class="border-table" ><b><br><font color="white">h</font><br>Model</b></th>
                            <th width="11%" class="border-table" ><b><br><font color="white">h</font><br>Serial No</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>RFID No.</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>Status</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>Condition</b></th>
                            <th width="8%" class="border-table"><b><font color="white">h</font><br>Date <br>Register</b></th>
                            <th width="11%" class="border-table"><b><br><font color="white">h</font><br>Accesories</b></th>
                            <th width="11%" class="border-table"><b><br><font color="white">h</font><br>User</b></th>
                            <th width="9%" class="border-table"><b><br><font color="white">h</font><br>Dept.</b></th>
                            <th width="8%" class="border-table"><b><font color="white">h</font><br>Date <br>Receive</b><br><font color="white">h</font></th>
                        </tr></thead>';
                    while($data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC)){
                        $dateregistered_ipad = date('d F Y', strtotime($data_row['dateregistered_ipad']));
                        $dateassigned = date('d F Y', strtotime($data_row['dateassigned']));
                        
                        $name = wordwrap(ucwords($data_row['name_owner']),15,"<br>\n");
                        $ipad = wordwrap(ucwords($data_row['modelType_ipad']),28,"<br>\n");
                        
                        if($data_row['condition_ipad'] == "0"){
                            $condition_ipad = "New";
                        }
                        else if($data_row['condition_ipad'] == "1"){
                            $condition_ipad = "Used";
                        }
                        
                        if($data_row['status_ipad'] == "0"){
                            $status_ipad = "Available";
                        }
                        else if($data_row['status_ipad'] == "1"){
                            $status_ipad = "In Use";
                        }

                        else if($data_row['status_ipad'] == "2"){
                            $status_ipad = "Returned";
                        }
                        
                        if($data_row['box_ipad'] == "1"){
                            $box_ipad = '1 x Box';
                        }
                        else{
                            $box_ipad = '';
                        }

                        if($data_row['adapter_ipad'] == "1"){
                            $adapter_ipad = '1 x Adapter';
                        }
                        else{
                            $adapter_ipad = '';
                        }

                        if($data_row['wire_ipad'] == "1"){
                            $wire_ipad = '1 x Wire';
                            $acc = '1 x Folio Case';
                        }
                        else{
                            $wire_ipad = '';
                        }
                        
                        $content .= '<tr>
                            <td class="border-table" ><br><font color="white">h</font><br>'.$i.'.<br><font color="white">h</font></td>
                            <td class="border-table" ><br><font color="white">h</font><br>'.$ipad.'<br><font color="white">h</font></td>
                            <td class="border-table" ><br><font color="white">h</font><br>'.strtoupper($data_row['serialNo_ipad']).'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.ucwords($data_row['rfidno_ipad']).'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$status_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$condition_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$dateregistered_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$box_ipad.'<br>'.$adapter_ipad.'<br>'.$wire_ipad.'<br>'.$acc.'<br><font color="white">h</font></td>';
                         
                         if($data_row['status_ipad'] == "1" || $data_row['status_ipad'] == "2"){
                                 $inv_mst = "SELECT ipad.*,owner.*,rental_return.*,department.*,users.*,rental.* FROM rental_return 
                                    INNER JOIN owner ON owner.ID_owner = rental_return.ID_owner 
                                    INNER JOIN ipad ON ipad.ID_ipad = rental_return.ID_ipad 
                                    INNER JOIN department ON department.ID_dept = owner.ID_dept
                                    INNER JOIN rental ON rental.ID_rental = rental_return.ID_rental
                                    INNER JOIN users ON owner.ID_users = users.ID_users 
                                    WHERE ipad.ID_ipad = '".$data_row['ID_ipad']."' ORDER BY rfidno_ipad ASC ";
                                  $inv_results = mysqli_query($dbconn_ipadManagement,$inv_mst);
                             
                              while($data_Users = mysqli_fetch_array($inv_results, MYSQLI_ASSOC)){ 
                                  
                                  $name_users = wordwrap(ucwords($data_Users['name_owner']),15,"<br>\n");
                                  $dept_users = wordwrap(ucwords($data_Users['name_dept']),10,"<br>\n");
                                  
                             $content .= '   
                                <td class="border-table"><br><font color="white">h</font><br>'.$name_users.'<br><font color="white">h</font><br></td>
                                <td class="border-table"><br><font color="white">h</font><br>'.$dept_users.'<br><font color="white">h</font></td>
                                <td class="border-table"><br><font color="white">h</font><br>'.$dateassigned.'<br><font color="white">h</font></td>
                                ';
                             }
                        }
                        else{
                             $content .= '   
                                <td class="border-table"><br><font color="white">h</font><br><br>X<br><font color="white">h</font><br></td>
                                <td class="border-table"><br><font color="white">h</font><br><br>X<br><font color="white">h</font></td>
                                <td class="border-table"><br><font color="white">h</font><br>'.$dateassigned.'<br><font color="white">h</font></td>
                                ';
                        }
                        
                         $content .= '   
                            
                        </tr>';
                        $i ++;
                    }
                    $content .= '</table>
                </td>
            </tr>
    </table>'; 
    
$pdf->writeHTML($content);

$file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
//$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

$datetime=date('dmY_hms');
$file_name = "List_".$_GET['action'].".pdf";
ob_end_clean();

if($_GET['ACTION']=='VIEW') 
{
	$pdf->Output($file_name, 'I'); // I means Inline view
} 
else if($_GET['ACTION']=='DOWNLOAD')
{
	$pdf->Output($file_name, 'D'); // D means download
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else if($_GET['ACTION']=='UPLOAD')
{
$pdf->Output($file_location.$file_name, 'F'); // F means upload PDF file on some folder
echo "Upload successfully!!";
}

//----- End Code for generate pdf
	
}
else
{
	echo '<img style="position: absolute;margin: auto;left: 0; right: 0;top: -50px;bottom: 0;" src="../../../system/images/no_pic.png" width="35%" > <a href="../../data/iPad/listiPad.php?status='.$_GET['action'].'" style="margin: 0;position: absolute;top: 70%;left:50%;transform: translateY(-50%);" class="btn btn-primary" >Back</a> ' ;
}

?>