<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'dbconfig.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT userName, userProfession, userPic FROM tbl_users WHERE userID =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: admin.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$username = $_POST['user_name'];// user name
		$userjob = $_POST['user_job'];// user email
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'AljnetUp3/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(000000,999900).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['userPic']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "الصورة اكبر من 5MB";
				}
			}
			else
			{
				$errMSG = "الملفات المدعومة JPG, JPEG, PNG & GIF ";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['userPic']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE tbl_users 
									     SET userName=:uname, 
										     userProfession=:ujob, 
										     userPic=:upic 
								       WHERE userID=:uid');
			$stmt->bindParam(':uname',$username);
			$stmt->bindParam(':ujob',$userjob);
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('شكرا تم تحديث الصورة');
				window.location.href='admin.php';
				</script>
                <?php
			}
			else{
				$errMSG = "ربما لا يتوفر مساحه كافيه قم بمراسلة المدير!";
			}
		
		}
		
						
	}
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>>تعديل الصوره</title>

    <!-- الكلاسات الاساسية -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/bootstrap-rtl.min.css" rel="stylesheet">

    <!-- الاستايلات الاحتياطية -->
    <link href="css/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <!-- المحتوئ -->
<? include ("style/nav.php"); ?>
      <div class="jumbotron">
        <h1>	<h1 class="h2"><a class="btn btn-default" href="admin.php"> كل الصور </a></h1> </h1>
        <p><form method="post" enctype="multipart/form-data" class="form-horizontal" align="right">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
	
<label class="alj1right"><font color="red">الاسم الحالي </font> <?php echo $userName; ?> </label>
        <input class="form-control" align="center" type="text" name="user_name" value="" required />
    
    
   <label class="alj1right"><font color="green">الوصف الحالي </font> <br> <?php echo $userProfession; ?> </label>
       <input class="form-control" align="center" type="text" name="user_job" value="" required />
    
    <label class="alj1right"><font color="blue">الصورة الحاليــة</font></label>
        	<p align="right"><img src="user_images/<?php echo $userPic; ?>" height="100" width="100" /></p>
<label class="alj1right"><font color="maroon">تغيير الصورة</font></label>
        	<input class="btn btn-xm btn-default" type="file" name="user_image" accept="image/*" /> <br>
        <div colspan="2" align="center"><button type="submit" name="btn_save_updates" class="btn btn-default">
تحديث 
        <span class="glyphicon glyphicon-save"></span>
        </button>
        
        <a class="btn btn-default" href="index.php">
 عودة <span class="glyphicon glyphicon-backward"></span></a>
        
        </div>
    
</form></p>
      </div>

    </div> <!-- /container -->

<? include ("style/footer.php"); ?>
    <!-- جافا سكربت
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
