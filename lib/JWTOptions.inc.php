<?php

     /**
     * JWT Options
     * This class represents all settings that directly interact with the JWT generation itsself.
     *
     * @author fachsimpeln
     * @category Options
     * @version jwt.core.options, v1.0, 2020-04-14
     */
     namespace EasyJWT;
     class JWTOptions
     {
          /** @var string Algorithm used for signing the token */
          public $jwt_algorithm;

          /**
          * Intializes the Options objects which contains the settings for the JWT object
          *
          * @param string $jwt_algorithm Algorithm to used for signing the token
          */
          public function __construct($jwt_algorithm = 'HS256')
          {
               // Validate algorithm
               $jwt_algorithm = strtoupper($jwt_algorithm);
               if (!in_array($jwt_algorithm, JWT::$JWTAlgorithmWhitelist)) {
                    $this->jwt_algorithm = 'HS256';
                    return;
               }
               $this->jwt_algorithm = $jwt_algorithm;
          }

          /**
          * Convert an object of this class to its JSON representation
          *
          * @param bool $fancy Option to pretty print the JSON (otherwise minified)
          * @return string JSON representation of an object of this class
          */
          public function toJson($fancy = false)
          {
               return JWTFunctions::ConvertToJSON($this->toArray(), $fancy);
          }

          /**
          * Convert an object of this class to an array
          *
          * @return array Array representation of an object of this class
          */
          public function toArray()
          {
               $j = array();
               $j['alg'] = $this->jwt_algorithm;
               $j['typ'] = 'JWT';

               return $j;
          }
     }


?>
