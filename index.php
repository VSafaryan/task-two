<?php
 $ipAddress = $_POST['ipAddress']; 
 $soapUrl = "http://ws.cdyne.com/ip2geo/ip2geo.asmx"; 

 $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
 <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
   <soap:Body>
     <ResolveIP xmlns="http://ws.cdyne.com/">
       <ipAddress>'.$ipAddress.'</ipAddress>
       <licenseKey>string</licenseKey>
     </ResolveIP>
   </soap:Body>
 </soap:Envelope>';   

    $headers = array(
                "Accept: text/xml",
                "Content-length: ".strlen($xml_post_string),
                "POST /ip2geo/ip2geo.asmx HTTP/1.1",
                "Host: ws.cdyne.com",
                "Content-Type: text/xml; charset=utf-8",
                "SOAPAction: http://ws.cdyne.com/ResolveIP",
             ); 

     $url = $soapUrl;

  
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); 
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

     $response = curl_exec($ch); 
     curl_close($ch);

     $response1 = str_replace("<soap:Body>","",$response);
     $response2 = str_replace("</soap:Body>","",$response1);

     $parser = simplexml_load_string($response2);

     print_r($parser);