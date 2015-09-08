<?php

$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];

$birthday = $year."-".$month."-".$day;

$youbi = date("l", strtotime($birthday));
if($birthday == NULL){
	echo '
	<script type="text/javascript">
		location.href="http://lib.ryohei-pro.com/nande";
	</script>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title> 曜日教えてくれるやつ </title>
</head>
<body>
	<h1><center>単に曜日教えてくれるやつ</center></h1>
	<p><center><?php echo htmlspecialchars($youbi); ?><center></p>
	<p><font size="1">ブラウザの戻るボタンで戻ってね</font></p>
</body>
</html>