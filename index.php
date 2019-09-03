<?php


class fpp{
    private $api_key ;
    private $api_secret ;
    private $image_base64 ;
    private $template_id ;
    private $url ;

    function __construct(){
        $this -> url = "https://api-cn.faceplusplus.com/cardpp/v1/templateocr";
        $this -> api_key = 'uoQ3DMDjZGCsiRGtLUFh7axbWkKVYHEX';
        $this -> api_secret = 'uK74EssodWB0hpnuMFDdaTM43hIC2mKH';
        $this -> template_id = '1566915080';
 
    }

    private function filetrans($image_file){
        $image_info = getimagesize($image_file);
        $base64_image_content = "data:{$image_info['mime']};base64," . chunk_split(base64_encode(file_get_contents($image_file)));
        //echo $base64_image_content;
        $this -> image_base64 = $base64_image_content ;
    }
    //post
    public function filepost($image_file){

        $this -> filetrans($image_file);

        $data = array (
            'api_key' => $this -> api_key,
            'api_secret' => $this -> api_secret,
            'image_base64' => $this -> image_base64,
            'template_id' => $this -> template_id
        );
        //var_dump($data);
        //初始化
        $ch = curl_init ();
        //各种项设置，网上参考而来，可以查看php手册，自己设置
        curl_setopt ( $ch, CURLOPT_URL, $this -> url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );//post方式
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $return = curl_exec ( $ch );
        //容错机制
        if($return === false){
            var_dump(curl_error($ch));
        }
        //curl_getinfo()获取各种运行中信息，便于调试 
        $info = curl_getinfo($ch);
        echo "执行时间".$info['total_time'].PHP_EOL;
        //释放
        curl_close ( $ch );
        return $return;
    }
}

$test1 = new fpp();
//图片路径
$file = '/Users/luojinyun/data/WWW/phptest/test.jpg';

$return = $test1 -> filepost($file);

print_r($return);

?>
