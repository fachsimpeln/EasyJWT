<?php

     /**
     * JWT Signature Generator & Verifier
     * This class generates the signatures for the JWTs and also verifies them.
     *
     * @author fachsimpeln
     * @category Signature
     * @version jwt.core.signature, v1.0, 2020-04-14
     */
     namespace EasyJWT;
     class JWTSignature
     {

          /**
          * Creates the signature to a specific JWT data and header using the static key from JWT
          *
          * @param string $jwt_data_json Data to be saved in the JWT as JSON
          * @param JWTOptions $jwt_options Options (header) for the JWT containing the algorithm
          * @return raw Resulting signature in raw
          */
          public static function CreateSignature($jwt_data_json, $jwt_options)
          {

               $jwt_algorithm = $jwt_options->jwt_algorithm;

               $data_to_sign = JWTFunctions::Base64URLEncode($jwt_options->toJson()) . '.' .  JWTFunctions::Base64URLEncode($jwt_data_json);

               switch ($jwt_algorithm) {
                    case 'HS256':
                         return hash_hmac('sha256', $data_to_sign, JWT::$SECRET, true);
                    case 'HS512':
                         return hash_hmac('sha512', $data_to_sign, JWT::$SECRET, true);
                    case 'HS384':
                         return hash_hmac('sha384', $data_to_sign, JWT::$SECRET, true);

                    case 'none':
                         return '';
                    default:
                         // default to HS256
                         return hash_hmac('sha256', $data_to_sign, JWT::$SECRET, true);
                         break;
               }
          }

          /**
          * Verifies the signature of a specific JWT data container object using the static key from JWT
          *
          * @param JWTData $jwt_data JWT Data container object of which the signature is to verify
          * @return bool Returns true when signature is valid
          */
          public static function VerifySignature($jwt_data)
          {

               $whitelist = &JWT::$JWTAlgorithmWhitelist;

               $jwt_algorithm = $jwt_data->JWTOptions->jwt_algorithm;

               if (!in_array($jwt_algorithm, $whitelist)) {
                    return false;
               }

               $data_to_sign = JWTFunctions::Base64URLEncode($jwt_data->JWTOptions->toJson()) . '.' .  JWTFunctions::Base64URLEncode($jwt_data->JWTData_JSON);

               switch ($jwt_algorithm) {
                    case 'HS256':
                         $generated_hash = hash_hmac('sha256', $data_to_sign, JWT::$SECRET, true);
                         break;
                    case 'HS512':
                         $generated_hash = hash_hmac('sha512', $data_to_sign, JWT::$SECRET, true);
                         break;
                    case 'HS384':
                         $generated_hash = hash_hmac('sha384', $data_to_sign, JWT::$SECRET, true);
                         break;

                    case 'none':
                         $generated_hash = '';
                         break;
                    default:
                         return false;
               }

               if (!hash_equals($generated_hash, $jwt_data->JWTSign)) {
                    return false;
               }

               return true;
          }

     }


?>
