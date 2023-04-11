<?php
function chiffrement_cesar($message, $cle)
{
    $message_chiffre = "";
    $message_longueur = strlen($message);
    for ($i = 0; $i < $message_longueur; $i++) {
        $caractere = ord($message[$i]);
        // Si le caractère est une lettre majuscule
        if ($caractere >= 65 && $caractere <= 90) {
            $caractere_chiffre = (($caractere - 65 + $cle) % 26) + 65;
            $message_chiffre .= chr($caractere_chiffre);
            // Si le caractère est une lettre minuscule
        } else if ($caractere >= 97 && $caractere <= 122) {
            $caractere_chiffre = (($caractere - 97 + $cle) % 26) + 97;
            $message_chiffre .= chr($caractere_chiffre);
            // Si le caractère n'est pas une lettre, on le conserve tel quel
        } else {
            $message_chiffre .= $message[$i];
        }
    }
    return $message_chiffre;
}

function dechiffrement_cesar($message_chiffre, $cle)
{
    $message_dechiffre = "";
    $message_chiffre_longueur = strlen($message_chiffre);
    for ($i = 0; $i < $message_chiffre_longueur; $i++) {
        $caractere_chiffre = ord($message_chiffre[$i]);
        // Si le caractère est une lettre majuscule
        if ($caractere_chiffre >= 65 && $caractere_chiffre <= 90) {
            $caractere_dechiffre = (($caractere_chiffre - 65 - $cle + 26) % 26) + 65;
            $message_dechiffre .= chr($caractere_dechiffre);
            // Si le caractère est une lettre minuscule
        } else if ($caractere_chiffre >= 97 && $caractere_chiffre <= 122) {
            $caractere_dechiffre = (($caractere_chiffre - 97 - $cle + 26) % 26) + 97;
            $message_dechiffre .= chr($caractere_dechiffre);
            // Si le caractère n'est pas une lettre, on le conserve tel quel
        } else {
            $message_dechiffre .= $message_chiffre[$i];
        }
    }
    return $message_dechiffre;
}
