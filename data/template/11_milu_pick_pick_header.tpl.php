<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script type="text/javascript">
var PICK_URL = 'admin.php?<?php echo PICK_GO;?>';
var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>';
var is_lan = '<?php echo $info['is_lan'];?>';var bbname = '<?php echo str_replace('\'', '\\\'', $_G[setting][bbname]);?>';
</script>
<script src="<?php echo PICK_URL;?>static/jquery-1.6.2.min.js?v=<?php echo PICK_VERSION;?>" type="text/javascript"></script>
<script src="<?php echo PICK_URL;?>static/phprpc_client.js?v=<?php echo PICK_VERSION;?>" type="text/javascript"></script>
<script src="<?php echo PICK_URL;?>static/inc.js?v=<?php echo PICK_VERSION;?>" type="text/javascript"></script>
<link href="<?php echo PICK_URL;?>static/style.css?v=<?php echo PICK_VERSION;?>" rel="stylesheet" type="text/css" />

<?php echo $info['header'];?>
<?php if($info['evn_msg']) { ?><?php echo $info['evn_msg'];?><?php exit();?><?php } if($info['tips']) { ?><?php echo $info['tips'];?><?php } ?>
