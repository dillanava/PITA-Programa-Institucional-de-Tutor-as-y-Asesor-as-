<?php
// Funciones de encriptación y desencriptación utilizando OpenSSL

// Clave de encriptación - asegúrate de mantenerla segura y no compartirla
define("ENCRYPTION_KEY", "k9qyz4PiMsXaDzpdppqH4GgyseKRGEGd");

function encrypt($data) {
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($data, $cipher, ENCRYPTION_KEY, $options = OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, ENCRYPTION_KEY, $as_binary = true);
    return base64_encode($iv . $hmac . $ciphertext_raw);
}

function decrypt($data) {
    $c = base64_decode($data);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len = 32);
    $ciphertext_raw = substr($c, $ivlen + $sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, ENCRYPTION_KEY, $options = OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, ENCRYPTION_KEY, $as_binary = true);
    if (hash_equals($hmac, $calcmac)) {
        return $original_plaintext;
    } else {
        return false;
    }
}

?>
