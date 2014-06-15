<?php

// Generate a pop up error message with message $errorStr
function error($errorStr) {
	echo '<script>alert("' .  $errorStr . '")</script>';
}

// Generate a pop up alert
function alert($alertStr) {
	echo '<script>alert("' .  $alertStr . '")</script>';
}

// Generate current url keeping only parameters specified in array $names
function generateURL($names) {
	$url = "";
	$pre = "?";
	foreach ($names as $name) {
		$val = $_GET[$name];
		if ($val != "") {
			$url .= "{$pre}{$name}={$val}";
			$pre = "&";
		}
	}
	return $url;
}

// Get the contents of a page located at $url
function get_url_contents($url) {
    $crl = curl_init();

    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}

// Print the html code to display $max news articles on $searchQuery from Google news
function printProfileNews($searchQuery, $max) {
	$chars = 200;
	$news = simplexml_load_file('https://news.google.com/news/feeds?hl=en&gl=ca&q='. $searchQuery .'&um=1&ie=UTF-8&output=rss');
	$feeds = array();
	$i = 0;
	foreach ($news->channel->item as $item) {
	    if ($i < $max) {
	        preg_match('@src="([^"]+)"@', $item->description, $match);
	        $parts = explode('<font size="-1">', $item->description);

	        $feeds[$i]['title'] = mb_convert_encoding((string) $item->title, "HTML-ENTITIES", "UTF-8");
	        $feeds[$i]['link'] = (string) $item->link;
	        $feeds[$i]['story'] = mb_convert_encoding(strip_tags($parts[2]), "HTML-ENTITIES", "UTF-8");
	        
	        $stringCut = substr($feeds[$i]['story'], 0, $chars);
	        $feeds[$i]['story'] = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...<br /><a class="rmorelink" href="'.$feeds[$i]['link'].'">Read More »</a>';         
	        
	        $feeds[$i]['date'] = (string) $item->pubDate;
	    
	        echo '<div class="newsarticle"><a href="';
	        print($feeds[$i]['link']);
	        echo '" taget="_blank"><b>';
	        print($feeds[$i]['title']);
	        echo '</b></a><br /><h5>';
	        print($feeds[$i]['date']);
	        echo '</h5><div>';
	        print($feeds[$i]['story']);
	        echo '</div></div>';

	        $i++;
	    } else {
	    	break;
	    }
	}
}

// Print the html code to display $max images on $searchQuery from Google images
function printImageGallery($searchQuery, $max) {
            $count = 0;
            $i = 1;
            while (true) {
                $i += 5;
                if ($count > $max-1) break;
                $json = get_url_contents("http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q={$searchQuery}&start={$i}&imgsz=medium");
                $data = json_decode($json);
                foreach ($data->responseData->results as $result) {
                        if (@getimagesize($result->url) != false) {
                            $count++;
                            echo '<img style="margin:5px; background:#eeeeee;" height="200" src="'. $result->url . '">&nbsp';
                        }
                        if ($count > $max-1) break;
                }
            }
}

function printScore($t1, $s1, $t2, $s2) {
	if (intval($s1) > intval($s2)) {
		echo "<strong>" . $t1 . ": " . $s1 . "</strong>&nbsp";
		echo '<span class="glyphicon glyphicon-ok"></span>';
	} else {
		echo $t1 . ": " . $s1;
	}
}

?>