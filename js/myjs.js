
window.onload =function(){
	
}

$(function (){
	var hash = window.location.hash;
	hash = hash.split("?");
	hash = hash[0].split("#");
	var i = hash[1] - 0;

	def0 = "tab1on";
	suzi = 1;
	def0_r = "tab1off";

	if(1<i && i<9){
		$(".contents").css("display","none");
		$(".contents").eq(i-1).css("display","block");

		on = "tab"+i+"on";
		off = "tab"+i+"off";
		var id = "#"+i;
	
		$("#1").removeClass(def0);
		$(id).removeClass(off);
		$(id).addClass(on);
		$("#1").addClass(def0_r);

		def0 = on;
		def0_r = off;
		suzi = i;
	}else{
		$(".contents:gt(0)").css("display","none");
	}

	//.box1の中のliタグがクリックされたときにfunctionの中身を実行
	$(".box1 li").click(function() {
		//何番目のliタグがクリックされたのか判定する. その値をnumに持っていてもらう
		var num = $(".box1 li").index(this);
		if(num==0){
			//httpから書き始める
			location.href="http://sample.librarie.jp";
		}else{
			var state = "tab" + (num+1);
			var on = state + "on";
			var off = state + "off";
			id = "#" + suzi; 

			if(suzi != (num+1)){
				//前居たタブから[def0]を取る
				$(id).removeClass(def0);
				//クリックしたタグから[off]を取る
				$(this).removeClass(off);
				//クリックしたタグに[on]を付ける
				$(this).addClass(on);
				//前居たタグに[def0_r]を付ける
				$(id).addClass(def0_r);
			}
			//次回のクリックに備えて、変数を保存しておく
			def0 = on;
			def0_r = off;
			suzi = num+1;
		
			//一旦、.contentsのdivを全部非表示にする
			$(".contents").css("display","none");
			//さっき判定したnumの値を使用. num番目の.contentsを表示する. 
			$(".contents").eq(num).css("display","block");
		}
	});

	$(function(){
	    $("dd:not(:first)").css("display","none");
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
});