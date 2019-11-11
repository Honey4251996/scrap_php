<?php

	require 'vendor/autoload.php';
    use JonnyW\PhantomJs\Client;

    $client = Client::getInstance();
	$client->isLazy();
	$client->getEngine()->addOption('--load-images=false');
    $client->getEngine()->addOption('--ignore-ssl-errors=true');
	  /*$client->getEngine()->addOption("--proxy=$proxy:$port");
    $client->getEngine()->addOption("--proxy-auth=$username:$password");
	$client->getEngine()->addOption("--proxy-type=socks5");
	*/
	
	
	$client->getEngine()->setPath(dirname(__FILE__).'/bin/phantomjs.exe');

    /** 
     * @see JonnyW\PhantomJs\Http\Request
     **/
    $request = $client->getMessageFactory()->createCaptureRequest('https://tickets.axs.com/shop/#/1c1373d3-8c45-45d5-a19d-d165ca0d7146/shop/premium?premiumView=1&lang=en&locale=en_us&preFill=1&eventid=383461&src=AEGAXS1_WMAIN&skin=axs_tmobile&fbShareURL=www.axs.com%2Fevents%2F383461%2Fdan-shay-tickets%3F%26ref%3Devs_fb', 'GET');
	$request->setOutputFile('/path/to/save/capture/file.jpg');
	    $request->setTimeout(10000); 
		$request->setDelay(400);

    /** 
     * @see JonnyW\PhantomJs\Http\Response 
     **/
    $response = $client->getMessageFactory()->createResponse();

    // Send the request
    $client->send($request, $response);

    if($response->getStatus() === 200) {		
        echo '<pre>'.$response->getContent().'</pre>';
		$dom = new DOMDocument();
		//libxml_use_internal_errors(true);
		$content = $response->getContent();
		@$dom->loadHTML($content);
		$multiple_offers = $dom->getElementsByClassName('multiple-offers-entry');
		foreach ($multiple_offers as $offer) {
			var_dump($offer);echo '<br><Br>';
			$eachofferitem = 'Offer Quantity: ';$offer->getElementsByClassName('ticket-meta__quantity')->item(0)->nodeValue;echo '<br><Br>';
			$eachofferitem = 'Offer Price: ';$offer->getElementsByClassName('price-range')->item(0)->nodeValue;
			echo '<br><Br><hr><br><br>';
		}
		
    }