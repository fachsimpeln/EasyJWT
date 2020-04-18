<?php

     require __DIR__ . DIRECTORY_SEPARATOR  . 'JWTConfig.php';

     /* =========== WRITE JWT ============ */

     // Sample array
     $sample_array = array();
     $sample_array['id'] = '0';
     $sample_array['name'] = 'fachsimpeln';

     // Reserved claims
     $jwt_r_claims = new EasyJWT\JWTReservedClaims();

     // Expire in 30 seconds
     $jwt_r_claims->SetClaim('EXP', time() + 30);
     // Be valid in 5 seconds, not immediately
     $jwt_r_claims->SetClaim('NBF', time() + 5);
     // Issuer name
     $jwt_r_claims->SetClaim('ISS', 'localhost');


     // Options for the JWT (method)
     $jwt_options = new EasyJWT\JWTOptions('HS512', $jwt_r_claims, true);

     // Set data to JWTData object
     $jwt_data = new EasyJWT\JWTData($sample_array, $jwt_options);
          /*
               For encryption:
               $jwt_data = new EasyJWT\JWTDataEncrypted($sample_array, $jwt_options);
          */

     // Create new JWT object to interact with JWT
     $jwt = new EasyJWT\JWT($jwt_data);

     // Send the JWT as a cookie to the user's browser
     $jwt->SetJWT(); // $jwt->toString();

     // Reset $jwt_data
     $jwt_data = null;

     /* =========== READ JWT ============ */

     // Read directly from cookie
     $jwt_data = new EasyJWT\JWTData();
          /*
               Read from string ($value)
               $jwt_data = new EasyJWT\JWTData($value);


               For encryption:
               $jwt_data = new EasyJWT\JWTDataEncrypted();
               or
               $jwt_data = new EasyJWT\JWTDataEncrypted($enc_value);
          */

     // Create new JWT object to validate signature, validate reserved claims and interact with JWT
     $jwt = new EasyJWT\JWT($jwt_data);

     // Check success (returns false when anything is invalid)
     if ($jwt->IsValid()) {
          print 'Valid!<br>';
     } else {
          print 'Invalid!';
          die();
     }

     // Read main content (body) as array from JWT
          // Returns null on error
     $sample_array = $jwt->GetData(); // $jwt->GetJWT(); $jwt->d();

     // Show the contents of the JWT
     var_dump($sample_array);
?>
