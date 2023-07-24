<?php
// Encryption function
function encryptCookieValue($value, $encryptionKey) {
    $encryptedValue = base64_encode(openssl_encrypt($value, 'AES-256-CBC', $encryptionKey, OPENSSL_RAW_DATA, str_repeat("\0", 16)));
    return $encryptedValue;
}

// Decryption function
function decryptCookieValue($encryptedValue, $encryptionKey) {
    $decryptedValue = openssl_decrypt(base64_decode($encryptedValue), 'AES-256-CBC', $encryptionKey, OPENSSL_RAW_DATA, str_repeat("\0", 16));
    return $decryptedValue;
}

$key = 'GooglE@#7';

?>
