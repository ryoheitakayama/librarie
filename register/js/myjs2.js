
window.onload =function(){
	/*def0 = "tab1on";
	suzi = 1;
	def0_r = "tab1off";*/
}

$(function (){
	//.box1の中のliタグがクリックされたときにfunctionの中身を実行
	$(".box1 li").click(function() {
		//何番目のliタグがクリックされたのか判定する. その値をnumに持っていてもらう
		var num = $(".box1 li").index(this);
		if(num==0){
			location.href="http://sample.librarie.jp/";
		}else if(num==1){
			location.href="http://sample.librarie.jp/#2";
		}else if(num==2){
			location.href="http://sample.librarie.jp/#3";
		}else if(num==3){
			location.href="http://sample.librarie.jp/#4";
		}else if(num==4){
			location.href="http://sample.librarie.jp/#5";
		}else if(num==5){
			location.href="http://sample.librarie.jp/#6";
		}else if(num==6){
			location.href="http://sample.librarie.jp/#7";
		}else if(num==7){
			location.href="http://sample.librarie.jp/#8";
		}
	});	
});