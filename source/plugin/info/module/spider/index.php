<?php

//$url = 'http://www.vanpeople.com/yellowpage/';
//$re_1 = '/\/c\/\/service\.aspx\?classid=\d+&tagid=\d+$/';
//$a_link_L1 = fetchLinks($url,$re_1);

//$re_2 = '/viewinfo\.aspx\?id=\d+$/';
//$a_link_L2 = fetchLinks($a_link_L1[0],$re_2);
//提取内容
//fetchContent($a_link_L2[0]);


function fetchLinks($s_url,$re){
	$o_snoopy = new Snoopy;
	$o_snoopy->fetchlinks($s_url);
	$a_links_temp = $o_snoopy->results;
        $a_links = array();
	$i=0;
	foreach ($a_links_temp as $key=>$value){
		if (preg_match($re, $a_links_temp[$key]) && !isSameLink($a_links, $a_links_temp[$key])) {
			$a_links[$i++] = $a_links_temp[$key];
		}
	}
	return $a_links;
}

function isSameLink($a_links, $s_link){
    foreach ($a_links as $s_link_temp){
        if ($s_link_temp == $s_link){
            return true;
        }
    }
    return false;
}

function fetchContent($s_url){
//	$o_snoopy = new Snoopy;
//	$o_snoopy->fetch($s_url);
	$o_ypdata = new YellowPageData($s_url);
//	$o_ypdata->debug();
}


?>