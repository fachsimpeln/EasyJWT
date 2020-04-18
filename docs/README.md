# JWT

## Table of Contents

* [ClaimException](#claimexception)
* [CookieException](#cookieexception)
* [EncryptionException](#encryptionexception)
* [InvalidSignatureException](#invalidsignatureexception)
* [JWT](#jwt)
    * [__construct](#__construct)
    * [IsValid](#isvalid)
    * [GetData](#getdata)
    * [GetJWT](#getjwt)
    * [d](#d)
    * [SetJWT](#setjwt)
    * [toString](#tostring)
    * [RemoveJWT](#removejwt)
* [JWTCookie](#jwtcookie)
    * [SetCookie](#setcookie)
    * [GetCookie](#getcookie)
    * [RemoveCookie](#removecookie)
* [JWTData](#jwtdata)
    * [__construct](#__construct-1)
    * [toCookie](#tocookie)
    * [returnData](#returndata)
    * [returnDataJSON](#returndatajson)
    * [GetCreated](#getcreated)
* [JWTDataEncrypted](#jwtdataencrypted)
    * [__construct](#__construct-2)
    * [toCookie](#tocookie-1)
    * [returnData](#returndata-1)
    * [returnDataJSON](#returndatajson-1)
    * [GetCreated](#getcreated-1)
* [JWTEncryption](#jwtencryption)
    * [EncryptText](#encrypttext)
    * [DecryptText](#decrypttext)
* [JWTFunctions](#jwtfunctions)
    * [Base64URLEncode](#base64urlencode)
    * [Base64URLDecode](#base64urldecode)
    * [ConvertToJSON](#converttojson)
    * [ConvertFromJSON](#convertfromjson)
* [JWTOptions](#jwtoptions)
    * [__construct](#__construct-3)
    * [toJson](#tojson)
    * [toArray](#toarray)
* [JWTSignature](#jwtsignature)
    * [CreateSignature](#createsignature)
    * [VerifySignature](#verifysignature)
* [MalformedInputException](#malformedinputexception)
* [RegisteredClaimException](#registeredclaimexception)
* [SecurityException](#securityexception)

## ClaimException





* Full name: \EasyJWT\Exception\ClaimException
* Parent class: \Exception


## CookieException





* Full name: \EasyJWT\Exception\CookieException
* Parent class: \Exception


## EncryptionException





* Full name: \EasyJWT\Exception\EncryptionException
* Parent class: \Exception


## InvalidSignatureException





* Full name: \EasyJWT\Exception\InvalidSignatureException
* Parent class: \Exception


## JWT





* Full name: \EasyJWT\JWT


### __construct

Creates new JWT object, that provides the verification and management of any JWT.

```php
JWT::__construct( \EasyJWT\JWTData $jwt_data )
```

First, the constructor verifies that the signature is valid, then it saves the data object.
**WARNING: Before any interaction with the data of a JWT, create a JWT object to verify that the data is valid!**


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$jwt_data` | **\EasyJWT\JWTData** | The data container (required) |




---

### IsValid

Returns if the data is valid

```php
JWT::IsValid(  ): boolean
```





**Return Value:**

True when valid, False when invalid



---

### GetData

Returns the data of the JWTData object

```php
JWT::GetData(  ): array|null
```





**Return Value:**

Array containing the data of the JWTData object



---

### GetJWT

Alias for GetData

```php
JWT::GetJWT(  ): array|null
```





**Return Value:**

Array containing the data of the JWTData object



---

### d

Alias for GetData

```php
JWT::d(  ): array|null
```





**Return Value:**

Array containing the data of the JWTData object



---

### SetJWT

Sends the current JWT Data container object to the user's browser as a cookie

```php
JWT::SetJWT(  ): boolean
```





**Return Value:**

Returns if the cookie was successfully set



---

### toString

Returns the string representation of the JWT

```php
JWT::toString(  ): string|boolean
```





**Return Value:**

String representation of the JWT, on error false



---

### RemoveJWT

Removes the JWT cookie from the user's browser

```php
JWT::RemoveJWT(  )
```







---

## JWTCookie





* Full name: \EasyJWT\JWTCookie


### SetCookie

Sets a cookie to the user's browser

```php
JWTCookie::SetCookie( string $key, string $value, boolean $ssl = false, boolean $httpOnly = true, integer $expires )
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** | Key for the cookie (e.g. JWT) |
| `$value` | **string** | Value for the cookie (e.g. eyJhbGciOiJ...) |
| `$ssl` | **boolean** | Only over HTTPS (Standard: false) |
| `$httpOnly` | **boolean** | Cookie only accessible through the HTTP-protocol (Standard: true) |
| `$expires` | **integer** | Cookie expiration as UNIX timestamp (standard: 14days) |




---

### GetCookie

Gets cookie value from key

```php
JWTCookie::GetCookie( string $key ): string|null
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** | Key for the cookie (e.g. JWT) |


**Return Value:**

Value of the cookie



---

### RemoveCookie

Removes a cookie

```php
JWTCookie::RemoveCookie( string $key )
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | **string** | Key for the cookie (e.g. JWT) |




---

## JWTData





* Full name: \EasyJWT\JWTData


### __construct

Creates new JWT data container object, that contains the options (header), the data and the signature. The signature is created upon creation.

```php
JWTData::__construct( array|string|null $jwt_data = null, \EasyJWT\JWTOptions|null $jwt_options = null )
```

If no data is given, the constructor attempts to get the JWT Cookie


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$jwt_data` | **array&#124;string&#124;null** | The data (main content) as array for the JWT (no reserved claim names!); if string it takes it instead of trying to read the cookie |
| `$jwt_options` | **\EasyJWT\JWTOptions&#124;null** | JWT Options object which contains the header and other settings |




---

### toCookie

Joins the JSON data from the attributes to the JWT standard
Uses base64url on every component and join the strings with a dot (.)

```php
JWTData::toCookie(  ): string
```





**Return Value:**

JWT cookie value as string



---

### returnData

Returns the data (body) of the JWTData object.

```php
JWTData::returnData( object $caller ): string
```

Cannot be accessed by the software, only by an object of JWT


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$caller` | **object** | The caller as a object ($this) |


**Return Value:**

JWT cookie value as string



---

### returnDataJSON

Returns the data (body) JSON encoded of the JWTData object.

```php
JWTData::returnDataJSON( object $caller ): string
```

Cannot be accessed by the software, only by an object of JWT


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$caller` | **object** | The caller as a object ($this) |


**Return Value:**

JWT cookie value as JSON-encoded string



---

### GetCreated

Returns if the object was created by an existing JWT or new
Cannot be accessed by the software, only by an object of JWT

```php
JWTData::GetCreated( object $caller ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$caller` | **object** | The caller as a object ($this) |


**Return Value:**

Created new or not



---

## JWTDataEncrypted





* Full name: \EasyJWT\JWTDataEncrypted
* Parent class: \EasyJWT\JWTData


### __construct

Creates new JWT data container object, that contains the options (header), the data and the signature. The signature is created upon creation.

```php
JWTDataEncrypted::__construct( array|string|null $jwt_data = null, \EasyJWT\JWTOptions|null $jwt_options = null )
```

If no data is given, the constructor attempts to get the JWT Cookie
(VERSION WITH ENCRYPTION)


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$jwt_data` | **array&#124;string&#124;null** | The data (main content) as array for the JWT; if string it takes it instead of trying to read the cookie |
| `$jwt_options` | **\EasyJWT\JWTOptions&#124;null** | JWT Options object which contains the header and other settings |




---

### toCookie

Joins the JSON data from the attributes to the JWT standard and encrypts them
Uses base64url on every component and join the strings with a dot (.)

```php
JWTDataEncrypted::toCookie(  ): string
```





**Return Value:**

JWT cookie value as an encrypted string



---

### returnData

Returns the data (body) of the JWTData object.

```php
JWTDataEncrypted::returnData( object $caller ): string
```

Cannot be accessed by the software, only by an object of JWT


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$caller` | **object** | The caller as a object ($this) |


**Return Value:**

JWT cookie value as string



---

### returnDataJSON

Returns the data (body) JSON encoded of the JWTData object.

```php
JWTDataEncrypted::returnDataJSON( object $caller ): string
```

Cannot be accessed by the software, only by an object of JWT


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$caller` | **object** | The caller as a object ($this) |


**Return Value:**

JWT cookie value as JSON-encoded string



---

### GetCreated

Returns if the object was created by an existing JWT or new
Cannot be accessed by the software, only by an object of JWT

```php
JWTDataEncrypted::GetCreated( object $caller ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$caller` | **object** | The caller as a object ($this) |


**Return Value:**

Created new or not



---

## JWTEncryption





* Full name: \EasyJWT\JWTEncryption


### EncryptText

Encrypts a given plaintext with a key (with AES256 in CBC mode)

```php
JWTEncryption::EncryptText( string $plaintext, string $key ): string
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plaintext` | **string** | Plaintext to be encrypted (clear JWT-Cookie-Data) |
| `$key` | **string** | Cryptographically secure key used for the encryption |


**Return Value:**

Encrypted plaintext (in base64url format, values separated by |)



---

### DecryptText

Decrypts a given ciphertext with a key

```php
JWTEncryption::DecryptText( string $ciphertext, string $key ): string
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ciphertext` | **string** | Ciphertext in base64url format, values separated by &#124; |
| `$key` | **string** | Cryptographically secure key used for the decryption |


**Return Value:**

Decrypted plaintext



---

## JWTFunctions





* Full name: \EasyJWT\JWTFunctions


### Base64URLEncode

Encodes a string to base64url

```php
JWTFunctions::Base64URLEncode( string $string ): string
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string** | String to be encoded |


**Return Value:**

base64url representation of the string



---

### Base64URLDecode

Decodes a string from base64url

```php
JWTFunctions::Base64URLDecode( string $string ): string
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string** | base64url representation of the string |


**Return Value:**

Decoded string



---

### ConvertToJSON

Converts a given array to a JSON string

```php
JWTFunctions::ConvertToJSON( array $data, boolean $fancy = false ): string
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | **array** | Data to be converted in a JSON string |
| `$fancy` | **boolean** | Option to pretty print the JSON (otherwise minified) |


**Return Value:**

JSON string



---

### ConvertFromJSON

Converts a given string from JSON to an array

```php
JWTFunctions::ConvertFromJSON( string $data ): array
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | **string** | Data to be converted from a JSON string |


**Return Value:**

Converted JSON string as array



---

## JWTOptions





* Full name: \EasyJWT\JWTOptions


### __construct

Intializes the Options objects which contains the settings for the JWT object

```php
JWTOptions::__construct( string $jwt_algorithm = "HS256",  $jwt_reserved_claims = null, boolean $allow_private_claims = true )
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$jwt_algorithm` | **string** | Algorithm to used for signing the token |
| `$jwt_reserved_claims` | **** |  |
| `$allow_private_claims` | **boolean** | Restricts claim names to those specified in the IANA JSON Web Token Registry when set to false |




---

### toJson

Convert an object of this class to its JSON representation

```php
JWTOptions::toJson( boolean $fancy = false ): string
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$fancy` | **boolean** | Option to pretty print the JSON (otherwise minified) |


**Return Value:**

JSON representation of an object of this class



---

### toArray

Convert an object of this class to an array

```php
JWTOptions::toArray(  ): array
```





**Return Value:**

Array representation of an object of this class



---

## JWTSignature





* Full name: \EasyJWT\JWTSignature


### CreateSignature

Creates the signature to a specific JWT data and header using the static key from JWT

```php
JWTSignature::CreateSignature( string $jwt_data_json, \EasyJWT\JWTOptions $jwt_options ): \EasyJWT\raw
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$jwt_data_json` | **string** | Data to be saved in the JWT as JSON |
| `$jwt_options` | **\EasyJWT\JWTOptions** | Options (header) for the JWT containing the algorithm |


**Return Value:**

Resulting signature in raw



---

### VerifySignature

Verifies the signature of a specific JWT data container object using the static key from JWT

```php
JWTSignature::VerifySignature( \EasyJWT\JWTData $jwt_data, \EasyJWT\JWT $jwt ): boolean
```



* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$jwt_data` | **\EasyJWT\JWTData** | JWT Data container object of which the signature is to verify |
| `$jwt` | **\EasyJWT\JWT** | JWT object to enable access to the JWTData data |


**Return Value:**

Returns true when signature is valid



---

## MalformedInputException





* Full name: \EasyJWT\Exception\MalformedInputException
* Parent class: \Exception


## RegisteredClaimException





* Full name: \EasyJWT\Exception\RegisteredClaimException
* Parent class: \Exception


## SecurityException





* Full name: \EasyJWT\Exception\SecurityException
* Parent class: \Exception




--------
> This document was automatically generated from source code comments on 2020-04-18 using [phpDocumentor](http://www.phpdoc.org/) and [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public)
