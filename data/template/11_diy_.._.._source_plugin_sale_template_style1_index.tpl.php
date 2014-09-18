<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template("sale:$style/header");?><link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/service.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/fenleiguanggao.css" />
<style type="text/css">
    /*.list .xinxi a{
        float:right;
        margin-right:120px;
        color:#797979
    }*/
    .list .xinxi p{
        float:left;
        width: 350px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    p a{
        color:#797979
    }
    .tuijian h3,.tuijian span{
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: inline-block;
        margin:0px 0 !important;
    }
    .news li{
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<article class="clearfix" style="background:#fff;">
    <div class="wrapper">
        <section>
            <h2 class="clearfix" style="">
                <span style=" line-height:42px; padding-left:6px; font-size:18px; font-weight:bold; color:#3d3d45; border-left:5px solid #fc6328;">分类广告类别</span>
                <a href="sale.php?mod=member&amp;step=check" style="color:#fc6328; font-size:14px; float:right; margin:10px 5px 5px 5px;">管理我的信息</a>
                <a href="/info.php?mod=member&amp;op=post" style="color:#fff;background:#fc6328; margin:4px;margin-top:8px; font-size:14px; float:right; padding:5px;line-height:15px">发布服务信息</a>
                <a href="<?php echo $sale_config['root'];?>?mod=choclass" style=" color:#fff; background:#8cc152; font-size:14px; float:right; margin:8px; padding:5px;line-height:15px">免费发布信息</a></h2>
            <table border="1" class="navigation">
                <tr>
                    <td>
                        <strong>二手物品/求购信息</strong>
                        <ul>
                            <?php if(is_array($cat_array)) foreach($cat_array as $cat) { ?>                                <?php if($cat['cat_pid'] == 1) { ?>
                                    <?php $s_keyword_tmp = '';?>                                    <?php $s_class_tmp = '';?>                                    <?php if($keyword ) { ?>
                                        <?php $s_keyword_tmp = '&keyword='.$keyword;?>                                    <?php } ?>
                                    <?php if($cat['cat_id'] == $cat_id) { ?>
                                        <?php $s_class_tmp = 'class="hover"';?>                                    <?php } ?>
                            <li><a href="<?php echo $sale_config['root'];?>?mod=index&upid=<?php echo $upid;?>&level=<?php echo $level;?>&cat_id=<?php echo $cat['cat_id'];?><?php echo $s_keyword_tmp;?>" <?php echo $s_class_tmp;?>><?php echo $cat['cat_title'];?></a><span class='line'>&nbsp;|</span></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </td>
                    <td>
                        <strong>房屋信息</strong>
                        <ul>
                            <?php if(is_array($cat_array)) foreach($cat_array as $cat) { ?>                            <?php if($cat['cat_pid'] == 16) { ?>
                                <?php $s_keyword_tmp = '';?>                                <?php $s_class_tmp = '';?>                                <?php if($keyword ) { ?>
                                    <?php $s_keyword_tmp = '&keyword='.$keyword;?>                                <?php } ?>
                                <?php if($cat['cat_id'] == $cat_id) { ?>
                                    <?php $s_class_tmp = 'class="hover"';?>                                <?php } ?>
                            <li><a href="<?php echo $sale_config['root'];?>?mod=index&upid=<?php echo $upid;?>&level=<?php echo $level;?>&cat_id=<?php echo $cat['cat_id'];?><?php echo $s_keyword_tmp;?>" <?php echo $s_class_tmp;?>><?php echo $cat['cat_title'];?></a><span class='line'>&nbsp;|</span></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </td>
                    <td>
                        <strong>求职/招聘</strong>
                        <ul>
                            <?php if(is_array($cat_array)) foreach($cat_array as $cat) { ?>                            <?php if($cat['cat_pid'] == 21) { ?>
                                <?php $s_keyword_tmp = '';?>                                    <?php $s_class_tmp = '';?>                                    <?php if($keyword ) { ?>
                                        <?php $s_keyword_tmp = '&keyword='.$keyword;?>                                    <?php } ?>
                                    <?php if($cat['cat_id'] == $cat_id) { ?>
                                        <?php $s_class_tmp = 'class="hover"';?>                                    <?php } ?>
                            <li><a href="<?php echo $sale_config['root'];?>?mod=index&upid=<?php echo $upid;?>&level=<?php echo $level;?>&cat_id=<?php echo $cat['cat_id'];?><?php echo $s_keyword_tmp;?>" <?php echo $s_class_tmp;?>><?php echo $cat['cat_title'];?></a><span class='line'>&nbsp;|</span></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </td>
                    <td>
                        <strong>其他个人信息</strong>
                        <ul>
                            <?php if(is_array($cat_array)) foreach($cat_array as $cat) { ?>                            <?php if($cat['cat_pid'] == 36) { ?>
                                <?php $s_keyword_tmp = '';?>                                    <?php $s_class_tmp = '';?>                                    <?php if($keyword ) { ?>
                                        <?php $s_keyword_tmp = '&keyword='.$keyword;?>                                    <?php } ?>
                                    <?php if($cat['cat_id'] == $cat_id) { ?>
                                        <?php $s_class_tmp = 'class="hover"';?>                                    <?php } ?>
                            <li><a href="<?php echo $sale_config['root'];?>?mod=index&upid=<?php echo $upid;?>&level=<?php echo $level;?>&cat_id=<?php echo $cat['cat_id'];?><?php echo $s_keyword_tmp;?>" <?php echo $s_class_tmp;?>><?php echo $cat['cat_title'];?></a><span class='line'>&nbsp;|</span></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </section>
        <section class="left v604_fl">
            <div class="top_left clearfix">
                <form action="sale.php" method="post" name="">
                    <ul class="guanggao">
                        <li><a style="background:#fc6328; color:#fff;" href="#">分类广告</a></li><li><a style="background:#efe6e0;color:#000;" href="#">活动/讲座</a></li>
                        <li style="float:right;margin-top:7px">
                            <input type="submit" value="搜索" name="" style="width:50px;height:30px;background:#fc6328;color:#fff;text-align:center;font-size: 14px;margin-left:-2px;"/>
                        </li>
                        <!--<li style="float:right;margin-top:7px"><select><option value ="1">有图片</option></select></li>-->
                        <li style="float:right;margin-top:7px">
                            <select>
                                <option value ="">请选择地区</option>
                                <option value="West Vancouver">West Vancouver</option><option value="White Rock">White Rock</option><option value="Surrey">Surrey</option><option value="Langley">Langley</option><option value="Delta">Delta</option><option value="North Vancouver">North Vancouver</option><option value="West Vancouver">West Vancouver</option><option value="Vancouver">Vancouver</option><option value="Richmond">Richmond</option><option value="New Westminster">New Westminster</option><option value="Coquitlam">Coquitlam</option><option value="Burnaby">Burnaby</option>
                            </select>
                        </li>
                        <li style="float:right;margin-top:7px">
                            <select>
                                <option value ="">请选择类目</option>
                                <?php if(is_array($cat_array)) foreach($cat_array as $cat) { ?>                                <?php if($cat['cat_pid'] != 0) { ?>
                                <option value ="<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_title'];?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </li>
                        <li style="float:right;margin-top:7px">
                            <input type="text" onclick="if(this.value=='标题/描述') this.value='';" value="" name="title" placeholder="请输入关键字;" style="border:1px solid #fc6328;border-right:1px solid #b4b4b4;height:22px;width:150px;"/>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="list_title">
                <em>全部信息</em>
                <em class="v604_fr">发布时间</em><span class="v604_fr" style="margin-right:90px;">电话</span>
            </div>
            <ul class="list">
                <?php if(is_array($goods_list)) foreach($goods_list as $goods) { ?>                <li class="clearfix">
                    <div class="img">
                        <a href="<?php echo $sale_config['root'];?>?mod=view&goods_id=<?php echo $goods['goods_id'];?>" style="float:left; padding-right:20px;" target="_blank">
                            <?php if($goods['goods_upload_file_1']) { ?>
                            <img src="<?php echo $goods['goods_upload_file_1'];?>" width="100" height="100" />
                            <?php } else { ?>
                            <img src="<?php echo $sale_config['sale'];?>images/noimage.jpg" width="100" height="100"/>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="xinxi">
                        <a href="<?php echo $sale_config['root'];?>?mod=view&goods_id=<?php echo $goods['goods_id'];?>" target="_blank">
                            <strong>
                            <?php if($goods['goods_selltype_give']) { ?>
                            求购
                            <?php } ?>
                            <?php echo $goods['goods_title'];?>
                            </strong>
                        </a>
                        <span><?php if($goods['province']) { ?><?php echo $goods['province'];?><?php } ?></span>
                        <p>
                       <?php echo mb_substr(strip_tags($goods['goods_text']),0,30,'UTF-8');?>                        </p>
                    </div>
                    <span><?php echo $goods['member_phone'];?></span>
                    <em><?php echo $goods['goods_time'];?></em>
                </li>
                <?php } ?>
            </ul>
            <div class="page clearfix">
                <?php echo $multipage;?>
            </div>
        </section>
        <aside class="right v604_fr">
            <div style=" margin-bottom:10px;">
                <strong>服务黄页</strong>
                <table class="menu">
                    <tr>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                    </tr>
                    <tr>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                    </tr>
                    <tr>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                    </tr>
                    <tr>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                    </tr>
                    <tr>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                    </tr>
                    <tr>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                        <td  onclick="location.href = '#';"></td>
                    </tr>
                </table>
            </div>
            <div style="margin-top:35px">
                <strong>服务黄页信息推荐</strong>
                <ul class="tuijian">
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li><li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li><li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li><li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li><li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li>
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li>
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li>
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li>
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...<a href="#">[ 详细 ]</a></p>
                    </li>
                </ul>
            </div>
            <div style="margin-top:10px">
                <strong>问题解答</strong>
                <ul class="news" style='margin: 0 0 5px;padding-bottom:0px'>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                </ul>
            </div>
            <div class="xinxi clearfix" style="width:auto !important;margin-top:10px">
                <strong style="font-size:16px !important">本站客服</strong>
                <p style='font-size:14px'>这里是温哥华本地生活信息浏 览/发布平台，每天有上百条信 息供您选择。感谢您对 人在温 哥华网 - VanPeople 的支持,并欢迎大家对无效信息进行监督和投诉</p>

                <a class="contact" href="#">联系客服<img src="<?php echo $_G['style']['v604t_common'];?>img/message.png" class="v604_fr"style="margin-top:2px" /></a> </div>
        </aside></div>
</article>
<!--footer start--><?php include template('common/footer'); ?>