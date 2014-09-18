<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('list_84');
block_get('425,426,427,387,388,389,390,391,392,393,395,433,434,439,444,449,428,435,440,445,450,429,436,441,446,451,430,437,442,447,452,431,438,443,448,453');?><?php include template('common/header'); ?><!--<style id="diy_style" type="text/css">#frame55okF6 {  background-color:transparent !important;background-image:none !important;border:transparent 0px none !important;margin:0px !important;}#portal_block_395 {  background-color:transparent !important;background-image:none !important;border:transparent 0px none !important;margin:0px !important;}#portal_block_395 .dxb_bc {  margin:0px !important;}#portal_block_387 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_387 .dxb_bc {  margin:0px !important;}#portal_block_388 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_388 .dxb_bc {  margin:0px !important;}#portal_block_389 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_389 .dxb_bc {  margin:0px !important;}#portal_block_390 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_390 .dxb_bc {  margin:0px !important;}#portal_block_391 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_391 .dxb_bc {  margin:0px !important;}#portal_block_392 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_392 .dxb_bc {  margin:0px !important;}#portal_block_393 {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;margin:0px !important;}#portal_block_393 .dxb_bc {  margin:0px !important;}#frameIpvCvL {  background-color:transparent !important;background-image:none !important;border:transparent 0px !important;}</style>-->
<link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/chongfu.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/news.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_G['style']['v604t_common'];?>css/news_index.css" />
<style type="text/css">
.news_right_text li{
width: 280px;
overflow: hidden;
white-space: nowrap;
text-overflow: ellipsis;

}
</style>
<?php if($cat['subs']) { ?>
<ul class="wrapper news_nav clearfix">
    <?php $i = 1;?>    <?php if(is_array($cat['subs'])) foreach($cat['subs'] as $value) { ?>    <li ><a href="<?php echo $portalcategory[$value['catid']]['caturl'];?>"><?php echo $value['catname'];?></a></li>
    <?php $i--;?>    <?php } ?>
</ul>
<?php } ?>
<div style="border-top: 1px solid #efe6e0;width:100%;margin-top:10px"><div>
        <section class="wrapper" style="margin-top:20px">
            <div class="box1 mt10 oh clearfix">
                <!-- 今日焦点 -->
                <div class="newFocusList v604_fl">
                    <!-- 焦点图切换 -->
                    <?php block_display('425');?>                    <!-- 焦点图切换 over -->
                    <?php block_display('426');?>                    <!-- 焦点图切换 over -->
                    <?php block_display('427');?>                    <!-- 相关服务 -->
                    <!-- 相关服务 over -->
                    <!-- 查看所有链接 -->
                    <!-- 查看所有链接 over -->
                </div>
                <!-- 今日焦点 over -->
                
                <!-- 新闻资讯 -->
                <div class="newZxList v604_fl ml20"style="margin-left:30px;width:360px">
                    <!--[diy=v604d_news_index_01]--><div id="v604d_news_index_01" class="area"><div id="frame55okF6" class="cl_frame_bm frame move-span cl frame-1"><div id="frame55okF6_left" class="column frame-1-c"><div id="frame55okF6_left_temp" class="move-span temp"></div><?php block_display('387');?><?php block_display('388');?><?php block_display('389');?><?php block_display('390');?><?php block_display('391');?><?php block_display('392');?><?php block_display('393');?></div></div></div><!--[/diy]-->
                </div>
                <!-- 新闻资讯 over -->

                <!-- 右侧广告 -->
                <div class="right" >
                    <h3>新闻专题</h3>
                    <ul class="news_right_text"style='margin-top:-10px'>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li><li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>  
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>
                        <li><a href="#">赌徒谬论：科学家揭秘赌运的真相</a></li>  				
                    </ul>

                    <h3 style='margin-top:20px'>热点新闻</h3>
                        <!--[diy=v604d_news_index_03]--><div id="v604d_news_index_03" class="area"><div id="frameIpvCvL" class="cl_frame_bm frame move-span cl frame-1"><div id="frameIpvCvL_left" class="column frame-1-c"><div id="frameIpvCvL_left_temp" class="move-span temp"></div><?php block_display('395');?></div></div></div><!--[/diy]-->
                </div>
            </div>
            <!--横栏广告-->
            <div class="mt10 clearfix"><a href="" title="链接描述哦"><img src="<?php echo $_G['style']['v604t_common'];?>img/yzl/g5.jpg" alt="描述哦" width="1000" height="70"></a></div>
            <div class="chongfu clearfix">
                <h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:5px; margin-top:10px; font-size:18px; text-indent:10px;">加国要闻<a href="#" style="font-size:14px; float:right; color:#fc6328;">查看更多</a></h2>
                <div class="chongfu1 clearfix">
                    <!-- 热门文章双图 -->
                    <?php block_display('433');?>                    <div class="clearfix"></div>
                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin:10px 0;">最新推荐</h2>
                    <?php block_display('434');?>                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin-top:10px ;margin-bottom:15px">热门点击</h2>
                    <?php block_display('439');?>                </div>
                <div class="chongfu2">
                    <?php block_display('444');?>                </div>
                <div class="chongfu3">
                    <div class="right">
                        <h3 style="line-height:20px">月度热点</h3>                        
                        <?php block_display('449');?>                    </div>
                </div>
            </div>
            <div class="mt10 clearfix"><a href="" title="链接描述哦"><img src="<?php echo $_G['style']['v604t_common'];?>img/yzl/g5.jpg" alt="描述哦" width="1000" height="70"></a></div>
            <div class="chongfu clearfix">
                <h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:5px; margin-top:10px; font-size:18px; text-indent:10px;">娱乐八卦<a href="#" style="font-size:14px; float:right; color:#fc6328;">查看更多</a></h2>
                <div class="chongfu1 clearfix">
                    <!--<h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:10px; margin-top:10px; font-size:18px; text-indent:10px;">加国地产</h2>-->
                    <?php block_display('428');?>                    <!--<div style="position:relative; float:left; margin:0 5px;"><img src="<?php echo $_G['style']['v604t_common'];?>img/chongfu.jpg" /><p style="position:absolute; bottom:0; width:100%; background:rgba(0,0,0,.5); color:#fff; text-align:center;">内容</p></div>
                    <div style="position:relative; float:left; margin:0 5px;"><img src="<?php echo $_G['style']['v604t_common'];?>img/chongfu.jpg" /><p style="position:absolute; bottom:0; width:100%; background:rgba(0,0,0,.5); color:#fff; text-align:center;">内容</p></div>-->
                    <div class="clearfix"></div>
                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin:10px 0;">最新推荐</h2>
                    <?php block_display('435');?>                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin-top:10px ;margin-bottom:15px">热门点击</h2>
                    <?php block_display('440');?>                </div>
                <div class="chongfu2">
                    <?php block_display('445');?>                </div>
                <div class="chongfu3">
                    <div class="right">
                        <h3 style="line-height:20px">月度热点</h3>
                        <?php block_display('450');?>                    </div>
                </div>
            </div>
            <div class="mt10 clearfix"><a href="" title="链接描述哦"><img src="<?php echo $_G['style']['v604t_common'];?>img/yzl/g5.jpg" alt="描述哦" width="1000" height="70"></a></div>
            <div class="chongfu clearfix">
                <h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:5px; margin-top:10px; font-size:18px; text-indent:10px;">两岸三地<a href="#" style="font-size:14px; float:right; color:#fc6328;">查看更多</a></h2>
                <div class="chongfu1 clearfix">
                    <!--<h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:10px; margin-top:10px; font-size:18px; text-indent:10px;">加国地产</h2>-->
                    <?php block_display('429');?>                    <div class="clearfix"></div>
                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin:10px 0;">最新推荐</h2>
                    <?php block_display('436');?>                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin-top:10px ;margin-bottom:15px">热门点击</h2>
                    <?php block_display('441');?>                </div>
                <div class="chongfu2">
                    <?php block_display('446');?>                </div>
                <div class="chongfu3">
                    <div class="right">
                        <h3>月度热点</h3>
                        <?php block_display('451');?>                    </div>
                </div>
            </div>
            <div class="mt10 clearfix"><a href="" title="链接描述哦"><img src="<?php echo $_G['style']['v604t_common'];?>img/yzl/g5.jpg" alt="描述哦" width="1000" height="70"></a></div>
            <div class="chongfu clearfix">
                <h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:5px; margin-top:10px; font-size:18px; text-indent:10px;">环球万象<a href="#" style="font-size:14px; float:right; color:#fc6328;">查看更多</a></h2>
                <div class="chongfu1 clearfix">
                    <?php block_display('430');?>                    <div class="clearfix"></div>
                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin:10px 0;">最新推荐</h2>
                    <?php block_display('437');?>                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin-top:10px ;margin-bottom:15px">热门点击</h2>
                    <?php block_display('442');?>                </div>
                <div class="chongfu2">
                    <?php block_display('447');?>                </div>
                <div class="chongfu3">
                    <div class="right">
                        <h3>月度热点</h3>
                        <?php block_display('452');?>                    </div>
                </div>
            </div>
            <div class="mt10 clearfix"><a href="" title="链接描述哦"><img src="<?php echo $_G['style']['v604t_common'];?>img/yzl/g5.jpg" alt="描述哦" width="1000" height="70"></a></div>
            <div class="chongfu clearfix">
                <h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:5px; margin-top:10px; font-size:18px; text-indent:10px;">大温新闻<a href="#" style="font-size:14px; float:right; color:#fc6328;">查看更多</a></h2>
                <div class="chongfu1 clearfix">
                    <!--<h2 class="jiaguo" style=" border-left:5px solid #fc6328; margin-bottom:10px; margin-top:10px; font-size:18px; text-indent:10px;">加国地产</h2>-->
                    <?php block_display('431');?>                    <div class="clearfix"></div>
                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin:10px 0;">最新推荐</h2>
                    <?php block_display('438');?>                    <h2 style="color:#fc6328; font-size:14px; font-weight:bold; margin-top:10px ;margin-bottom:15px">热门点击</h2>
                    <?php block_display('443');?>                </div>
                <div class="chongfu2">
                    <?php block_display('448');?>                </div>
                <div class="chongfu3">
                    <div class="right">
                        <h3>月度热点</h3>
                        <?php block_display('453');?>                    </div>
                </div>
            </div>
        </section>
        <?php include template('common/footer'); ?>