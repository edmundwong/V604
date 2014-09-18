<?php

header("content-Type: text/html; charset=GBK");
$o_water = new WaterPic();
$o_water->destination = "./download/2013092112235910.JPG";
$o_water->doDeal();
$o_water->destination = "./download/20130826085921483.jpg";
$o_water->doDeal();
$o_water->destination = "./download/20130826085923854.jpg";
$o_water->doDeal();

class WaterPic {

    //上传文件类型列表
    public $uptypes = array(
        'jpg',
        'jpeg',
        'png',
        'pjpeg',
        'gif',
        'bmp'
    );
    //上传文件大小限制, 单位BYTE
    public $max_file_size = 2000000;
    //文件路径
    public $destination = "./download/";
    //是否附加水印(1为加水印,其他为不加水印);
    public $watermark = 1;
    //水印类型(1为文字,2为图片)
    public $watertype = 1;
    //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
    public $waterposition = 1;
    //水印字符串
    public $waterstring = "水印";
    //水印图片
    public $waterimg = "xplore.gif";

    function __constructs() {
        
    }

    function doDeal() {
        $pinfo = pathinfo($this->destination);

        $this->waterstring = iconv("GB2312", "UTF-8", $this->waterstring);

        //检查文件大小
        if ($this->max_file_size < filesize($this->destination)) {
            echo "文件太大!";
            exit;
        }

        //检查文件类型
        if (!in_array(strtolower($pinfo['extension']), $this->uptypes)) {
            echo "文件类型不符!"; //.$file["type"];
            exit;
        }

        $image_size = getimagesize($this->destination);
        $iinfo = getimagesize($this->destination, $iinfo);

        $nimage = imagecreatetruecolor($image_size[0], $image_size[1]);

        $white = imagecolorallocate($nimage, 255, 255, 255);
        $black = imagecolorallocate($nimage, 0, 0, 0);
        $red = imagecolorallocate($nimage, 255, 0, 0);
        //$o_color_site = imagecolorallocate($nimage,254,82,0);
        $o_color_site = imagecolorallocate($nimage, 221, 100, 48);

        //imagefill($nimage,0,0,$o_color_site);

        switch ($iinfo[2]) {
            case 1:
                $simage = imagecreatefromgif($this->destination);
                break;
            case 2:
                $simage = imagecreatefromjpeg($this->destination);
                break;
            case 3:
                $simage = imagecreatefrompng($this->destination);
                break;
            case 6:
                $simage = imagecreatefromwbmp($this->destination);
                break;
            default:
                die("不支持的文件类型");
                exit;
        }

        imagecopy($nimage, $simage, 0, 0, 0, 0, $image_size[0], $image_size[1]);
        imagefilledrectangle($nimage, $image_size[0] - 310, $image_size[1] - 20, $image_size[0] - 10, $image_size[1] - 12, $o_color_site);

        switch ($this->watertype) {
            case 1:   //加水印字符串
                imagettftext($nimage, 12, 0, 10, $image_size[1] - 1, $black, "C:/WINDOWS/Fonts/simsun.ttc", $this->waterstring); //字体设置
                break;
            case 2:   //加水印图片
                $simage1 = imagecreatefromgif("xplore.gif");
                imagecopy($nimage, $simage1, 0, 0, 0, 0, 85, 15);
                imagedestroy($simage1);
                break;
        }

        switch ($iinfo[2]) {
            case 1:
                imagegif($nimage, $this->destination);
                //imagejpeg($nimage, $destination);
                break;
            case 2:
                imagejpeg($nimage, $this->destination);
                break;
            case 3:
                imagepng($nimage, $this->destination);
                break;
            case 6:
                imagewbmp($nimage, $this->destination);
                //imagejpeg($nimage, $destination);
                break;
        }
        //覆盖原上传文件
        imagedestroy($nimage);
        imagedestroy($simage);
    }

}

?>