<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>Virtual Library REGISTER</title>
		<meta name="description" content="検索結果">
		<link rel="stylesheet" href="../../libcss.css">
		<link rel="stylesheet" href="../css/regicss.css">
		<script src="../../js/jquery-2.1.0.js" type="text/javascript"></script>
		<script src="../js/myjs2.js" type="text/javascript"></script>
		<link rel="shortcut icon" href="../../nikukyu.ico">
		<script>
			$(function(){
	   			$("dd").css("display","none");
		    	$("dl dt").click(function(){
        			if($("+dd",this).css("display")=="none"){
            			$("dd").slideUp();
			            $("+dd",this).slideDown();
    			    }
		        	else{
        		    	$("dd").slideUp();
			        }
    			});
			});
		</script>
	</head>

	<body>
		<div class="title">
			<div class="nikukyu"> 
				<h1>Virtual Library</h1>
				<h2>私的蔵書管理ツール <?php require("../../update_related/version.txt");?></h2>
			</div>
			<div class="nikukyu"><a href="../../canvas.html"><img src="../../nikukyu.gif" width="140" height="110"></a></div> 
			<IFRAME  class="inline_f" src="../../update_related/update_record.html" width=270 height=65 >
			</IFRAME>
			<div class="amazon_search"> 
				<SCRIPT charset="utf-8" type="text/javascript" src="http://ws-fe.amazon-adsystem.com/widgets/q?rt=tf_sw&ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fryoheipro-22%2F8002%2F3b8b2f5a-73f5-4f8a-8298-ee8f26c48dd4"> </SCRIPT> <NOSCRIPT><A HREF="http://ws-fe.amazon-adsystem.com/widgets/q?rt=tf_sw&ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fryoheipro-22%2F8002%2F3b8b2f5a-73f5-4f8a-8298-ee8f26c48dd4&Operation=NoScript">Amazon.co.jp ウィジェット</A></NOSCRIPT>
			</div>
		</div>

		<hr color="black" style="clear:both">

		<div class="box1">
			<p class="menu">Menu:</p>
			<ul>
				<li id="1"class="tab1off">本棚</li>
				<li id="2"class="tab2on">登録</li>
				<li id="3"class="tab3off">検索</li>
				<li id="4"class="tab4off">一覧</li>
				<li id="5"class="tab5off">貸出中</li>
				<li id="6"class="tab6off">借入中</li>
				<li id="7"class="tab7off">アプリ</li>
				<li id="8"class="tab8off">色々</li>
			</ul>
		</div>

		<?php

		if(isset($_POST['classification']) == null){
			echo "	<div id=\"box22\"class=\"contents\" style='height:50px'>
					<div style='width:32px;height:32px; float:left; margin-left:60px; background-image:url(../../hantei/failed.png);'></div><div style='margin-left:100px; margin-top:8px'>404 not found.</div></div>";
		}else{
			require_once '../../db/db_connection.php';

			if(isset($_POST['state']))
				$state = $_POST['state'];
			else 
				$state = null;
			$cl = $_POST['classification'];
			if(isset($_POST['comment']))
				$comment = $_POST['comment'];
			else 
				$comment = null;

			$bookID = $_POST['bookID'];

			//ユーザIDをどういう風に取得するかは未定
			$userID = '1';

			$sql = "select pID from possessions where userID='".$userID."' and bookID='".$bookID."'";
			$stmt = $dbh->query($sql);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			echo "<div id='box22'class='contents' style='height:65px'>
				<div id='check_regi' style='margin-left:60px;margin-bottom:0px'>
					<div id='regi_ok' style='width:32px;height:32px; background-image:url(../../hantei/ok.png);'></div>
					<p id='regi_ok_message' style='margin-left:10px'>書籍の情報を追加しました.</p>
					</div>";

			if($state == '自宅' || $state == '実家'){
				$stmt = $dbh->prepare("update possessions set state = :state, classification = :cl, comment = :comment where pID = '".$result['pID']."'");
				$stmt->execute(array(":state"=>$state,":cl"=>$cl,":comment"=>$comment));
				$dbh=null;
			}else{
				$stmt = $dbh->prepare("update possessions set state = :state, classification = :cl, comment = :comment where pID = '".$result['pID']."'");
				$stmt->execute(array(":state"=>$state,":cl"=>$cl,":comment"=>$comment));
				$dbh=null;
				if($state == '貸出中'){
					echo "<div style='width:20px;height:32px; float:left; margin-left:60px; background-image:url(../../hantei/denkyu.png);'></div><div>貸し出し中の書籍に関しては、上の「貸出中」タブから情報を追加・変更できます。</div>";
				}else if($state == '借入中'){
					echo "<div style='width:20px;height:32px; float:left; margin-left:60px; background-image:url(../../hantei/denkyu.png);'></div><div>借りている書籍に関しては、上の「借入中」タブから情報を追加・変更できます。</div>";
				}
			}

			echo "</div>";

		}
	?>

		<p><div class="copy">Copyright (c) 2014 Ryohei Takayama All Rights Reserved.</div></p>
	</body>