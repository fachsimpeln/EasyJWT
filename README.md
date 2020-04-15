# EasyJWT
> A easy-to-use implementation of of JWT Standard (JSON Web Tokens)

## What is JWT?
JSON Web Token (JWT [...]) is an internet standard for creating JSON-based access tokens. [...]
For example, a server could generate a token that has the claim "logged in as admin" and provide that to a client. The client could then use that token to prove that it is logged in as admin. The tokens can be signed by one party's private key (usually the server's) so that party can subsequently verify the token is legitimate. If the other party, by some suitable and trustworthy means, is in possession of the corresponding public key, they too are able to verify the token's legitimacy. The tokens are designed to be compact, URL-safe, and usable especially in a web-browser single-sign-on (SSO) context. JWT claims can typically be used to pass identity of authenticated users between an identity provider and a service provider, or any other type of claims as required by business processes.

~ taken from [Wikipedia](https://en.wikipedia.org/w/index.php?title=JSON_Web_Token&oldid=949805010)

## Why EasyJWT?
EasyJWT is intended to provide a version of JWT that is particularly easy to implement.
So far only the easy to understand symmetric signing methods are used.

The library also supports the symmetric encryption of the JWT token with AES (using openssl), if confidential or sensitive information is to be stored in JWT.

## Install via Composer
```bash
composer require fachsimpeln/easyjwt
```

## Example Code
### Create a new JWT
```php
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
```

### Read a JWT from cookies
```php
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
```

### More
These examples can also be found in the folder sample/

## Supported Algorithms
Signing Algorithm | What is this? 
-------- | --------
HS256   | HMAC-SHA256
HS384   | HMAC-SHA384
HS512   | HMAC-SHA512
none    | not recommended


Encryption Algorithm | What is this? 
-------- | --------
AES-256-GCM   | OpenSSL AES Encryption

## Documentation
The documentation for the code can be found in [docs/](https://github.com/fachsimpeln/EasyJWT/tree/master/docs)

Usage documentation can be found in the [Wiki](https://github.com/fachsimpeln/EasyJWT/wiki)


## Automated Tests
[![CodeFactor](https://www.codefactor.io/repository/github/fachsimpeln/easyjwt/badge)](https://www.codefactor.io/repository/github/fachsimpeln/easyjwt)
