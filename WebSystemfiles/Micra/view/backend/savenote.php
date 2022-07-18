<? include('config.php');
	$user_id="0";
	$head = mysql_real_escape_string(strip_tags($_POST['hed']));
	if($head==NULL)
	{
		header("location:../index.php");
	}
	else
	{
		$content = mysql_real_escape_string($_POST['post']);
		$password = mysql_real_escape_string($_POST['pass']);
			
				 $t=time();
				$link=substr($head, 0 , 40);	
				$flink=str_replace(" ","_",$link."_".$t);
				$filename = preg_replace("/[^A-Za-z0-9_-]/", "",  $flink);
				
				
								
			
			$sql=mysql_query("INSERT INTO `tbl_post` (`user_id`, `head`, `con`,  `link`, `password`, `stat`) VALUES ('$user_id', '$head', '$content', '$filename',  '$password',  '2')");
header("location:../saved.php?id=$filename");	
			
} 


?>