<?php

     /**
      * JWT Encryption
      * This class handles the encryption/decryption for the JWT-String.
      *
      * @author fachsimpeln
      * @category Encryption system
      * @version jwt.system.encryption, v1.0, 2020-04-14
      */
     namespace EasyJWT;
     class JWTEncryption
     {
          /**
          * Encrypts a given plaintext with a key (with AES256 in CBC mode)
          *
          * @param string $plaintext Plaintext to be encrypted (clear JWT-Cookie-Data)
          * @param string $key Cryptographically secure key used for the encryption
          * @return string Encrypted plaintext (in base64url format, values separated by |)
          */
          public static function EncryptText($plaintext, $key)
          {
               // Set cipher to AES256 in CBC mode (req. PHP 7.1)
               $cipher = "aes-256-gcm";
               // Check if PHP has access to that mode
               if (in_array($cipher, openssl_get_cipher_methods()))
               {
                    // Determine the length for the iv
                    $ivlen = openssl_cipher_iv_length($cipher);
                    // Generate a new iv with the length required for the mode
                    $iv = openssl_random_pseudo_bytes($ivlen);

                    // Encrypt the $plaintext with these options and the key $key
                    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);

                    // Join all required informations together with | as the seperator and base64url encode them
                    return JWTFunctions::Base64URLEncode($cipher . '|' . $iv . '|' . $tag . '|' . $ciphertext);

               }
               // In case of an error, throw encryption error
               throw new Exception\EncryptionException('Cipher Method not available: ' . $cipher);
               return;
          }

          /**
          * Decrypts a given ciphertext with a key
          *
          * @param string $ciphertext Ciphertext in base64url format, values separated by |
          * @param string $key Cryptographically secure key used for the decryption
          * @return string Decrypted plaintext
          */
          public static function DecryptText($ciphertext, $key)
          {
               // base64url decode the ciphertext
               $ciphertext = JWTFunctions::Base64URLDecode($ciphertext);
               // Split the decoded ciphertext at the seperator |
               $ciphertext = explode('|', $ciphertext);

               // Set the variables to the right index of the ciphertext
               $cipher = $ciphertext[0];
               $iv = $ciphertext[1];
               $tag = $ciphertext[2];
               $ciphertext = $ciphertext[3];

               // Check if PHP has access to the mode saved in $cipher
               if (in_array($cipher, openssl_get_cipher_methods()))
               {
                    $ivlen = openssl_cipher_iv_length($cipher);
                    // Check if the length of the given iv matches the required length for that algorithm
                    if (strlen($iv) !== $ivlen) {
                         throw new Exception\EncryptionException('IV Length doesn\'t match the required IV length for ' . $cipher . ' (encryption method)');
                         return;
                    }

                    // Decrypt the ciphertext
                    $plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
                    // Return the decrypted text

                    if ($plaintext == false) {
                         return false;
                    }

                    return $plaintext;
               }
               // In case of an error, throw encryption error
               throw new Exception\EncryptionException('Cipher Method not available: ' . $cipher);
               return;
          }

     }


?>
