<?php

     require '../vendor/autoload.php';

     /* =========== INITIALIZE JWT AND CONFIGURE ============ */
     EasyJWT\JWT::$SECRET = 'PLEASE_CHANGE';
     EasyJWT\JWT::$ENCRYPTION_KEY = 'PLEASE_CHANGE';


     EasyJWT\JWT::$JWTAlgorithmWhitelist = ['HS256', 'HS512', 'HS384'];

     EasyJWT\JWT::$JWT_COOKIE_NAME = 'EasyJWT';
     EasyJWT\JWT::$SSL = false;
     EasyJWT\JWT::$HTTP_ONLY = true;


     /* =========== WRITE JWT ============ */

     // Sample array
     $sample_array = array();
     $sample_array['id'] = '0';
     $sample_array['name'] = 'fachsimpeln';

     // Options for the JWT (method)
     $jwt_options = new EasyJWT\JWTOptions('HS512');

     // Set data to JWTData object
     $jwt_data = new EasyJWT\JWTData($sample_array, $jwt_options);
          /*
               For encryption:
               $data = new EasyJWT\JWTDataEncrypted($sample_array, $jwt_options);
          */

     // Create new JWT object to interact with JWT
     $jwt = new EasyJWT\JWT($jwt_data);

     // Send the JWT as a cookie to the user's browser
     $jwt->SetJWT();

     /* =========== READ JWT ============ */

     // Read directly from cookie
     $jwt_data = new EasyJWT\JWTData();
          /*
               Read from string ($value)
               $jwt_data = new EasyJWT\JWTData($value);
          */

     // Create new JWT object to validate signature and interact with JWT
     $jwt = new EasyJWT\JWT($jwt_data);

     // Check success (returns false when signature is invalid)
     if ($jwt->IsValid()) {
          echo 'Valid!';
     } else {
          echo 'Invalid!';
          die();
     }

     // Read main content (body) as array from JWT
          // Returns null on error
     $sample_array = $jwt->GetData(); // $jwt->GetJWT(); $jwt->d();

?>
