<?php
include_once("ImageResize.php");

function fix_url($url) {
		
    if (substr($url, 0, 7) == 'http://') { return $url; }
    if (substr($url, 0, 8) == 'https://') { return $url; }
    if(substr($url, 0, 4) == 'www.') {
			$url = trim($url, 'www.');
			return 'http://'.$url;	
		}	
    return 'http://'. $url;
}

//chk for webpage  
function webfile($string) {
	  preg_match('/<html[^>]+>/' ,$string, $match[0]);
   	if($match[0]) {
   		return true; 		
   	}
}

//chk for rss
function xmlfile($string) {
	  preg_match('/<rss[^>]+>/' ,$string, $match[0]);
   	if($match[0]) {
   		return true; 		
   	}
}

function getRSSLocation($html, $location){
    if(!$html or !$location){
        return false;
    }else{
        #search through the HTML, save all <link> tags
        # and store each link's attributes in an associative array
        preg_match_all('/<link\s+(.*?)\s*\/?>/si', $html, $matches);
        $links = $matches[1];
        $final_links = array();
        $link_count = count($links);
        for($n=0; $n<$link_count; $n++){
            $attributes = preg_split('/\s+/s', $links[$n]);
            foreach($attributes as $attribute){
                $att = preg_split('/\s*=\s*/s', $attribute, 2);
                if(isset($att[1])){
                    $att[1] = preg_replace('/([\'"]?)(.*)\1/', '$2', $att[1]);
                    $final_link[strtolower($att[0])] = $att[1];
                }
            }
            $final_links[$n] = $final_link;
        }
       
        for($n=0; $n<$link_count; $n++){
            if(strtolower($final_links[$n]['rel']) == 'alternate'){
                if(strtolower($final_links[$n]['type']) == 'application/rss+xml'){
                    $href = $final_links[$n]['href'];
                }
                if(!$href and strtolower($final_links[$n]['type']) == 'text/xml'){
                    
                    $href = $final_links[$n]['href'];
                }
                if($href){
                    if(strstr($href, "http://") !== false){ #if it's absolute
                        $full_url = $href;
                    }else{ 
                        $url_parts = parse_url($location);
                        
                        $full_url = "http://$url_parts[host]";
                        if(isset($url_parts['port'])){
                            $full_url .= ":$url_parts[port]";
                        }
                        if($href{0} != '/'){ 
                            $full_url .= dirname($url_parts['path']);
                            if(substr($full_url, -1) != '/'){
                              
                                $full_url .= '/';
                            }
                        }
                        $full_url .= $href;
                    }
                    return $full_url;
                }
            }
        }
        return false;
    }
}		 
 function parsing($feedurl){
  	$feeds = file_get_contents($feedurl);
    $feeds = str_replace("<content:encoded>","<contentEncoded>",$feeds);
    $feeds = str_replace("</content:encoded>","</contentEncoded>",$feeds);
    $rss = simplexml_load_string($feeds);
    $channel = $rss->channel;
    echo		'<div class="slideshow-wrapper">';
  	echo '<div class="preloader"> </div>';
  
    
  

    echo '<ul data-orbit>';
    foreach($channel->item as $item){
    	$titlelink = $item->link;
      $desc = chars($item->description);
      preg_match('/<img[^>]+>/',$item->contentEncoded, $match);
		preg_match('/http[^>]+(?:png|jpg|gif|jpeg)/i',$match[0], $imgurl);		
		preg_match('/[A-Z0-9_-]{1,}\.(?:png|jpg|gif|jpeg)/i',$imgurl[0], $imgname);
			
		foreach($imgurl as $iurl){
			foreach($imgname as $iname){	
				$imageResize = new ImageResize();
				$name = ''.$iname.'';
				$thumbnail = $imageResize->downloadImageAndResize($iurl,$name);
	echo '<li> <div><a href='.$titlelink.'>'.$item->title.'</a></div><a href='.$iurl.'><img src='.$thumbnail.'></img></a><div> '.$desc.'</div></li>'; 
		} 
	}
}
   echo '</ul>';
   echo '</div>';
}

function chars($string) {
      return substr($string, 0, 140).'...';
        	
 }
 ?>