<?php 
if (isset($_POST['sessionUID']) === false) {

    //set the execution timeout long enough to cover the entire process (setup and working time), it dictates when phantomJS shuts down automatically.
    ini_set('max_execution_time', 300);

    //open the login page:
    $myUrl          = "https://www.axs.com";
    $browserObj      = \MTS\Factories::getDevices()->getLocalHost()->getBrowser('phantomjs');

    //allow the page to live after php shuts down.
    $browserObj->setKeepalive(true);
    $windowObj      = $browserObj->getNewWindow($myUrl);

    //find the username input box, here it has id=username
    $windowObj->mouseEventOnElement("[id=username]", 'leftclick');
    //type your username
    $windowObj->sendKeyPresses("yourUsername");

    //find the password input box, here it has id=passwd
    $windowObj->mouseEventOnElement("[id=passwd]", 'leftclick');
    //type your password
    $windowObj->sendKeyPresses("yourPassword");

    //click on the login button, here it has id=login
    $windowObj->mouseEventOnElement("[id=login]", 'leftclick');

    //i assume this is when you encounter the CAPTCHA image

    //find the CAPTCHA image element, here it has id=captchaImage
    $element    = $windowObj->getElement("[id=captchaImage]");
    $loc        = $element['location'];

    //tell the screenshot to only get the CAPTCHA image
    $windowObj->setRasterSize($loc['top'], $loc['left'], ($loc['right'] - $loc['left']), ($loc['bottom'] - $loc['top']));


    $imageData  = $windowObj->screenshot("png");
    $sessionUID  = uniqid();

    $saveWindowObj = serialize($windowObj);

    //save the window object so we can pick it up again
    file_put_contents("/tmp/" . $sessionUID, $saveWindowObj);
}
