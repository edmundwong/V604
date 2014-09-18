<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template("info:$style/style");?><?php include template('info:admin/style'); ?><div id="plugin_admin" class=" brian_main brian_box pd5 bgf">
    <h1 class="h1">信息管理</h1>
   

    <table class="tb tb2 ">
        <tbody>
            <tr class="header">
                <th >标题</th>
                <th>类型</th>
                <th>添加时间</th>
                <th>电话</th>
                <th >QQ</th>
                <th >时间</th>
                <th>支付方式</th>
                <th>金额</th>
                <th style="width:100px;">操作</th>
            </tr>
            <?php if(is_array($post_list)) foreach($post_list as $vv) { ?>            <tr>
            	<td><?php echo $vv['post_title'];?></td>
            	<td><?php echo $vv['cat_title'];?>/<?php echo $vv['subcat_title'];?></td>
            	<td><?php echo $vv['post_time'];?></td>
            	<td><?php echo $vv['tel'];?></td>
            	<td><?php echo $vv['qq'];?></td>
            	<td><?php echo $vv['b_e'];?></td>
            	<td><?php echo $vv['pay_way'];?></td>
            	<td>$<?php echo $vv['price'];?></td>
            	<td><a href="/admin.php?action=plugins&amp;operation=config&amp;do=21&amp;identifier=info&amp;pmod=admin_neirong&amp;dcj_action=edit&amp;post_id=<?php echo $vv['post_id'];?>">修改</a></td>
            </tr>
            <?php } ?>
            <tr><td colspan=6></td><td colspan=2><?php echo $multipage;?></td></tr>
        </tbody>
        <!-- <tbody>
            <tr>
                <td></td>
                <td colspan=6>
                    <div class="fixsel">
                        <input type="submit" class="btn" name="editsubmit" value="<?php echo $info_lang['loupan_view_kanfang_htm_4'];?>" />
                    </div>
                </td>
            </tr>
        </tbody> -->
    </table>
    
</div>