<?php

$myString = "Hello world";
echo md5($myString)."<BR>";

//$method = "AES-128-CBC"; //cbc = cypher block chaining
$method = "AES-128-gcm";
$key = "abc"; // should use cryptographically safe way to generated the key
$iv = openssl_random_pseudo_bytes(16); //initialize vector is a seed fo the encryption algorithm
$message = openssl_encrypt($myString, $method, $key, OPENSSL_RAW_DATA, $iv,$tag);
echo $message."<BR>";

$originalMessage = openssl_decrypt($message, $method, $key, OPENSSL_RAW_DATA, $iv, $tag);
echo $originalMessage."<BR>";

echo bin2hex($myString)."<BR>";