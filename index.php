<?php
// Fonction pour créer la matrice de Vigenère
function createVigenereMatrix($key)
{
    $matrix = array();
    $alphabet = range('A', 'Z');
    $keyLength = strlen($key);

    for ($i = 0; $i < 26; $i++) {
        $keyIndex = $i % $keyLength;
        $currentRow = array();
        for ($j = 0; $j < 26; $j++) {
            $currentLetter = $alphabet[($j + $i) % 26];
            $currentRow[] = $currentLetter;
        }
        $matrix[] = $currentRow;
    }

    return $matrix;
}

// Fonction pour chiffre un message avec la matrice de Vigenère
function encryptWithVigenereMatrix($message, $key)
{
    $vigenereMatrix = createVigenereMatrix($key);
    $encryptedMessage = "";
    $keyIndex = 0;
    for ($i = 0; $i < strlen($message); $i++) {
        // Si le caractère est une lettre majuscule
        if (ctype_upper($message[$i])) {
            // Récupère les index correspondants dans la matrice de Vigenère
            $rowIndex = ord($key[$keyIndex]) - 65;
            $columnIndex = ord($message[$i]) - 65;
            // Ajoute la lettre chiffrée au message
            $encryptedMessage .= $vigenereMatrix[$rowIndex][$columnIndex];
            // Incrémente l'index de la clé
            $keyIndex = ($keyIndex + 1) % strlen($key);
        } else {
            // Si le caractère n'est pas une lettre majuscule, on l'ajoute tel quel au message chiffré
            $encryptedMessage .= $message[$i];
        }
    }
    return $encryptedMessage;
}

// Fonction pour déchiffrer un message chiffré avec la matrice de Vigenère
function decryptWithVigenereMatrix($encryptedMessage, $key)
{
    $vigenereMatrix = createVigenereMatrix($key);
    $decryptedMessage = "";
    $keyIndex = 0;
    for ($i = 0; $i < strlen($encryptedMessage); $i++) {
        // Si le caractère est une lettre majuscule
        if (ctype_upper($encryptedMessage[$i])) {
            // Récupère l'index de la ligne correspondant à la clé dans la matrice de Vigenère
            $rowIndex = ord($key[$keyIndex]) - 65;
            // Récupère l'index de la colonne correspondant à la lettre chiffrée dans la ligne
            $columnIndex = array_search($encryptedMessage[$i], $vigenereMatrix[$rowIndex]);
            // Ajoute la lettre déchiffrée au message
            $decryptedMessage .= chr($columnIndex + 65);
            // Incrémente l'index de la clé
            $keyIndex = ($keyIndex + 1) % strlen($key);
        } else {
            // Si le caractère n'est pas une lettre majuscule, on l'ajoute tel quel au message déchiffré
            $decryptedMessage .= $encryptedMessage[$i];
        }
    }
    return $decryptedMessage;
}

// Exemple d'utilisation
$message = "MAISON";
$key = "CLE";
$encryptedMessage = encryptWithVigenereMatrix($message, $key);
// Exemple d'utilisation (suite)
$decryptedMessage = decryptWithVigenereMatrix($encryptedMessage, $key);

// Affiche le message d'origine, le message chiffré et le message déchiffré
echo "Message d'origine : " . $message . "\n";
echo "Message chiffré : " . $encryptedMessage . "\n";
echo "Message déchiffré : " . $decryptedMessage . "\n";
