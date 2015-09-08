<?php
	try{
		$dbh = new PDO('mysql:host=mysql490.db.sakura.ne.jp;dbname=ryohei-takayama_lib_app;charset=utf8;','ryohei-takayama','rt_16022');
		} catch (PDOException $e) {
			var_dump($e->getMessage());
			exit;
		}
?>