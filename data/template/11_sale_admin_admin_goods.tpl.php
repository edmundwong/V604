<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template("sale:$style/style");?><?php include template('sale:admin/style'); ?><div id="plugin_admin" class="brian_main">
<div class="brian_box pd5 bgf">
    <h2 class="h2">1. 类别管理</h2>
    <table class='brian_table fix' style=" margin-top:5px;">
    <tr style="border:none;">
        <th style="width:50px;">&nbsp;</th>
        <th style="width:30px;"><?php echo $_lang['zhiding'];?></th>
        <th></th>
        <th><?php echo $_lang['goods_time'];?></th>
        <th><?php echo $_lang['member_usernmae'];?></th>
         <th>IP</th>
         <th style="width:60px;"></th>
        <th>&nbsp;</th>
    </tr>
    <?php if($goods_array) { ?>
    <?php if(is_array($goods_array)) foreach($goods_array as $goods) { ?>    <tr>
        <td><?php if($goods['goods_upload_file_1']) { ?><img src="<?php echo $goods['goods_upload_file_1'];?>" style="width:40px; height:30px;" /><?php } else { ?><img src="<?php echo $sale_config['sale'];?>images/nophotosmall.gif" style="width:40px; height:30px;"  /><?php } ?></td>
        <td><?php if($goods['goods_up']) { ?><b style="color:red;"><?php echo $_lang['yes'];?></b><?php } else { ?><?php echo $_lang['no'];?><?php } ?></td>
        <td><a href="<?php echo $sale_config['root'];?>?mod=view&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_title'];?></a></td>
        <td><?php echo date('Y-m-d',$goods['goods_time']);; ?></a></td>
        <td><?php echo $goods['member_username'];?></td>
        <td><?php echo $goods['goods_ip'];?>(<?php echo $goods['goods_ip_adr'];?>)</td>
        <td style="text-align:center; line-height:20px;">
            <?php if($goods['goods_status']==1) { ?>
                <b style="color:green" class="tc"><?php echo $_lang['tongguo'];?></b>
                <div><a href="admin.php?<?php echo $cp_url;?>&amp;goods_id=<?php echo $goods['goods_id'];?>&amp;goods_status=0" class="btn" style="width:30px;"><?php echo $_lang['xiajia'];?></a></div>
            <?php } else { ?>
                <b style="color:red" class="tc"><?php echo $_lang['weishenhe'];?></b>
                <div><a href="admin.php?<?php echo $cp_url;?>&amp;goods_id=<?php echo $goods['goods_id'];?>&amp;goods_status=1" class="btn" style="width:30px;"><?php echo $_lang['tongguo'];?></a></div>
            <?php } ?>
        </td>
        <td><a href="<?php echo $sale_config['root'];?>?mod=post&ac=edit&goods_id=<?php echo $goods['goods_id'];?>" target="_blank">编辑</a> | <a href="<?php echo $sale_config['root'];?>?mod=view&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $_lang['view'];?></a></td>
    </tr>
    <?php } ?>
    <?php } ?>
    </table>
<div><?php echo $multipage;?></div>

    <h2 class="h2">2. <?php echo $_lang['shenhe_piliang'];?></h2>
    <div class="brian_box pd5 bgf">
    <a href="admin.php?<?php echo $cp_url;?>&amp;goods_id=all&amp;goods_status=1" class="btn"><?php echo $lang['all'];?><?php echo $_lang['tongguo'];?></a> | <a href="admin.php?<?php echo $cp_url;?>&amp;goods_id=all&amp;goods_status=0" class="btn"><?php echo $lang['all'];?><?php echo $_lang['xiajia'];?></a>
    </div>
</div>
</div>