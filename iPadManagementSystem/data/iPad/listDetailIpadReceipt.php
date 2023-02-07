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


    if($_GET['action'] == "VIEWALL"){
        $id = '';
        $nameFile = 'LIST OF IPAD DETAILS ('.$AlliPad.' iPad) ';
    }

$i = '1';

$inv_mst_query = "SELECT ipad.*,Accesories_ipad.* FROM ipad 
INNER JOIN Accesories_ipad ON Accesories_ipad.ID_ipad = ipad.ID_ipad
ORDER BY ipad.rfidno_ipad ASC ";


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
                            <th width="15%" class="border-table" ><b><br><font color="white">h</font><br>Model</b></th>
                            <th width="15%" class="border-table" ><b><br><font color="white">h</font><br>Device</b></th>
                            <th width="11%" class="border-table" ><b><br><font color="white">h</font><br>Serial No.</b></th>
                            <th width="6%" class="border-table"><b><br><font color="white">h</font><br>RFID No.</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>Status</b></th>
                            <th width="5%" class="border-table"><b><br><font color="white">h</font><br>Cond.</b></th>
                            <th width="8%" class="border-table"><b><font color="white">h</font><br>Date <br>Registered</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>Box</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>Adapter</b></th>
                            <th width="7%" class="border-table"><b><br><font color="white">h</font><br>Wire</b></th>
                            <th width="8%" class="border-table"><b><font color="white">h</font><br>Other <br>Acc.</b><br><font color="white">h</font></th>
                        </tr></thead>';
                    while($data_row = mysqli_fetch_array($inv_mst_results, MYSQLI_ASSOC)){
                        $dateregistered_ipad = date('d F Y', strtotime($data_row['dateregistered_ipad']));
                        $ipad = wordwrap(ucwords($data_row['modelType_ipad']),24,"<br>\n");
                        $device = wordwrap(ucwords($data_row['assetType_ipad']),24,"<br>\n");
                        
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
                            $box_ipad = 'Include';
                        }
                        else{
                            $box_ipad = 'X';
                        }

                        if($data_row['adapter_ipad'] == "1"){
                            $adapter_ipad = 'Include';
                        }
                        else{
                            $adapter_ipad = 'X';
                        }

                        if($data_row['wire_ipad'] == "1"){
                            $wire_ipad = 'Include';
                        }
                        else{
                            $wire_ipad = '';
                        }
                        
                        if($data_row['accesories_ipad'] == "1"){
                            $acc = wordwrap(ucwords($data_row['name_accesories']),10,"<br>\n");
                        }
                        else{
                            $acc = 'X';
                        }
                        
                        $content .= '<tr>
                            <td class="border-table" ><br><font color="white">h</font><br>'.$i.'.<br><font color="white">h</font></td>
                            <td class="border-table" ><br><font color="white">h</font><br>'.$ipad.'<br><font color="white">h</font></td>
                            <td class="border-table" ><br><font color="white">h</font><br>'.$device.'<br><font color="white">h</font></td>
                            <td class="border-table" ><br><font color="white">h</font><br>'.strtoupper($data_row['serialNo_ipad']).'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.ucwords($data_row['rfidno_ipad']).'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$status_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$condition_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$dateregistered_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$box_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$adapter_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$wire_ipad.'<br><font color="white">h</font></td>
                            <td class="border-table"><br><font color="white">h</font><br>'.$acc.'<br><font color="white">h</font></td>
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
$file_name = "List_iPad_Details.pdf";
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