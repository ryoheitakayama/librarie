<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>Virtual Library REGISTER</title>
		<meta name="description" content="検索結果">
		<link rel="stylesheet" href="../libcss.css">
		<link rel="stylesheet" href="css/regicss.css">
		<script src="../js/jquery-2.1.0.js" type="text/javascript"></script>
		<script src="js/myjs2.js" type="text/javascript"></script>
		<link rel="shortcut icon" href="../nikukyu.ico">

	</head>

	<body>
		<div class="title">
			<div class="nikukyu"> 
				<h1>Virtual Library</h1>
				<h2>私的蔵書管理ツール <?php require("../update_related/version.txt");?></h2>
			</div>
			<div class="nikukyu"><a href="../canvas.html"><img src="../nikukyu.gif" width="140" height="110"></a></div> 
			<IFRAME  class="inline_f" src="../update_related/update_record.html" width=270 height=65 >
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

		if(isset($_GET['ISBN']) == 0 || $_GET['ISBN'] == null){
			echo "	<div id=\"box22\"class=\"contents\">
					<p>404 not found.</p></div>";
		}else{
			require_once '../amazon/amazon.php';
			$api=new MyAmazon(array(
				'access_key_id' =>'ここにアクセスキーが入る',
				'secret_access_key' =>'ここにシークレットアクセスキーが入る',
				'associate_tag' => 'ryoheipro-22'
			));

			$keyword = 'java';
			$isbn = $_GET['ISBN'];


			$url = $api->ItemSearch(array(
				'ResponseGroup' => 'Medium',
				'SearchIndex'=>'Books',
				'IdType'=>'ISBN',
				'ItemId'=>$isbn,
				'Keywords'=> $keyword,
				'ItemPage'=> '1'
			));
			$result= $api->request($url);
			$json = json_encode($result);
	//			echo $json;


	echo "	<div id=\"box22\"class=\"contents\">
				<p class=\"each_regi\">ISBNから登録</p>
				<script>
					var json = ".$json.";

					if(json.Items.Item == null){
						document.write (\"<div id='bname_search_results' style='margin-left:30px;'>\");
						document.write (\"<p>エラーコード: <br>\"+ json.Items.Request.Errors.Error.Code +\"</p>\");
						document.write (\"<p>エラーメッセージ: <br>\"+ json.Items.Request.Errors.Error.Message +\"</p></div>\");
					}else{
						var item = json.Items.Item;
						//kindle版も存在する可能性があるためitem[0]としておく
						if(item.length) item = item[0];
						//画像が存在しなかった場合のエラー処理
						if(item.ImageSets == null){
							var image_m = '../material/no_image_m.png';
							var image_s = '../material/no_image_s.png';
						}else{
							var imageset = item.ImageSets.ImageSet;
							if (imageset.length) imageset = imageset[0];
							var image_m = imageset.MediumImage.URL;
							var image_s = imageset.SmallImage.URL;
						}
						//	alert(json.Items.Item.ImageSets.ImageSet.MediumImage.URL);
						//		alert(json.Items.Item.ItemAttributes.Title);
						document.write (\"<div id='bname_search_results'><div class='each_b_results'>\");
						document.write (\"<div class='b_image'><a href='\"+ item.DetailPageURL +\"'><img src='\" + image_m + \"' title='book1'></a></div>\");
						document.write (\"<div class='b_contents'><table><tr><th>ISBN : </th><td>\" + item.ItemAttributes.EAN + \"</td></tr>\");
						document.write (\"<tr><th>書名 : </th><td>\" + item.ItemAttributes.Title + \"</td></tr>\");
						document.write (\"<tr><th>出版日 : </th><td>\" + item.ItemAttributes.PublicationDate + \"</td></tr>\");
						document.write (\"<tr><th>著者 : </th><td>\" + item.ItemAttributes.Author + \"</td></tr>\");
						document.write (\"<tr><th>出版社 : </th><td>\" + item.ItemAttributes.Publisher + \"</td></tr>\");
						document.write (\"</table><p><a href=' \" + item.DetailPageURL + \"'>Amazon URL</a></p></div>\");
						document.write (\"<div class='b_register'>\
							<form action='confirm/'' method='post'>\
								<input type='hidden' name='url' value='\"+ item.DetailPageURL +\"'>\
								<input type='hidden' name='image_m' value='\"+ image_m +\"'>\
								<input type='hidden' name='image_s' value='\"+ image_s +\"'>\
								<input type='hidden' name='isbn' value='\"+ item.ItemAttributes.EAN +\"'>\
								<input type='hidden' name='bname' value='\"+ item.ItemAttributes.Title +\"'>\
								<input type='hidden' name='pdate' value='\"+ item.ItemAttributes.PublicationDate +\"'>\
								<input type='hidden' name='author' value='\"+ item.ItemAttributes.Author +\"'>\
								<input type='hidden' name='publisher' value='\"+ item.ItemAttributes.Publisher +\"'>\
								<input type='submit' value='登録する'></form>\
								</div>\");
						document.write (\"</div></div>\");
					}
				</script>
			</div>";
		}
	?>

		<p><div class="copy">Copyright (c) 2014 Ryohei Takayama All Rights Reserved.</div></p>
	</body>