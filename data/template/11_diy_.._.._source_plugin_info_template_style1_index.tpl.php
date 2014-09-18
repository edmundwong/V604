<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template("info:$style/header");?><link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/service.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/navigation.css" />

<div style="background:url(<?php echo $_G['style']['v604t_common'];?>img/banner.png) no-repeat center; height:200px; position:relative;background-color:#ea5e29">
    <div class="fabu"><a href="/sale.php?mod=choclass">免费发布信息</a><span>|</span><a href="/info.php?mod=member&amp;op=post">发布服务信息</a></div>
    <div style="position:absolute; background:url(<?php echo $_G['style']['v604t_common'];?>img/search.png) no-repeat; width:401px; height:42px; bottom:-20px; left:50%; margin-left:-200px; z-index:9;"><form action="#" method="get">
            <input type="text" style=" width:350px;background:transparent; outline:none; text-indent:20px; border:0 none;line-height: 37px;" /><input type="submit" value="" style=" width:40px;background:transparent; border:0 none; outline:none;" />
        </form>
    </div>
</div>
<article class="clearfix" style="background:#fff4ee">
    <div style=" position:relative;height:15px; border-bottom:5px solid #f3e1d5; width:670px; margin:auto;">
        <p style="text-align:center; left:50%; margin-left:-64px; background:#fff4ee; font-size:14px; height:40px; line-height:40px; position:absolute; top:-5px; padding:0 10px; font-size:18px; color:#bb8b77;">服务黄页分类</p>
    </div>
    <table width="1000" border="1" style=" margin:30px auto 0;background-color: #fff;" class="v604_navigation">
    <?php $a_cat_pid = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,192,193,194,195,196);?>    <?php $i_td = 0;?>    <?php $i_div = 1;?>    <?php if(is_array($a_cat_pid)) foreach($a_cat_pid as $i_pid) { ?>        <?php if($i_td == 0) { ?>
    <tr>
        <?php } ?>
        <td><div class='bg_sprite ico<?php echo $i_div;?>'></div><strong style="margin-bottom:5px"><?php echo $cat_array[$i_pid]['cat_title'];?></strong>
        <ul>
        <?php if(is_array($cat_array)) foreach($cat_array as $cat) { ?>            <?php if($cat['cat_pid'] == $i_pid) { ?>
            <li><a href="<?php echo $info_config['root'];?>?mod=list&subcat_id=<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_title'];?><em>(<?php echo $cat['sum'];?>)</em></a></li>
            <?php } ?>
        <?php } ?>
        </ul>
        </td>
        <?php $i_div++;?>        <?php if(++$i_td >= 3) { ?>
            <?php $i_td = 0;?>    </tr>
        <?php } ?>
    <?php } ?>
    </table>
    <div class="lianxi wrapper" >
        <h2 style='margin-top:10px'>公告 / 联系我们</h2>
        <p>若您对我们的服务感到不满或对我们的服务有良好的建议，欢迎致电：778-686-6618 或直接发邮件给我们：support@vanpeople.com
            感谢您对 人在温哥华 - VanPeople.com 的大力支持。</p>
    </div>
    <div class="lianxi wrapper">
        <h2 style='margin-top:10px'>服务黄页介绍</h2>
        <p>访问我们的产品中心可以使您对我们产品增进了解 , 或者解决您再使用中所遇到的问题 , 请联系客服 QQ: 706277774</p>
    </div>
</article><?php brian_output();?><?php include template('common/footer'); ?>