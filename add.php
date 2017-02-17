<?php



	error_reporting( ~E_NOTICE ); // avoid notice

	

	require_once 'dbconfig.php';

	

	if(isset($_POST['btnsave']))

	{

		$username = $_POST['user_name'];// user name

		$userjob = $_POST['user_job'];// user email

		

		$imgFile = $_FILES['user_image']['name'];

		$tmp_dir = $_FILES['user_image']['tmp_name'];

		$imgSize = $_FILES['user_image']['size'];

		

		

		if(empty($username)){

			$errMSG = "فضلا اكتب اسمك اولا";

		}

		else if(empty($userjob)){

			$errMSG = "فضلا اكتب وصف لصورتك لا يتجاوز 5 كلمات";

		}

		else if(empty($imgFile)){

			$errMSG = "لم تحدد صورة .";

		}

		else

		{

			$upload_dir = 'AljnetUp3/'; // upload directory

	

			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

		

			// valid image extensions

			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

		

			// rename uploading image

			$userpic = rand(000000,999999).".".$imgExt;

				

			// allow valid image file formats

			if(in_array($imgExt, $valid_extensions)){			

				// Check file size '5MB'

				if($imgSize < 5000000)				{

					move_uploaded_file($tmp_dir,$upload_dir.$userpic);

				}

				else{

					$errMSG = "الملف اكبر من 5 ميجا.";

				}

			}

			else{

				$errMSG = "الملفات المدعومة JPG, JPEG, PNG & GIF فقط";		

			}

		}

		

		

		// if no error occured, continue ....

		if(!isset($errMSG))

		{

			$stmt = $DB_con->prepare('INSERT INTO tbl_users(userName,userProfession,userPic) VALUES(:uname, :ujob, :upic)');

			$stmt->bindParam(':uname',$username);

			$stmt->bindParam(':ujob',$userjob);

			$stmt->bindParam(':upic',$userpic);

			

			if($stmt->execute())

			{

				$successMSG = "تم اضافة الصورة بنجاح";

				header("refresh:1;index.php"); // redirects image view page after 1 seconds.

			}

			else

			{

				$errMSG = "لم يتم الاضافة نأسف";

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

    <title>>رفع الصور</title>

    <!-- الكلاسات الاساسية -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/bootstrap-rtl.min.css" rel="stylesheet">

    <!-- الاستايلات الاحتياطية -->
    <link href="navbar.css" rel="stylesheet">

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
<br>
      <div class="jumbotron">
        <h1>اضف صوره جديدة الان</h1>
        <p><?php

	if(isset($errMSG)){

			?>

            <div class="alert alert-danger"  align="right">

            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>

            </div>

            <?php

	}

	else if(isset($successMSG)){

		?>

        <div class="alert alert-success" align="right">

              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>

        </div>

        <?php

	}

	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">


 <label class="a1">اسمگ</label>
ملاحظه: لن نرفع صورتك اذا لم نعرف من انت
 <input class="form-control" type="text" name="user_name" placeholder="الرجاء ادخال اسمگ فقط" value="<?php echo $username; ?>" />

    

  <label class="a3">ادخل وصف بسيط</label>
 <input class="form-control" type="text" name="user_job" placeholder="اختـر وصف يوضح الصورة" value="<?php echo $userjob; ?>" />
 <label class="a">اختر صورة من جهازگ</label>



<input class="btn btn-xm btn-default" type="file" name="user_image" accept="image/*" />

    
<br>
        <div colspan="2" align="right"><button type="submit" name="btnsave" class="btn btn-lg btn-primary">
 رفع الصورة

<span class="glyphicon glyphicon-save"></span>
        </button>

        </div>

    

</form>


</p>
        <p>
          <a class="" href="index.php" role="button">رجــــــــــــــوع &raquo;</a>
        </p>
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
