---
outline: deep
---

# States

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/countries/{iso}/states/{siso}`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Request Parameters

| Code     | In  | Description          | Required                           | Type   |
| -------- | --- | -------------------- | ---------------------------------- | ------ |
| \{iso\}  | URL | ISO2 Code of Country | <Badge type="danger" text="YES" /> | String |
| \{siso\} | URL | ISO2 Code of State   | <Badge type="danger" text="YES" /> | String |

## Query Parameters

| Code        | In  | Description                              | Required                        | Type   |
| ----------- | --- | ---------------------------------------- | ------------------------------- | ------ |
| \{allowed\} | URL | Comma separated list of allowed City IDs | <Badge type="info" text="NO" /> | String |
| \{banned\}  | URL | Comma separated list of banned City IDs  | <Badge type="info" text="NO" /> | String |

## Response Types

| Code | Description                                                          |
| ---- | -------------------------------------------------------------------- |
| 200  | Returns a list of all cities in the given state of the given country |
| 401  | Unauthorized                                                         |
| 404  | Not Found.                                                           |
| 429  | Rate limit exeeded                                                   |

## Example Usage

::: code-group

```js [javascript]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-Key", "API_KEY");

fetch(
    "https://naija-places.toneflix.com.ng/api/v1/countries/NG/states/AB/cities",
    options
)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/api/v1/countries/NG/states/AB/cities',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array(
    'X-Api-Key: API_KEY'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

```js [axios]
import axios from "axios";

axios
    .get("https://naija-places.toneflix.com.ng/api/v1/countries/NG/states/AB/cities", {
        headers: {
            X-Api-Key: "API_KEY",
        },
    })
    .then(({ data }) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });
```

```dart [dart]
var headers = {
  'X-Api-Key': 'API_KEY'
};

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/api/v1/countries/NG/states/AB/cities'));

request.headers.addAll(headers);

http.StreamedResponse response = await request.send();

if (response.statusCode == 200) {
  print(await response.stream.bytesToString());
} else {
  print(response.reasonPhrase);
}
```

:::

### 200 Success Response

```json
{
    "data": [
        {
            "id": 76744,
            "name": "Aba",
            "stateId": 303,
            "stateCode": "AB",
            "countryId": 161,
            "countryCode": "NG",
            "latitude": 5.10658,
            "longitude": 7.36667,
            "createdAt": "2019-10-05T23:10:40.000000Z",
            "updatedAt": "2019-10-05T23:10:40.000000Z",
            "flag": true,
            "wikiDataId": "Q202162"
        },
        {
            "id": 76769,
            "name": "Amaigbo",
            "stateId": 303,
            "stateCode": "AB",
            "countryId": 161,
            "countryCode": "NG",
            "latitude": 5.78917,
            "longitude": 7.83829,
            "createdAt": "2019-10-05T23:10:40.000000Z",
            "updatedAt": "2019-10-05T23:10:40.000000Z",
            "flag": true,
            "wikiDataId": "Q423831"
        },
        ...
    ],
    "status": "success",
    "message": "Data Fetched.",
    "statusCode": 200
}
```

### 401 Error Response

```json
{
    "data": {},
    "statusCode": 401,
    "message": "Unauthorized. You do not have access to this resource.",
    "status": "error"
}
```

### 404 Error Response

```json
{
    "data": {},
    "statusCode": 404,
    "message": "Country not found.",
    "status": "error"
}
```

### 404 Error Response

```json
{
    "data": {},
    "statusCode": 404,
    "message": "State not found.",
    "status": "error"
}
```

### 429 Error Response

```json
{
    "data": {},
    "statusCode": 429,
    "message": "Rate limit exeeded: you may try again in 54 seconds.",
    "status": "error"
}
```
