<?php
//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=Daily_report_".date("d-m-Y",strtotime($date)).".xls");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>PHPExcel Reader Example #01</title>

</head>
<body>
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');
include 'PHPExcel/IOFactory.php';
$inputFileName = $_SERVER["DOCUMENT_ROOT"].'/ays/file/ays.xls';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//echo "<pre>";
//print_r($sheetData);
echo "<table border='1'>";
for($i=1;$i<sizeof($sheetData);$i++){
	echo "<tr>";
	echo "<td>".$sheetData[$i]['A']."</td>";
	echo "<td>".$sheetData[$i]['B']."</td>";
	echo "<td>".$sheetData[$i]['C']."</td>";
	echo "<td>".$sheetData[$i]['D']."</td>";
	echo "<td>".$sheetData[$i]['E']."</td>";
	echo "<td>".$sheetData[$i]['F']."</td>";
	echo "<td>".$sheetData[$i]['G']."</td>";
	echo "<td>".$sheetData[$i]['H']."</td>";
	echo "<td>".$sheetData[$i]['I']."</td>";
	echo "<td>".$sheetData[$i]['J']."</td>";
	echo "<td>".$sheetData[$i]['K']."</td>";
	echo "<td>".$sheetData[$i]['L']."</td>";
	echo "<td>".$sheetData[$i]['M']."</td>";
	echo "<td>".$sheetData[$i]['N']."</td>";
	echo "<td>".$sheetData[$i]['O']."</td>";
	echo "<td>".$sheetData[$i]['P']."</td>";
	echo "</tr>";
}
echo "</table>";

?>
<body>
</html>