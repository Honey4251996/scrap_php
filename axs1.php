<?php
	//echo file_get_contents('https://www.axs.com');die();
	require 'vendor/autoload.php';
    use JonnyW\PhantomJs\Client;

    $client = Client::getInstance();
	$client->isLazy();
	$client->getEngine()->addOption('--load-images=false');
  /*  $client->getEngine()->addOption('--ignore-ssl-errors=true');
	  $client->getEngine()->addOption("--proxy=158.46.169.206:22225");
    $client->getEngine()->addOption("--proxy-auth=lum-customer-hl_a6b54c50-zone-zone1:v4nbr5xnzjom");
	/*$client->getEngine()->addOption("--proxy-type=socks5");
	*/
	
	$chrome_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36';
	$firefox_agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0';
	$ie_agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko';
	$edge_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063';
	$agents = array($chrome_agent, $firefox_agent, $edge_agent, $ie_agent);
	$user_agent = array_rand(array_flip($agents));
	
	/*
	* Now randomize the user-agent
	*/
	
	
	$client->getEngine()->setPath(dirname(__FILE__).'/bin/phantomjs.exe');

    /** 
     * @see JonnyW\PhantomJs\Http\Request
     **/
    $request = $client->getMessageFactory()->createRequest('https://www.axs.com/browse/music', 'GET');
	$request->addSetting('userAgent', $user_agent);
	
	    $request->setTimeout(10000); 
		$a=array(200,300,400,500,600,700);
		$delay = $a[array_rand($a,1)];
		$request->setDelay($delay);

    /** 
     * @see JonnyW\PhantomJs\Http\Response 
     **/
    $response = $client->getMessageFactory()->createResponse();

    // Send the request
    $client->send($request, $response);
	echo $response->getStatus();
    if($response->getStatus() === 200) {	
		echo '<pre>'.$response->getContent().'</pre>';die();	
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$content = $response->getContent();
		$dom->loadHTML($content);
		/*$multiple_offers = $dom->getElementsByClassName('multiple-offers-entry');
		foreach ($multiple_offers as $offer) {
			var_dump($offer);echo '<br><Br><hr><br><br>';
		}*/
		//libxml_clear_errors();
		$xpath = new DOMXpath($dom);
		$ticketlist = array();
		$ticketcnt = 1;
		echo 't';echo $xpath->query('//div[contains(@class, "teaser")]')->length;die();
		foreach($xpath->query('//div[contains(@class, "teaser")]') as $offer)
		{
			
			echo $offer->nodeValue;die();
			echo '<br><Br><hr><br><br>';
		}
		
    }