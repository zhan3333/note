<?php

// PKCS#1 格式
$publicKey = file_get_contents(__DIR__ . '/rsa_public_key.pem');

$res = openssl_get_publickey($publicKey);

$encrypted = '';
openssl_public_encrypt('123456', $encrypted, $res);
var_dump($encrypted);
file_put_contents(__DIR__ . '/res_public_key_encrypted_base64.txt', base64_encode($encrypted));