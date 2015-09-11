<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>Virtual Library</title>
		<meta name="Virtual Library" content="私的蔵書管理ツール">
		<script src="js/jquery-2.1.0.js" type="text/javascript"></script>
		<script src="js/myjs.js" type="text/javascript"></script>
		<link rel="stylesheet" href="libcss.css">
		<link rel="shortcut icon" href="nikukyu.ico">
	</head>

	<body>
		<div class="title">
			<div class="nikukyu">
				<h1>Virtual Library</h1>
				<h2>私的蔵書管理システム <?php require("update_related/version.txt");?></h2>
			</div>
			<div class="nikukyu"><a href="canvas.html"><img src="nikukyu.gif" width="140" height="110"></a></div> 
			<div class="inline_f" width="270" height="65"><a href="update_related/update_record">更新履歴</a></div> 
			<!--<IFRAME class="inline_f" src="update_related/update_record.html" width=270 height=65 >
			</IFRAME> -->
 			<div class="amazon_search"> 
				<!--<script charset="utf-8" type="text/javascript">
					amzn_assoc_ad_type = "responsive_search_widget";
					amzn_assoc_tracking_id = "ryoheipro-22";
					amzn_assoc_marketplace = "amazon";
					amzn_assoc_region = "JP";
					amzn_assoc_placement = "";
					amzn_assoc_search_type = "search_widget";
					amzn_assoc_width = 250;
					amzn_assoc_height = 250;
					amzn_assoc_default_search_category = "";
					amzn_assoc_default_search_key = "";
					amzn_assoc_theme = "light";
					amzn_assoc_bg_color = "FFFFFF";
				</script>-->
				
				<SCRIPT charset="utf-8" type="text/javascript" src="http://ws-fe.amazon-adsystem.com/widgets/q?rt=tf_sw&ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fryoheipro-22%2F8002%2F3b8b2f5a-73f5-4f8a-8298-ee8f26c48dd4"> </SCRIPT> <NOSCRIPT><A HREF="http://ws-fe.amazon-adsystem.com/widgets/q?rt=tf_sw&ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fryoheipro-22%2F8002%2F3b8b2f5a-73f5-4f8a-8298-ee8f26c48dd4&Operation=NoScript">Amazon.co.jp ウィジェット</A></NOSCRIPT>
				<script src="//z-fe.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=JP"></script>
			</div>
		</div>

		<?php
			require_once 'db/db_connection.php';
		?>

		<hr color="black" style="clear:both">
		<div class="box1">
			<p class="menu">Menu:</p>
			<ul>
				<li id="1"class="tab1on">本棚</li>
				<li id="2"class="tab2off">登録</li>
				<li id="3"class="tab3off">検索</li>
				<li id="4"class="tab4off">一覧</li>
				<li id="5"class="tab5off">貸出中</li>
				<li id="6"class="tab6off">借入中</li>
				<li id="7"class="tab7off">アプリ</li>
				<li id="8"class="tab8off">色々</li>
			</ul>
		</div>

		<div id="box21"class="contents">
			<div id="main_books">
				<div id="bookshelf" style="width:563px;height:474px; background-image:url(hondana/wide.png);">
					<?php
						$sql = "select bookID from books limit 24";
						$stmt = $dbh->query($sql);
						$n = $stmt->rowCount();
						while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
							$sql = "select imageS from books where bookID='".$result['bookID']."'";
							$stmt1 = $dbh->query($sql);
							$image_url[] = $stmt1->fetch(PDO::FETCH_ASSOC);

							$sql = "select amazon from books where bookID='".$result['bookID']."'";
							$stmt1 = $dbh->query($sql);
							$amazon_url[] = $stmt1->fetch(PDO::FETCH_ASSOC);
						}

						if($n <= 6){
							for($i=0; $i < $n; $i++)
								echo "<a href='".$amazon_url[$i]['amazon']."'>
								<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_1' id='book".$i."'></a>";
						}else if($n > 6){
							if($n <= 12){
								for($i=0; $i < 6; $i++)	
									echo "<a href='".$amazon_url[$i]['amazon']."'>
									<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_1' id='book".$i."'></a>";
								for($i=6; $i < $n; $i++)
									echo "<a href='".$amazon_url[$i]['amazon']."'>
									<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_2' id='book".$i."'></a>";
							}else if($n > 12){
								if($n <= 18){
									for($i=0; $i < 6; $i++)	
										echo "<a href='".$amazon_url[$i]['amazon']."'>
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_1' id='book".$i."'></a>";
									for($i=6; $i < 12; $i++)
										echo "<a href='".$amazon_url[$i]['amazon']."'>
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_2' id='book".$i."'></a>";
									for($i=12; $i < $n; $i++)
										echo "<a href='".$amazon_url[$i]['amazon']."'>										
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_3' id='book".$i."'></a>";
								}else if($n > 18){
									for($i=0; $i < 6; $i++)	
										echo "<a href='".$amazon_url[$i]['amazon']."'>
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_1' id='book".$i."'></a>";
									for($i=6; $i < 12; $i++)
										echo "<a href='".$amazon_url[$i]['amazon']."'>
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_2' id='book".$i."'></a>";
									for($i=12; $i < 18; $i++)
										echo "<a href='".$amazon_url[$i]['amazon']."'>
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_3' id='book".$i."'></a>";
									for($i=18; $i < $n; $i++)
										echo "<a href='".$amazon_url[$i]['amazon']."'>
										<img src='".$image_url[$i]['imageS']."' width='65' height='85' title='book".$i."' class='books_row_4' id='book".$i."'></a>";
								}
							}
						}


					?>
				</div>
			</div>
			<div id="sub_menu">
				<div class="sub01">本を検索</div>
				<div class="sub02">
					<p style="font-size:8px">(未完成)</p>
					<p class="sub03">

						<form action="search.php" method="post">
							<input type="text" name="bookname" size="10" value="">
							<input type="submit" value="検索">
						</form>
					</p>
				</div>
				<div class="sub11">ジャンル別</div>
				<div class="sub12">
					<p style="font-size:8px">(未完成)</p>					
					<p class="sub13">
						<a href="">新書</a><br>
						<a href="">小説</a><br>
						<a href="">理工書</a><br>
						<a href="">雑誌</a><br>
						<a href="">英語</a></br>
					</p>
				</div>
				<div class="sub21">登録日別</div>
				<div class="sub22">
					<p style="font-size:8px">(未完成)</p>					
					<p class="sub23">
						<a href="">2014年3月</a><br>
						<a href="">2014年4月</a><br>
						<a href="">2014年5月</a><br>
					</p>
				</div>
			</div>
		</div>

		<div id="box22"class="contents">
			<dl style="	width:500px;">
				<dt class="regi_tab">ISBNで登録</dt>
					<dd style="height:150px;">
						<p style='font-size:11px'>ISBNをハイフン(-)無しで入力. ISBN以外の入力には対応していません.</p>
						<form action="register/" method="get">
							<p>ISBN：<input type="text" name="ISBN" size="20" maxlength="13" required></p>
							<p><input type="submit" value="検索" style="color:gray"></p>
						</form>
					</dd>
				<dt class="regi_tab">タイトルで登録</dt>
					<dd style="height:150px;">
						<p style='font-size:11px'>本のタイトルを入力.</p>
						<form action="register/bookname/" method="get">
							<p><input type="hidden" name="pg" value="1"></p>
							<p>title：<input type="text" name="bname" size="20" maxlength="255" required></p>
							<p><input type="submit" value="検索" style="color:gray"></p>
						</form>
					</dd>
				<dt class="regi_tab">著者名で登録</dt>
					<dd style="height:150px;">
						<p style='font-size:11px'>著者名を入力.</p>
						<form action="register/authorname/" method="get">
							<p><input type="hidden" name="pg" value="1"></p>
							<p>author：<input type="text" name="aname" size="20" maxlength="20" required></p>
							<p><input type="submit" value="検索" style="color:gray"></p>
						</form>
					</dd>
			</dl>
		</div>

		<div id="box23"class="contents">
			<p>検索するよ</p>
		</div>

		<div id="box24"class="contents">
			<p>一覧だよ</p>
			<p>table:users,books</p>
				<?php 
					$sql = "select * from users";
					$stmt = $dbh->query($sql);
					$num = $stmt->columnCount();
					$fields = array();

					//---テーブル作成--------------
					echo "<table border='1' id='users_all'><thead><tr>";
					for($i=0;$i<$num;$i++){
						$meta =	$stmt->getColumnMeta($i);
						$fields[$i] = $meta['name'];
						echo "<th>".$meta['name']."</th>";
					}
					echo"</tr></thead><tbody>";
					foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user){
						echo "<tr>";
						for($i=0;$i<$num;$i++){
							echo "<td>".$user[$fields[$i]]."</td>";
						}
						echo "</tr>";
					}
					echo "</tbody></table>";
					//---テーブル作成終了-------------

					echo "<div id='column_num'>";
					echo $dbh->query("select count(*) from users")->fetchColumn() . "records found";
					echo "</div><br>";

					$sql = "select * from books";
					$stmt = $dbh->query($sql);
					$num = $stmt->columnCount();
					$fields = array();

					//---テーブル作成--------------
					echo "<table border='1' id='books_all'><thead><tr>";
					for($i=0;$i<$num;$i++){
						$meta =	$stmt->getColumnMeta($i);
						$fields[$i] = $meta['name'];
						echo "<th>".$meta['name']."</th>";
					}
					echo"</tr></thead><tbody>";
					foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $book){
						echo "<tr>";
						for($i=0;$i<$num;$i++){
							echo "<td>".$book[$fields[$i]]."</td>";
						}
						echo "</tr>";
					}
					echo "</tbody></table>";
					//---テーブル作成終了-------------

					echo "<div id='column_num'>";
					echo $dbh->query("select count(*) from books")->fetchColumn() . "records found";
					echo "</div>";
					$dbh = null;
				?>
		</div>

		<div id="box25"class="contents">
			<p>貸し出し中の本たち</p>
		</div>

		<div id="box26"class="contents">
			<p>貸してもらっている本たち</p>
			

		</div>

		<div id="box27"class="contents">
			<div>
				<p id="app">連動アプリケーションの使い方</p>
				<p style="margin-left:30px">
					このサービスは自宅の書籍をweb上で管理することを目的として作られたものです。<br>
					書籍の本棚への登録はpcからブラウザを利用しても行うことができますが、基本的<br>
					にはスマートフォン用アプリを使用して行うことを想定しています。連動アプリで<br>
					書籍のバーコードを読み取り、それをサーバに送信することによって、システム内<br>
					部で本の情報が取得され、読み取った書籍がこのリブラリエの本棚に登録されます。<br>
					<br>
					また人に本を貸すとき、あるいは借りるときにも、アプリでピッとするだけで登録が<br>
					完了し、このシステム上でその状態を管理する事ができます。それら書籍の状態は、<br>
					上部「貸出中」あるいは「借入中」タブから確認する事ができます。<br>
					<br>
					私的仮想図書館として利用してください。<br>
				</p>
			</div>
			<div>
				<dl style="width:500px;">
					<dt style="background:#ff69b4;width:500px">for Android</dt>
					<dd style="height:200px;">coming soon...</dd>
					<dt style="background:#ff69b4;width:500px">for iOS</dt>
					<dd style="height:200px;">coming soon...</dd>
					<dt style="background:#ff69b4;width:500px">for Linux</dt>
					<dd style="height:200px;">coming soon...</dd>
				</dl>
			</div>
		</div>

		<div id="box28"class="contents">
			<dl style="width:800px">
				<dt style="background:#40e0d0;width:500px">参考にしたwebページなど</dt>
				<dd style="height:1000px;">・<a href="http://booklog.jp">booklog(ブクログ)</a><br>
					日本語サイトの中では、一番大きなやつ。<br>
					でも使ってみるとやっぱりちょっと違うなあ・・。<br>
					ということで、自分で作ることにしたのがこのPrivate Library.<br>
					まず広告がじゃま。そしてソーシャルで繋がるとかいらない。etc..<br>
					などの理由から、シンプルな書籍管理ツールを作りたい。<br>
					<br>
					・<a href="http://www.ajaxtower.jp/ecs/">Amazon webサービス入門</a><br>
					ここは正直コードとかを直接拝借するみたいなページではなかったけど、<br>
					それでもAWS関連とくにアマゾンAPI(Product Advertising API)の<br>
					基礎を眺めるのに役立ちました。<br>
					<br>
					・<a href="http://docs.aws.amazon.com/AWSECommerceService/latest/DG/Welcome.html">Developer Guide(API Version 2011-08-01)</a><br>
					これはProduct Advertising APIのディベロッパガイドで、細かいこと(apiを叩くときのパラメタとか)<br>
					が書いてあるページ。読んだのはItemSearchの部分だけだけど、これを読み込んだら強くなりそう。<br>
					ていうか、これの和訳とか需要あるんじゃないかな・・・。<br>
					<br>
					・<a href="http://blog.livedoor.jp/net_scope-diary/archives/922645.html">僕の私の備忘録</a><br>
					ここはさらっと見ただけだけど、APIについてわかりやすく解説されてて、少し和んだよいブログです。<br>
					<br>
					・<a href="http://www.netyasun.com/home/color.html">カラーコード一覧表</a><br>
					こういう細かいのも大事。<br>
					<br>
					・<a href="http://www.ctrlshift.net/jsonprettyprinter/">JSON整形サービス</a><br>
					これがやっぱり一番のエースでした。jsonが上手く解析できずに、手作業で階層に分けていたさなか、<br>
					このページと出会い、配列が一気に見通しよく掴めるようになった。これを作った人は本当にえらいと思う。<br>
					<br>
					・<a href="http://kachibito.net/web-design/border-image-generator.html">border-image-generator</a><br>
					細かい部分だけど、cssでborderをいじる時に最高に役に立った。とてもよいサイト<br>
					<br>
					・<a href="http://dotinstall.com">ドットインストール</a><br>
					全てはここから始まっていいと思う。最初の一歩として、とても役立った。<br>
					<br>
					・<a href="http://www.1uphp.com/con2/menu/tabmenu1.html">1up ホームページ作成</a><br>
					タブを作るときはここを参考にした。最終的にはjsとリンクを組み合わせてタブを作ることにした。<br>
					<br>
				</dd>
				<dt style="background:#40e0d0;width:500px">おまけ</dt>
				<dd><font size="1">1991-7-15 みたいな感じで入力.</font>
					<p>停止中</p>				
				</dd>
			</dl>
		</div>
		<p><div class="copy">Copyright (c) 2014 Ryohei Takayama All Rights Reserved.</div></p>
	</body>
</html>
