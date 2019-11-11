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
    $request = $client->getMessageFactory()->createRequest('https://tickets.axs.com/shop/#/1c1373d3-8c45-45d5-a19d-d165ca0d7146/shop/premium?premiumView=1&lang=en&locale=en_us&preFill=1&eventid=383461&src=AEGAXS1_WMAIN&skin=axs_tmobile&fbShareURL=www.axs.com%2Fevents%2F383461%2Fdan-shay-tickets%3F%26ref%3Devs_fb', 'GET');
	
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

    if($response->getStatus() === 200) {		
       //
	   //echo '<pre>'.$response->getContent().'</pre>';
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
		
		if($xpath->query('//div[contains(@class, "ticket-list__item")]')->length==0) 
		{
			die();
			//header("Refresh:0");
			//echo 's';die();
		}
		
		foreach($xpath->query('//div[contains(@class, "ticket-list__item")]') as $offer)
		{
			$att1 = $xpath->query("descendant::*[@class='ticket-meta__quantity']", $offer);
			foreach ($att1 as $n) {
				
				$ticketlist[$ticketcnt]['quantity'] = $n->nodeValue;
			}
			
			$att2 = $xpath->query("descendant::*[@class='price-range']", $offer);
			foreach ($att2 as $n) {
				
				$ticketlist[$ticketcnt]['price'] = $n->nodeValue;
			}
			
			$att3 = $xpath->query("descendant::*[@class='seat-info__price-level--value']", $offer);
			foreach ($att3 as $n) {
				
				$ticketlist[$ticketcnt]['level'] = $n->nodeValue;
			}
			
			
			$att4 = $xpath->query("descendant::*[@class='seat-info__section--value']", $offer);
			foreach ($att4 as $n) {
				
				$ticketlist[$ticketcnt]['section'] = $n->nodeValue;
			}
			
			$att5 = $xpath->query("descendant::*[@class='seat-info__row--value']", $offer);
			foreach ($att5 as $n) {
				
				$ticketlist[$ticketcnt]['row'] = $n->nodeValue;
			}
			
			$att6 = $xpath->query("descendant::*[@class='seat-info__seats--value']", $offer);
			foreach ($att6 as $n) {
				
				$ticketlist[$ticketcnt]['seats'] = $n->nodeValue;
			}
			
			$att7 = $xpath->query("descendant::*[@class='multiple-offers-entry__total']", $offer);
			foreach ($att7 as $n) {
				
				$ticketlist[$ticketcnt]['offertotal'] = $n->nodeValue;
			}
			$ticketcnt++;
			var_dump($ticketlist);
			echo '<br><Br><hr><br><br>';
			
		}
		//var_dump($xpath);die();
    }