<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script language="javascript" >function killErr(){return true;}window.onerror=killErr;</script>
<script src="<?php echo $info_config['info'];?>static/js/common.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $info_config['info'];?>template/default/css/style.css" />
<style type="text/css">
<?php if($info_config['header']) { ?>#hd{display:none}<?php } if($info_config['scbar']) { ?>#scbar {display:none}<?php } ?>
</style>
<style type="text/css"><?php echo $info_config['diy_css'];?></style>
<?php if(empty($_GET['diy'])) { ?><style type="text/css">.frame, .frame-tab { background-color:inherit;  border:none; margin:0;}.block { margin:0;}</style><?php } ?>
<style id="diy_style" type="text/css"></style>