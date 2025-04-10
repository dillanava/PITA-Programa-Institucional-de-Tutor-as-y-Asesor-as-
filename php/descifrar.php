<?php
// Clave de encriptación - Debe ser la misma usada para encriptar
define("ENCRYPTION_KEY", "k9qyz4PiMsXaDzpdppqH4GgyseKRGEGd");

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

// Reemplaza 'TU_CONTRASEÑA_ENCRIPTADA' con la contraseña encriptada de la base de datos
$encrypted_password = "jYwMNs4eK+woXTlljqVjItuHd4HsrCsF/1nEJ7z9fjEskBGlHRU8SM29PXEEQNpwY4jhbAD+1itrWS+GomuEnA==";
$decrypted_password = decrypt($encrypted_password);

if ($decrypted_password) {
    echo "La contraseña desencriptada es: " . $decrypted_password;
} else {
    echo "No se pudo desencriptar la contraseña.";
}
?>
