<?php
$api = 'http://api.weibo.com/2/short_url/shorten.json'; // json
// $api = 'http://api.t.sina.com.cn/short_url/shorten.xml'; // xml

$source = '2849184197';     //iPad新浪客户端App Key：2849184197
//服务器网页版
//$url_long = 'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']).'/item.php?item_id='.$_GET['item_id'];  //根据服务器路径改写前半段

//百度翻译版
// $url_long = 'http://fanyi.baidu.com/?aldtype=16047#cht/zh/%EF%BF%A5'.$_GET['item_id'].'%EF%BF%A5%E7%82%B9%E5%87%BB%E5%8F%B3%E4%B8%8B%E8%A7%92%E5%A4%8D%E5%88%B6%E6%B7%98%E5%8F%A3%E4%BB%A4%E2%86%98';

//百度翻译网页版---直接调用翻译网页的URL
$url_item = 'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']).'/item.php?item_id='.$_GET['item_id'];  //自动获取服务器路径，并根据get的item_id生成商品链接
$url_baidu = 'http://fanyi.baidu.com/transpage?query='.urlencode($url_item).'&from=en&to=zh&source=url&render=1';//调用百度翻译网页翻译的url，将原商品链接编码后传给百度翻译接口，防止商品url中的参数被识别成百度翻译参数的问题
if($_GET['baidu'] == 0){
	$url_long = $url_item;	//若不选择百度翻译则长链接为商品链接
}else {
	$url_long = $url_baidu;	//若选择百度翻译则长链接为翻译链接
}

//由于之前的网址中含有#号，在短链接转换时会被当成参数，因此需要将链接先进行编码，再传给新浪短链接转换的接口
$url_long = urlencode($url_long);

$request_url = sprintf($api.'?source=%s&url_long=%s', $source, $url_long);
$data = file_get_contents($request_url);	//打开网页URL获得网页内容，返回字符串，内容为微博短链接api返回的json格式
echo $data;
?>

