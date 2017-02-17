<?php



	require_once 'dbconfig.php';

	

	if(isset($_GET['delete_id']))

	{

		// select image from db to delete

		$stmt_select = $DB_con->prepare('SELECT userPic FROM tbl_users WHERE userID =:uid');

		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));

		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);

		unlink("http://aboud.aljup.ga/AljnetUp3/".$imgRow['userPic']);

		

		// it will delete an actual record from db

		$stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE userID =:uid');

		$stmt_delete->bindParam(':uid',$_GET['delete_id']);

		$stmt_delete->execute();

		

		header("Location: index.php");



	}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="identifier-url" content="http://d-groups.ga/alamera" />
<meta name="title" content="سكربت aljnet up" />
<meta name="description" content="شبكة واب العرب المجانية تماما" />
<meta name="abstract" content="شبكة واب العرب المجانية تماما" />
<meta name="keywords" content="واب,العرب,موقع مجاني,مركز تحميل,اكواد وابكا" />
<meta name="author" content="شبكه واب العرب المتخصصه والمجانيه" />
<meta name="revisit-after" content="15" />
<meta name="language" content="ar" />
<meta name="copyright" content="© 2016 aljailane" />
<meta name="robots" content="All" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>مركز Aljne Up 3.0</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/bootstrap-rtl.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">
<link href="http://alamera.ga/styles.css" rel="stylesheet">

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
<!-- صفحة النقل -->
<? include ("style/nav.php"); ?>
      <div class="jumbotron">
        <h1 class="h2" align="right"><a class="btn btn-lg btn-success" href="add.php">ترقية المركز لاحدث اصدار</a></h1>
لاداعي للترقيه لديك احدث اصدار ( v3.0.0 )
		<hr/>
        <p class="lead"><?php

	

	$stmt = $DB_con->prepare('SELECT userID, userName, userProfession, userPic FROM tbl_users ORDER BY userID DESC');

	$stmt->execute();

	

	if($stmt->rowCount() > 0)

	{

		while($row=$stmt->fetch(PDO::FETCH_ASSOC))

		{

			extract($row);

			?>

			
			<div class="a5" align="right">

				<p class="aljailane4">
 <button type="button" class="btn btn-xs btn-primary"><?php echo $userName; ?></button> <button type="button" class="btn btn-xs btn-warning"><?php echo $row['userID']; ?></button>

<br>
الوصف 
<font color="green"><?php echo$userProfession; ?></font></p>



<table width="100%" border="0"> <tr> <td width="50%" class="alj1" align="center"> 

<a href="/AljnetUp3/<?php echo $row['userPic']; ?>"><img src="/AljnetUp3/<?php echo $row['userPic']; ?>" class="img-circle" alt="Cinque Terre" width="100" height="90"/></a>

</td>
 <td width="50%" class="alj1" align="center">
 <a href="/AljnetUp3/<?php echo $row['userPic']; ?>"><button type="button" class="btn btn-xs btn-success">تنزيــل</button></a>
 <a class="btn btn-xs btn-danger" href="/?delete_id=<?php echo $row['userID']; ?>" title="اضغط للحذف" onclick="return confirm('هل تريد حذف الصورة ?')">حذف</a>
<a class="btn btn-xs btn-info" href="/editform.php?edit_id=<?php echo $row['userID']; ?>" title="اضغط للتحرير" onclick="return confirm('هل تريد تعديل الصورة ?')">تعديل</a>
</td>
</tr>
     

</tr></table> 

			</div>   

			<?php

		}

	}

	else

	{

		?>

        <div class="col-xs-12">

        	<div class="alert alert-warning">

            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; تم تنظيف السرفر من مخلفات الصور القديمه

            </div>

        </div>

        <?php

	}

	

?></p>
      </div>
<? include ("style/footer.php"); ?>
      <footer class="footer">
       <p>تصميم وبرمجة: محمد الجيلاني ( عہأشہق ٱلـورد )</p>
        <p>&copy; 2016 - 2017</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
