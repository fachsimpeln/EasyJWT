<?php
     /**
     * JWT Functions
     * This class has often used functions like base64url or a JSON Converter (for easy use all methods are static)
     *
     * @author fachsimpeln
     * @category Functions
     * @version jwt.system.functions, v1.0, 2020-04-14
     */
     namespace EasyJWT;
     class JWTFunctions
     {
          /**
          * Encodes a string to base64url
          *
          * @param string $string String to be encoded
          * @return string base64url representation of the string
          */
          public static function Base64URLEncode($string) {
               return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
          }

          /**
          * Decodes a string from base64url
          *
          * @param string $string base64url representation of the string
          * @return string Decoded string
          */
          public static function Base64URLDecode($string) {
               return base64_decode(str_replace(['-','_'], ['+','/'], $string));
          }

          /**
          * Converts a given array to a JSON string
          *
          * @param array $data Data to be converted in a JSON string
          * @param bool $fancy Option to pretty print the JSON (otherwise minified)
          * @return string JSON string
          */
          public static function ConvertToJSON($data, $fancy = false)
          {
               if ($fancy) {
                    return json_encode($data, JSON_PRETTY_PRINT);
               }
               return json_encode($data);
          }

          /**
          * Converts a given string from JSON to an array
          *
          * @param string $data Data to be converted from a JSON string
          * @return array Converted JSON string as array
          */
          public static function ConvertFromJSON($data)
          {
               return json_decode($data, true);
          }

     }


?>
