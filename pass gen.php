<?php
// Caesar cipher function
function caesarCipher($string, $shift)
{
    $output = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char = $string[$i];
        if (ctype_alpha($char)) {
            $ascii = ord(ctype_upper($char) ? 'A' : 'a');
            $output .= chr(fmod((ord($char) + $shift - $ascii), 26) + $ascii);
        } else {
            $output .= $char;
        }
    }
    return $output;
}

// Apply Caesar cipher to the password with a shift of 3
$cipheredPassword = caesarCipher('agum', 3);

// Then apply MD5 hash
$hashedPassword = md5($cipheredPassword);

echo $hashedPassword;
?>