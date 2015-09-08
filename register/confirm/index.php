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

		if(isset($_POST['url']) == null){
			echo "	<div id=\"box22\"class=\"contents\" style='height:50px'>
					<div style='width:32px;height:32px; float:left; margin-left:60px; background-image:url(../../hantei/failed.png);'></div><div style='margin-left:100px; margin-top:8px'>404 not found.</div></div>";
		}else{
			require_once '../../db/db_connection.php';
			$url = $_POST['url'];
			$image_m = $_POST['image_m'];
			$image_s = $_POST['image_s'];
			$isbn = $_POST['isbn'];
			$bname = $_POST['bname'];
			$pdate = $_POST['pdate'];
			$author = $_POST['author'];
			$publisher = $_POST['publisher'];

			//ユーザIDをどういう風に取得するかは未定
			$userID = '1';

			$sql = "select * from books where ISBN='".$isbn."'";
			$stmt = $dbh->query($sql);
			$num = $stmt->rowCount();

			//その本がDBに登録されていなかった場合
			if($num == 0){
				$stmt = $dbh->prepare("insert into books values(null,:ISBN,:bookname,now(),:published,:author,:publisher,:imageM,:imageS,:amazon)");
				$stmt->execute(array(":ISBN"=>$isbn,":bookname"=>$bname,":published"=>$pdate,":author"=>$author,":publisher"=>$publisher,":imageM"=>$image_m,":imageS"=>$image_s,":amazon"=>$url));				

			}else {

			}

			$sql = "select bookID from books where ISBN='".$isbn."'";
			$stmt = $dbh->query($sql);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$sql = "select * from possessions where userID ='".$userID."' and bookID ='".$result['bookID']."'";
			$stmt = $dbh->query($sql);
			$num = $stmt->rowCount();

			if($num == 0){
				$stmt = $dbh->prepare("insert into possessions values(null,:userID,:bookID,current_date(),null,null,null,null)");
				$stmt->execute(array(":userID"=>$userID,":bookID"=>$result['bookID']));		
				$dbh = null;
				echo "	<div id='box22'class='contents' style='height:360px'>

						<div id='check_regi' style='margin-left:60px;margin-bottom:0px'>
						<div id='regi_ok' style='width:32px;height:32px; background-image:url(../../hantei/ok.png);'></div>
						<p id='regi_ok_message' style='margin-left:10px'>書籍を本棚に登録しました.</p>
						</div>
						<div style='float:left;'>
						<div class='b_image' style='margin-top:40px'><a href='".$url."'><img src='".$image_m."' title='book1'></a></div>
						<div class='b_contents'>
						<table>
						<tr><th>ISBN： </th><td>".$isbn."</td></tr>
						<tr><th>書名： </th><td>".$bname."</td></tr>
						<tr><th>出版日： </th><td>".$pdate."</td></tr>
						<tr><th>著者： </th><td>".$author."</td></tr>
						<tr><th>出版社： </th><td>".$publisher."</td></tr>
						</table></div></div>
						<div style='margin-top:40px'>
						<form action='../detail/' method='post'style='margin-left:500px'>
						<dl style='width:360px'>
						<dt style='background:#cc3300;'>情報を追加</dt>
						<dd>
						<table>
							<tr><th>状態： </th>
							<td>
								<label><input type='radio' name='state' value='自宅'>自宅</label>
								<label><input type='radio' name='state' value='実家'>実家</label>
								<label><input type='radio' name='state' value='貸出中'>貸出中</label>
								<label><input type='radio' name='state' value='借入中'>借入中</label>
							</td></tr>
							<tr><th>分類： </th>
							<td><select name='classification' required>
							<option value='未分類'>-----</option>
							<option value='文学・評論'>文学・評論</option>
							<option value='人文・思想'>人文・思想</option>
							<option value='社会・政治'>社会・政治</option>
							<option value='ノンフィクション'>ノンフィクション</option>
							<option value='歴史・地理'>歴史・地理</option>
							<option value='ビジネス・経済'>ビジネス・経済</option>
							<option value='投資・金融・会社経営'>投資・金融・会社経営</option>
							<option value='科学・テクノロジー'>科学・テクノロジー</option>
							<option value='医学・薬学・看護学・歯科学'>医学・薬学・看護学・歯科学</option>
							<option value='コンピュータ・IT'>コンピュータ・IT</option>
							<option value='アート・建築・デザイン'>アート・建築・デザイン</option>
							<option value='趣味・実用'>趣味・実用</option>
							<option value='スポーツ・アウトドア'>スポーツ・アウトドア</option>
							<option value='資格・検定・就職'>資格・検定・就職</option>
							<option value='暮らし・健康・子育て'>暮らし・健康・子育て</option>
							<option value='旅行ガイド・マップ'>旅行ガイド・マップ</option>
							<option value='語学・辞事典・年鑑'>語学・辞事典・年鑑</option>
							<option value='教育・学参・受験'>教育・学参・受験</option>
							<option value='絵本・児童書'>絵本・児童書</option>
							<option value='コミック・ラノベ・BL'>コミック・ラノベ・BL</option>
							<option value='タレント写真集'>タレント写真集</option>
							<option value='ゲーム攻略・ゲームブック'>ゲーム攻略・ゲームブック</option>
							<option value='エンターテインメント'>エンターテインメント</option>
							<option value='雑誌'>雑誌</option>
							<option value='楽譜・スコア・音楽書'>楽譜・スコア・音楽書</option>
							<option value='古書'>古書</option>
							<option value='アダルト'>アダルト</option>
							</select></td></tr>
							<tr><th>コメント： </th>
							<td><textarea name='comment' style='width:150px;height:40px'></textarea></td></tr>
						</table>
						<input type='hidden' name='bookID' value='".$result['bookID']."'>
						<input type='submit' value='追加' style='margin-left:60px;margin-top:20px;margin-bottom:30px;height:30px;width:100px'>
						</form>
						</dd>
						</dl>
						</div>
						</div>";		
			}else{
				echo "	<div id=\"box22\"class=\"contents\" style='height:50px'>
						<div style='width:32px;height:32px; float:left; margin-left:60px; background-image:url(../../hantei/failed.png);'></div><div style='margin-left:100px; margin-top:8px'>既に登録済みか、ISBNがundefinedな書籍です。</div>
						</div>";
				$dbh = null;
			}
		}
	?>

		<p><div class="copy">Copyright (c) 2014 Ryohei Takayama All Rights Reserved.</div></p>
	</body>