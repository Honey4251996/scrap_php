<?php ob_start(); session_start(); ?>
<!doctype html>
<html class="no-js" lang="en">
<?php

error_reporting(0);
session_start();
function insertasin($url,$asinno)
{
	global $connection;
	session_start();
	
		$query	= "INSERT INTO `tbl_asin` (`amazonurl`,`asinno`) VALUES ('".$url."','".$asinno."');";
		$result = mysqli_query($connection, $query);
}

function inserturl($url,$pagennum)
{
	global $connection;
	session_start();
	$query = "select * from tbl_url";
	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result)>0){
		echo 'Another URL request is in progress. Please try in sometime';
	}
	else {
	$query = "INSERT INTO `tbl_url` (`url`,`pagenum`) VALUES ('".$url."','".$pagennum."');";
	$result = mysqli_query($connection, $query);
	}
}

function updateasininfo($asinid,$brandname,$rank,$category)
{
	global $connection;
	session_start();
	$query = "UPDATE `tbl_asin` SET `brand_name` = '".$brandname."',`rank`='".$rank."',`category`='".$category."' where `id` = '".$asinid."';";
	
	$result = mysqli_query($connection, $query);
}
function getStringBetween($str,$from,$to)
{

	$sub = '';
	if($from!='') {
		$sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
	}

	$strret = substr($sub,0,strpos($sub,$to));

	if($strret == false)

		return ' ';

	else return $strret;

	

}



/**

     * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an

     * array containing the HTTP server response header fields and content.

     */

    function get_web_page( $url ) {

        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Accept-Charset" => "ISO-8859-1,utf-8;q=0.7,*;q=0.7",
			"Keep-Alive" => "115",
			"Connection" => "keep-alive",
			"X-Requested-With" => "XMLHttpRequest"
		));
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
	$com = "https://www.axs.com/browse/music";
	$contents = get_web_page($com);
		var_dump($contents);die();
		?>