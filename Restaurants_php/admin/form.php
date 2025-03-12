<?php include("../adminsession.php");
if(isset($_POST['submit']))
{
	if($_FILES['uploaded_file']['tmp_name']!='')
	{
		
		$file = $_FILES['uploaded_file']['tmp_name'];
		$handle = fopen($file,"r");	
		$c=1;
		while($data = fgetcsv($handle))
		{
			$prodname = ucwords(trim(addslashes($data[0])));
			$unit_name = ucwords(trim(addslashes($data[1])));
			$enable = "enable";			
			$unitid = $cmn->getvalfield("m_unit","unitid","unit_name='$unit_name'");
						
			if($c!=1)
			{
				if($prodname !='')
				{
	            mysql_query("insert into m_product set prodname='$prodname',unitid='$unitid',product_type='finishgood',is_stokable='1',pcatid='10',
								enable='$enable',createdate='$createdate',ipaddress='$ipaddress',createdby='$loginid'");	
				}
				
			}
			$c++;
		}
		echo "<script>location='$pagename?action=$action</script>";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<form action="" method="post" enctype="multipart/form-data" >
    		<input type="file" name="uploaded_file"  />
            <br /> <br />

			<input type="submit" name="submit" value="save"  />
    </form> 
</body>
</html>