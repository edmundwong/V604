<?php
 
class resizeimage
{
        var $type;
        var $width;
        var $height;
        var $resize_width;
        var $resize_height;
        var $cut;
        var $srcimg;
        var $dstimg;
        var $im;

        function resizeimage($img,$smallFile, $wid, $hei,$c){
                $this->srcimg = $img;
                $this->resize_width = $wid;
                $this->resize_height = $hei;
                $this->dstimg = $smallFile;
                $this->cut = $c;
                $this->type = substr(strrchr($this->srcimg,"."),1);
                $this->initi_img();
                $this -> dst_img();
                $this->width = imagesx($this->im);
                $this->height = imagesy($this->im);
                $this->newimg();
                ImageDestroy ($this->im);
        }
        
        function newimg(){
            $resize_ratio = ($this->resize_width)/($this->resize_height);
            $ratio = ($this->width)/($this->height);
            if(($this->cut)=="1"){
                    if($ratio>=$resize_ratio){
                            $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
                            imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
                            ImageJpeg ($newimg,$this->dstimg);
                    }
                    if($ratio<$resize_ratio){
                            $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
                            imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));

                            ImageJpeg ($newimg,$this->dstimg);
                    }
            }
            else
            {
                    if($ratio>=$resize_ratio)
                    {
                            $newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
                            imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
                            ImageJpeg ($newimg,$this->dstimg);
                    }
                    if($ratio<$resize_ratio)
                    {
                            $newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
                            imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
                            ImageJpeg ($newimg,$this->dstimg);
                    }
            }
        }
        function initi_img()
        {
                if($this->type=="jpg" || $this->type=="jpeg")
                {
                        $this->im = imagecreatefromjpeg($this->srcimg);
                }
                if($this->type=="gif")
                {
                        $this->im = imagecreatefromgif($this->srcimg);
                }
                if($this->type=="png")
                {
                        $this->im = imagecreatefrompng($this->srcimg);
                }
        }

        function dst_img()
        {
                $full_length  = strlen($this->srcimg);
                $type_length  = strlen($this->type);
                $name_length  = $full_length-$type_length;
				$length_1	  = strrpos($this->srcimg, "/");
				$length_2	  = substr($this->srcimg, 0, $length_1);
				$length_3	  = substr($this->srcimg, $length_1+1);
				$length_3	  = substr($length_3, 0, strrpos($length_3, "."));
        }
}
?>