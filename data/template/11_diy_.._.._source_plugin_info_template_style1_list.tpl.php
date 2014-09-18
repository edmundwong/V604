<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template("info:$style/header");?><link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/service.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/page_list.css" />

<article class="clearfix"style='background: #fff4ee;'>
    <div style="background:#fff;padding: 5px;border-bottom: 1px solid #ece7e4">
        <div class="wrapper" >
            <form name="" method="post" action="sale.php" >
            <h2 class="clearfix" style="">
                <span style=" line-height:42px; padding-left:6px; font-size:18px; font-weight:bold; color:#3d3d45; border-left:5px solid #fc6328;">
                <?php if($keyword) { ?>
                    <?php echo $info_lang['search'];?>:<?php echo $keyword;?>
                <?php } else { ?>
                    <a href="<?php echo $info_config['root'];?>?mod=list&subcat_id=<?php echo $subcat_id;?>"><?php echo $subcat_title;?></a>
                <?php } ?>
                </span>
                
                
                <a href="#" style="color:#fc6328; font-size:14px; float:right; margin:8px;">管理我的信息</a>
                <a href="#" style=" color:#fff; background:#8cc152; font-size:14px; float:right; margin:7px;margin-right:17px; padding:5px;line-height:15px">发布服务信息</a>
                <a href="#" style="color:#fff;background:#fc6328; margin:7px;margin-left:17px;margin-right:2px; font-size:14px; float:right; padding:5px;line-height:15px">免费发布信息</a>
                <!--<form name="" method="post" action="sale.php" >
            <dl class="list_search">
                <dt>
                关键字：<input type="text" style="width:90px;" name="title" value="" onclick="if (this.value == '标题/描述')
                            this.value = '';" style="color: #808080;" value="标题/描述" />
                <select style="width:90px;" name="sale_cat_id" class="select_c"><option value="" >请选择类目</option><option   value="1">二手物品 - 求购信息</option><option   value="2">汽车及配件 (私人)</option><option   value="3">汽车及配件 (车行)</option><option   value="4">电脑及配件</option><option   value="5">手机通讯</option><option   value="6">家电/数码</option><option   value="7">二手家具</option><option   value="8">书本/音像/乐器</option><option   value="9">包包/服饰/首饰/化妆品</option><option   value="10">休闲运动</option><option   value="11">宠物</option><option   value="12">母婴/儿童用品</option><option   value="13">月票/票据</option><option   value="14">其他物品（包括烟酒）</option><option   value="15">求购/免费</option><option   value="16">房屋信息</option><option   value="17">房屋出租/合租</option><option   value="18">房屋求租</option><option   value="19">出售求购</option><option   value="20">生意转让-商品房出租</option><option   value="21">求职 - 招聘</option><option   value="22">餐饮行业</option><option   value="23">保姆看护</option><option   value="24">保洁清洁</option><option   value="25">销售客服</option><option   value="26">美容护理</option><option   value="27">各类工人</option><option   value="28">司机</option><option   value="29">电脑相关</option><option   value="30">家教培训</option><option   value="31">文秘助理</option><option   value="32">医疗护理</option><option   value="33">金融财会</option><option   value="34">其他工作</option><option   value="35">求职</option><option   value="36">其他个人信息</option><option   value="37">外币兑换</option><option   value="38">回国带物</option><option   value="39">找人拼车</option><option   value="40">寻人寻物</option><option   value="41">寻求服务</option><option   value="42">交友征婚</option><option   value="43">结伴出游</option><option   value="44">其他</option><option   value="45">活动/讲座 </option></select>
                <select style="width:90px;" name="sale_area" class="select_c"><option value="" >请选择地区</option><option  value="West Vancouver">West Vancouver</option><option  value="White Rock">White Rock</option><option  value="Surrey">Surrey</option><option  value="Langley">Langley</option><option  value="Delta">Delta</option><option  value="North Vancouver">North Vancouver</option><option  value="West Vancouver">West Vancouver</option><option  value="Vancouver">Vancouver</option><option  value="Richmond">Richmond</option><option  value="New Westminster">New Westminster</option><option  value="Coquitlam">Coquitlam</option><option  value="Burnaby">Burnaby</option></select>
                <label><input type="checkbox" name="sale_img" value="1"  />有图片</label>
                <input type="submit" name="" value="搜索" /></dt>
                <dd>电话</dd>
                <dd class="ft">发布时间</dd>
            </dl>

        </form>-->
                    <input type="submit" id="search_submit" style="display:none;"/>
                    <span onclick="document.getElementById('search_submit').click()" style="width:50px;height:30px;line-height:30px;background:#fc6328;color:#fff;text-align:center;font-size: 14px;cursor:pointer;float:right;margin:5px;margin-left:-2px;">搜索</span>
                    <!--<select><option value ="1">有图片</option></select>-->
                    <select style="width:50px;" name="sale_cat_id"><option value="" >类目</option><option value="1">二手物品 - 求购信息</option><option value="2">汽车及配件 (私人)</option><option   value="3">汽车及配件 (车行)</option><option   value="4">电脑及配件</option><option   value="5">手机通讯</option><option   value="6">家电/数码</option><option   value="7">二手家具</option><option   value="8">书本/音像/乐器</option><option   value="9">包包/服饰/首饰/化妆品</option><option   value="10">休闲运动</option><option   value="11">宠物</option><option   value="12">母婴/儿童用品</option><option   value="13">月票/票据</option><option   value="14">其他物品（包括烟酒）</option><option   value="15">求购/免费</option><option   value="16">房屋信息</option><option   value="17">房屋出租/合租</option><option   value="18">房屋求租</option><option   value="19">出售求购</option><option   value="20">生意转让-商品房出租</option><option   value="21">求职 - 招聘</option><option   value="22">餐饮行业</option><option   value="23">保姆看护</option><option   value="24">保洁清洁</option><option   value="25">销售客服</option><option   value="26">美容护理</option><option   value="27">各类工人</option><option   value="28">司机</option><option   value="29">电脑相关</option><option   value="30">家教培训</option><option   value="31">文秘助理</option><option   value="32">医疗护理</option><option   value="33">金融财会</option><option   value="34">其他工作</option><option   value="35">求职</option><option   value="36">其他个人信息</option><option   value="37">外币兑换</option><option   value="38">回国带物</option><option   value="39">找人拼车</option><option   value="40">寻人寻物</option><option   value="41">寻求服务</option><option   value="42">交友征婚</option><option   value="43">结伴出游</option><option   value="44">其他</option><option   value="45">活动/讲座 </option></select>
                    <select style="width:50px;" name="sale_area"><option value="" >地区</option><option value="West Vancouver">West Vancouver</option><option value="White Rock">White Rock</option><option  value="Surrey">Surrey</option><option  value="Langley">Langley</option><option  value="Delta">Delta</option><option  value="North Vancouver">North Vancouver</option><option  value="West Vancouver">West Vancouver</option><option  value="Vancouver">Vancouver</option><option  value="Richmond">Richmond</option><option  value="New Westminster">New Westminster</option><option  value="Coquitlam">Coquitlam</option><option  value="Burnaby">Burnaby</option></select>
                    <input type="search" placeholder="请输入关键字;" style="margin-top:5px;float:right;border:1px solid #fc6328;border-right:1px solid #b4b4b4;height:22px;width:150px;"/>
                </h2>
            </form>
        </div>
    </div>
    <table class="menu">
        <tr>
            <td><a  href="/info.php?mod=list&amp;subcat_id=1"><div class='bg_sprite ico1'></div>旅馆</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=2"><div class='bg_sprite ico2'></div>搬运</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=3"><div class='bg_sprite ico3'></div>租车</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=4"><div class='bg_sprite ico4'></div>汽车维修</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=5"><div class='bg_sprite ico5'></div>机票旅游</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=6"><div class='bg_sprite ico6'></div>快递服务</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=7"><div class='bg_sprite ico7'></div>清洁</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=8"><div class='bg_sprite ico8'></div>水暖电工</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=9"><div class='bg_sprite ico9'></div>园艺</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=10"><div class='bg_sprite ico10'></div>电脑</a></td>
        </tr><tr>
            <td><a  href="/info.php?mod=list&amp;subcat_id=11"><div class='bg_sprite ico11'></div>美食/食品</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=12"><div class='bg_sprite ico12'></div>婚庆服务</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=13"><div class='bg_sprite ico13'></div>移民签证</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=14"><div class='bg_sprite ico14'></div>院校</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=15"><div class='bg_sprite ico15'></div>雅思托福</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=16"><div class='bg_sprite ico16'></div>各类辅导</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=17"><div class='bg_sprite ico17'></div>艺术/运动</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=18"><div class='bg_sprite ico18'></div>汇款换汇</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=19"><div class='bg_sprite ico19'></div>地产/贷款</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=20"><div class='bg_sprite ico20'></div>建筑装修</a></td>
        </tr><tr>
            <td><a  href="/info.php?mod=list&amp;subcat_id=21"><div class='bg_sprite ico21'></div>验屋</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=22"><div class='bg_sprite ico22'></div>保健品</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=23"><div class='bg_sprite ico23'></div>保姆</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=24"><div class='bg_sprite ico24'></div>驾照</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=25"><div class='bg_sprite ico25'></div>报税/退税</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=192"><div class='bg_sprite ico26'></div>理财投资</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=194"><div class='bg_sprite ico27'></div>医疗诊断</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=193"><div class='bg_sprite ico28'></div>法律服务</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=195"><div class='bg_sprite ico29'></div>推拿按摩</a></td>
            <td><a  href="/info.php?mod=list&amp;subcat_id=196"><div class='bg_sprite ico30'></div>成人娱乐</a></td>
        </tr>
    </table>
    <div class="wrapper">
        <section class="left v604_fl"style="border:1px solid #ece7e4;width:782px;margin-bottom:30px">
            <div class="list_title" style='margin-top:5px;line-height: 30px'>
                <strong>全部信息</strong>
                <em class="v604_fr"style="margin-right:15px;">发布时间</em><span class="v604_fr" style="margin-right:115px;">电话</span>
            </div>
            <ul class="list" style="height: 558px;">
            <?php $list_i =0;?>            <?php if(is_array($post_list)) foreach($post_list as $post) { ?>                <li class="clearfix">
                    <div class="img">
                        <a href="<?php echo $info_config['root'];?>?mod=view&post_id=<?php echo $post['post_id'];?>">
                        <?php if($post['post_img_1']) { ?>
                            <img src="<?php echo $post['post_img_1'];?>"width="100" height="100" />
                        <?php } else { ?>
                            <img src="<?php echo $info_config['info'];?>static/images/noimage.jpg" width="100" height="100"/>
                        <?php } ?>
                        </a>
                    </div>
                    <div class="xinxi">
                        <a href="<?php echo $info_config['root'];?>?mod=view&post_id=<?php echo $post['post_id'];?>" target="_blank"><span class='v604_txt_ellipsis'><strong><?php echo $post['post_title'];?></strong></span></a>
                        <?php if(1!=1 && $post['post_img_1']) { ?>
                        <img src="<?php echo $_G['style']['v604t_common'];?>img/pic.jpg" />
                        <?php } ?>
                        <span><?php echo $post['area_title'];?> <?php echo $post['subarea_title'];?> <?php echo $post['thrarea_title'];?></span>
                        <p><?php echo $post['enterprise'];?></p>
                    </div>
                    <span><?php echo $post['tel'];?></span>
                    <em><?php echo dgmdate($post['post_time'],'Y-m-d');; ?></em>
                </li>
                <?php if($list_i ==1) { ?>
                    <?php $list_i =0;?>                <?php } else { ?>
                    <?php $list_i =1;?>                <?php } ?>
            <?php } ?>
            </ul>
            <div class="cl"><?php echo $multipage;?></div>		
            <!--GcnAD start--><div class="GcnAD_list imgBlock" id='GcnADId2'></div><!--GcnAD end-->
            <!--<ul class="page clearfix">
                <li>首页</li>
                <li>1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
                <li>5</li>
                <li>下一页</li>
                <li>尾页</li>
            </ul>-->
        </section>
        <aside class="right v604_fr"style="border:1px solid #ece7e4">
            <div style=" margin-bottom:10px;">
                <strong>服务黄页信息推荐</strong>
                <ul class="tuijian">
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...[ 详细 ]</p>
                    </li>
                    <li>
                        <h3>西温5卧公寓整套出租</h3>
                        <span>温哥华Burnaby</span>
                        <p>房屋简介：5卧2厅3卫 精装修整套出租，家电家具齐全，详...[ 详细 ]</p>
                    </li>
                </ul>
            </div>
        </aside>
        <aside class="right v604_fr"style="border:1px solid #ece7e4;margin-top:10px">
            <div style='border-bottom:1px solid #ece7e4;'>
                <strong style="margin-top:10px">问题解答</strong>
                <ul class="news" style='padding-bottom:0px'>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                    <li><a href="#">如何免费发布信息？</a></li>
                </ul>
            </div>
            <div class="xinxi clearfix">
                <strong style="margin-top:10px">本站客服</strong>
                <p>这里是温哥华本地生活信息浏 览/发布平台，每天有上百条信 息供您选择。感谢您对 人在温 哥华网 - VanPeople 的支持</p>

                <a class="contact" href="#" style='font-size:14px'>联系客服<img src="<?php echo $_G['style']['v604t_common'];?>img/message.png" class="v604_fr" style='margin-top:3px'/></a> </div>
        </aside>
    </div>
</article><?php brian_output();?><?php include template('common/footer'); ?>