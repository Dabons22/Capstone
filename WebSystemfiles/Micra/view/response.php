
<?php
	//include connection file 
	include_once("connection.php");
	 
	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	//define index of column
	$columns = array( 
		0 =>'reporteruserid', 
		1 => 'reportername',
		2 => 'reporttime',
		3 => 'reportdate',
		4 => 'reportcategory',
		5 => 'categorydescription',
		6 => 'reportdescription',
		7 => 'resolvestatus'
	);

	$where = $sqlTot = $sqlRec = "";

	// getting total number records without any search
	$sql = "SELECT reporteruserid,reportername,reporttime,reportdate,reportcategory,reportdescription,resolvestatus FROM   `tblemployees` WHERE resolvestatus='Finished'";
	$sqlTot .= $sql;
	$sqlRec .= $sql;


 	$sqlRec .=  " ORDER BY reportername";

	$queryTot = mysqli_query($conn, $sqlTot) or die("database error:". mysqli_error($conn));


	$totalRecords = mysqli_num_rows($queryTot);

	$queryRecords = mysqli_query($conn, $sqlRec) or die("error to fetch employees data");

	//iterate on results row and create new index array of data
	while( $row = mysqli_fetch_row($queryRecords) ) { 
		$data[] = $row;
	}	

	$json_data = array(
			"draw"            => 1,   
			"recordsTotal"    => intval( $totalRecords ),  
			"recordsFiltered" => intval($totalRecords),
			"data"            => $data   // total data array
			);

	echo json_encode($json_data);  // send data as json format
?>
	