google-api-php
============
VERY simple api wrapper for Google API

API Reference
-------------
Google

Example
-------
```php
$c = new GoogleApi\CivicInfo($api_key);
$c->elections();

$c->voterInfo(4005, null, array('address' => 'CA');
```