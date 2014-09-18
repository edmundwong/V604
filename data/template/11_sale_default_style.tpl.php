<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script language="javascript" >function killErr(){return true;}var root = "<?php echo $sale_config['root'];?>";</script>
<script src="<?php echo $sale_config['sale'];?>static/js/common.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $sale_config['sale'];?>template/<?php echo $style;?>/css/style.css?<?php echo VERHASH;?>" />
<?php if($sale_config['header']) { ?><style>#hd{display:none}</style><?php } if($sale_config['scbar']) { ?><style>#scbar {display:none} </style>  <?php } if($sale_config['diy_css']) { ?><style type="text/css"><?php echo $sale_config['diy_css'];?></style><?php } if(empty($_GET['diy'])) { ?><style type="text/css">.frame, .frame-tab { background-color:inherit;  border:none; margin:0;}.block { margin:0;}</style><?php echo $_lang['discuz_diy'];?><?php } ?>
<style id="diy_style" type="text/css"></style>