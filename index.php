<?php



	require_once 'dbconfig.php';

	

	if(isset($_GET['delete_id']))

	{

		// select image from db to delete

		$stmt_select = $DB_con->prepare('SELECT userPic FROM tbl_users WHERE userID =:uid');

		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));

		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);

		unlink("v3/".$imgRow['userPic']);

		

		// it will delete an actual record from db

		$stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE userID =:uid');

		$stmt_delete->bindParam(':uid',$_GET['delete_id']);

		$stmt_delete->execute();

		

		header("Location: delete.php");



	}



?>
<!DOCTYPE html>
<html lang="ar">
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
    <!-- الارشفة -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>مركز Aljne Up 3.0</title>

    <!-- كلاسات بوتستراب -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/bootstrap-rtl.min.css" rel="stylesheet">

    <!-- كلاسات القالب -->
    <link href="jumbotron-narrow.css" rel="stylesheet">
<link href="http://alamera.ga/styles.css" rel="stylesheet">

    <!-- بداية الجافا-->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- نهاية الجافا -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
<!-- بداية المحتوى -->
<? include ("style/nav.php"); ?>
      <div class="jumbotron">
        <h1 class="h2" align="right"><a class="btn btn-lg btn-success" href="add.php"> اضافة صورة جديدة <span class="glyphicon glyphicon-plus"></span></a></h1>
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

			<div class="alj1" align="center">

رقم الاي دي للصورة: <?php echo $row['userID']; ?>
<br/>
<a href="v3/<?php echo $row['userPic']; ?>"><img src="AljnetUp3/<?php echo $row['userPic']; ?>" class="img-thumbnail" alt="Aljnet Up 3.0.0" width="200" height="200"/></a>

<br>
<div class="a5"> من <font color="red"><?php echo $userName; ?></font> : [ <?php echo$userProfession; ?> ] 

 <a href="v3/<?php echo $row['userPic']; ?>"><button type="button" class="btn btn-xs btn-success">تنزيــل</button></a></div>

			</div>       

			<?php

		}

	}

	else

	{

		?>

        <div class="col-xs-12">

        	<div class="alert alert-warning">

            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; تم تنظيف السرفر تلقائيا وتم نقل الصور القديمه

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

    </div> <!-- /قفلة المحتوى -->


    <!-- جافا سكربت-->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
