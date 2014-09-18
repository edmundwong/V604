<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>

<div id="plugin_admin" class=" brian_main brian_box pd5 bgf">
    <table>
        <?php if(is_array($__links)) foreach($__links as $p_key=>$p_value) { ?>        <tr style='border-bottom: 1px solid #CCCCCC'>
            <td style='text-align: center;width:200px;'>
                <?php echo $__links[$p_key]['title'];?>
            </td>
            <td>
                <ul>
                    <?php if(is_array($p_value['child'])) foreach($p_value['child'] as $key=>$value) { ?>                    <li style='border-bottom: 1px solid blueviolet;line-height: 30px;width:600px;'>
                        <span style='display:inline-block;width:300px;font-size:13px;color:#0033cc;font-weight:bolder;text-align: right;margin-right:20px'><?php echo $value['title'];?></span>
                        <?php if(isset($a_subcat_linkinfo[$key])) { ?>
                        <span style='color:#009900'>
                        (<?php echo $a_subcat_linkinfo[$key]['didnum'];?>/<?php echo $a_subcat_linkinfo[$key]['linknum'];?>)
                        <?php } else { ?>
                        <span>
                        0/0
                        <?php } ?>
                        </span>
                        <span style='float:right;'>
                            <a href='<?php echo $now_url;?>&sp_ac=getlink&catid=<?php echo $p_key;?>&subcatid=<?php echo $key;?>' style='border:1px solid #0000CC;padding:2px 5px 2px 5px;'>操作</a>
                        </span>
                    </li>
                    <?php } ?>
                </ul>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>