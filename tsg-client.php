<?php

try {

	$APIURL = "";
	$APIKEY = "";
	$TIMEOUT = 15;
	
    $type = "SALE";
    $card_number = "4111111111111111";
    $card_csc = "123";
    $expiry_date = "1121";
    $amount = "10.00";
    $avs_address = "112 N. Orion Court";
    $avs_zip = "20210";
    $purchase_order = "10";
    $invoice = "100";
    $email = "email@tsg.com";
    $customer_id = "25";
    $order_number = "1000";
    $client_ip = "";
    $description = "Cel Phone";
    $comments = "Electronic Product";
    $billing_first_name = "Joe";
    $billing_last_name = "Smith";
    $billing_company = "Company Inc.";
    $billing_street = "Street 1";
    $billing_street2 = "Street 2";
    $billing_city = "Jersey City";
    $billing_state = "NJ";
    $billing_zip = "07097";
    $billing_country = "USA";
    $billing_phone = "123456789";
    $shipping_first_name = "Joe";
    $shipping_last_name = "Smith";
    $shipping_company = "Company 2 Inc.";
    $shipping_street = "Street 1 2";
    $shipping_street2 = "Street 2 2";
    $shipping_city = "Colorado City";
    $shipping_state = "TX";
    $shipping_zip = "79512";
    $shipping_country = "USA";
    $shipping_phone = "123456789";
    
    //Build post data
    $post_data ="<transaction>".
                    "<api_key>".$APIKEY."</api_key>".
                    "<type>".$type."</type>".
                    "<card>".$card_number."</card>".
                    "<csc>".$card_csc."</csc>".
                    "<exp_date>".$expiry_date."</exp_date>".
                    "<amount>".$amount."</amount>".
                    "<avs_address>".$avs_address."</avs_address>".
                    "<avs_zip>".$avs_zip."</avs_zip>".
                    "<email>".$email."</email>".
                    "<customer_id>".$customer_id."</customer_id>".
                    "<order_number>".$order_number."</order_number>".
                    "<purchase_order>".$purchase_order."</purchase_order>".
                    "<invoice>".$invoice."</invoice>".
                    "<client_ip>".$client_ip."</client_ip>".
                    "<description>".$description."</description>".
                    "<comments>".$comments."</comments>".
                    "<billing>".
                        "<first_name>".$billing_first_name."</first_name>".
                        "<last_name>".$billing_last_name."</last_name>".
                        "<company>".$billing_company."</company>".
                        "<street>".$billing_address1."</street>".
                        "<street2>".$billing_address2."</street2>".
                        "<city>".$billing_city."</city>".
                        "<state>".$billing_state."</state>".
                        "<zip>".$billing_zip."</zip>".
                        "<country>".$billing_country."</country>".
                        "<phone>".$billing_phone."</phone>".
                    "</billing>".
                    "<shipping>".
                        "<first_name>".$shipping_first_name."</first_name>".
                        "<last_name>".$shipping_last_name."</last_name>".
                        "<company>".$shipping_company."</company>".
                        "<street>".$shipping_address1."</street>".
                        "<street2>".$shipping_address2."</street2>".
                        "<city>".$shipping_city."</city>".
                        "<state>".$shipping_state."</state>".
                        "<zip>".$shipping_zip."</zip>".
                        "<country>".$shipping_country."</country>".
                        "<phone>".$shipping_phone."</phone>".
                    "</shipping>".
                "</transaction>";
    
    // post data to thesecuregateway
    $c = curl_init($APIURL);
	curl_setopt($c, CURLOPT_TIMEOUT, $TIMEOUT);		
    curl_setopt($c, CURLOPT_VERBOSE, 0);
    curl_setopt($c, CURLOPT_HEADER, 0);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($c, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    
    echo "-----------------------------------------------------". "\n";
    echo "REQUEST TO URL: " . $APIURL . "\n";
    echo "POST DATA: ". "\n";
    echo $post_data . "\n";
            
    $buffer = curl_exec($c);
	
    echo "-----------------------------------------------------". "\n";
    echo "RESPONSE DATA: ". "\n";
    echo $buffer;
    echo "\n";
    
    if($buffer){
        $transaction = new SimpleXMLElement($buffer);
        if($transaction){
            if($transaction->result_code and $transaction->result_code == "0000"){
                echo "-----------------------------------------------------". "\n";
                echo "TRANSACTION APPROVED: " . $transaction->authorization_code. "\n";
            }
            else{
                $code = "";
                if($transaction->error_code)
                    $code = $transaction->error_code;
                if($transaction->result_code)
                    $code = $transaction->result_code;
                echo "-----------------------------------------------------". "\n";
                echo "TRANSACTION ERROR: Code=" . $code . " Message=" . $transaction->display_message. "\n";
            }
        }
    }
    else{
        echo "-----------------------------------------------------". "\n";
        echo "INVALID RESPONSE". "\n";
    }
} catch (Exception $e) {
    echo "-----------------------------------------------------". "\n";
    echo "EXCEPTION: ".  $e->getMessage(). "\n";
}		
?>
