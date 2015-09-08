<?php

class MyAmazon {

	// メンバ変数
	protected $Baseurl;
	protected $access_key_id;
	protected $secret_access_key;
	protected $associate_tag;
	protected $Service;
	public $Version;
	// コンストラクタ
	public function __construct($config){
		$this->setAccessKeyId($config['access_key_id']);
		$this->setSecretAccessKey($config['secret_access_key']);
		$this->setAssociateTag($config['associate_tag']);
		$this->Baseurl = 'http://ecs.amazonaws.jp/onca/xml';
		$this->Service ='AWSECommerceService';
		$this->Version='2011-08-01';
	}

	// アクセスキーセット
	public function setAccessKeyId($access_key_id) {
		$this->access_key_id = $access_key_id;
		return $this;
	}
	// アクセスキー取得
	public function getAccessKeyId() {
		return $this->access_key_id;
	}
	// シークレットアクセスキーセット
	public function setSecretAccessKey($secret_access_key) {
		$this->secret_access_key = $secret_access_key;
		return $this;
	}
	// シークレットアクセスキー取得
	public function getSecretAccessKey() {
		return $this->secret_access_key;
	}
	// アソシエイトタグセット
	public function setAssociateTag($associate_tag) {
		$this->associate_tag = $associate_tag;
		return $this;
	}
	// アソシエイトタグ取得
	public function getAssociateTag() {
		return $this->associate_tag;
	}

	// 「Timestamp」パラメータの時間を取得する
	public  function getTimeStamp() {
		return gmdate('Y-m-d\TH:i:s\Z');
	}


	// 商品検索
	public  function ItemSearch($params = array()){
		return $this->getUrl(
			array_merge(
				array('Operation'=>'ItemLookup'),$params));
	}

	public function getUrl($params = array()){
		return  $this->setUrl(
			array_merge(array(
				'Service' => $this->Service,
				'Version' => $this->Version,
				'AWSAccessKeyId' => $this->getAccessKeyId(),
				'Timestamp' => $this->getTimeStamp(),
				'AssociateTag' => $this->getAssociateTag()
			),$params));
	}

	protected  function setUrl($params = array()){

	    ksort($params);
	    //  canonical stringの作成
	    $canonical_string = '';
	    foreach ($params as $k => $v) {
	        $canonical_string .= '&'.$this->urlencode_rfc3986($k).'='.$this->urlencode_rfc3986($v);
	    }
	    $canonical_string = substr($canonical_string, 1);

	    $parsed_url = parse_url($this->Baseurl);
	    // HMAC-SHA256 を計算
	    $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
	    // BASE64 エンコード
	    $signature = base64_encode(hash_hmac('sha256', $string_to_sign,  $this->getSecretAccessKey(), true));
	    // リクエストURL作成、末尾に署名を追加
	    $url = $this->Baseurl.'?'.$canonical_string.'&Signature='.$this->urlencode_rfc3986($signature);


	    return $url;
	}

	// APIリクエスト
	public  function request($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$response = curl_exec($ch);
		curl_close($ch);

		return simplexml_load_String($response);//,'SimpleXMLElement',LIBXML_NOCDATA);
	}

	// RFC3986形式でURLエンコード
	public function urlencode_rfc3986($str) {
		return str_replace('%7E', '~', rawurlencode($str));
	}

}
?>