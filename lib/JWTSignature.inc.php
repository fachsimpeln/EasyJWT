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

               $whitelist = &JWT::$JWTAlgorithmWhitelist;
               if (!in_array($jwt_algorithm, $whitelist)) {
                    if ($jwt_algorithm === 'none') {
                         throw new Exception\SecurityException("The algorithm 'none' should not be used! This algorithm is therefore not whitelisted. If you know what you are doing, enable algorithm 'none' in the whitelist (configuration)");
                    }
                    throw new Exception\SecurityException("The selected algorithm '" . $jwt_algorithm . '\' is not whitelisted!');
               }

               if (JWT::$SECRET === 'PLEASE_CHANGE' && $jwt_algorithm !== 'none') {
                    throw new Exception\SecurityException("The secret key for signing the JWT has not been changed! Signature cannot be created.");
               }

               $data_to_sign = JWTFunctions::Base64URLEncode($jwt_options->toJson()) . '.' .  JWTFunctions::Base64URLEncode($jwt_data_json);

               switch ($jwt_algorithm) {
                    case 'HS256':
                         return hash_hmac('sha256', $data_to_sign, JWT::$SECRET, true);
                    case 'HS512':
                         return hash_hmac('sha512', $data_to_sign, JWT::$SECRET, true);
                    case 'HS384':
                         return hash_hmac('sha384', $data_to_sign, JWT::$SECRET, true);

                    case 'none':
                         if (JWT::$SECRET !== 'PLEASE_CHANGE') {
                              throw new Exception\SecurityException("The algorithm 'none' should not be used! You have set a secret for signing, therefor the \"algorithm\" none is blocked by default. If you know what you are doing, set the secret in the configuration to 'PLEASE_CHANGE'");
                         }
                         trigger_error("Signature Algorithm 'none' selected. This is a potential SECURITY RISK. It is strongly recommended to use another algorithm!", E_USER_WARNING);

                         return '';
                    default:
                         // default to HS256
                         return hash_hmac('sha256', $data_to_sign, JWT::$SECRET, true);
               }
          }

          /**
          * Verifies the signature of a specific JWT data container object using the static key from JWT
          *
          * @param JWTData $jwt_data JWT Data container object of which the signature is to verify
          * @param JWT $jwt JWT object to enable access to the JWTData data
          * @return bool Returns true when signature is valid
          */
          public static function VerifySignature($jwt_data, $jwt)
          {

               $whitelist = &JWT::$JWTAlgorithmWhitelist;

               $jwt_algorithm = $jwt_data->JWTOptions->jwt_algorithm;

               if (!in_array($jwt_algorithm, $whitelist)) {
                    return false;
               }

               if (JWT::$SECRET === 'PLEASE_CHANGE' && $jwt_algorithm !== 'none') {
                    throw new Exception\SecurityException("The secret key for signing the JWT has not been changed! Signature cannot be verified.");
               }

               $data_to_sign = JWTFunctions::Base64URLEncode($jwt_data->JWTOptions->toJson()) . '.' .  JWTFunctions::Base64URLEncode($jwt_data->returnDataJSON($jwt));

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
                         if (JWT::$SECRET !== 'PLEASE_CHANGE') {
                              throw new Exception\SecurityException("The algorithm 'none' should not be used! You have set a secret for signing, therefor the \"algorithm\" none is blocked by default. If you know what you are doing, set the secret in the configuration to 'PLEASE_CHANGE'");
                         }
                         trigger_error("Signature Algorithm 'none' selected. This is a potential SECURITY RISK. It is strongly recommended to use another algorithm!", E_USER_WARNING);

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
