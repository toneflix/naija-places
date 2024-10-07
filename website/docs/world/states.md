---
outline: deep
---

# States

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/countries/{iso}/states`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Request Parameters

| Code    | In  | Description          | Required                           | Type   |
| ------- | --- | -------------------- | ---------------------------------- | ------ |
| \{iso\} | URL | ISO2 Code of Country | <Badge type="danger" text="YES" /> | String |

## Response Types

| Code | Description                                       |
| ---- | ------------------------------------------------- |
| 200  | Returns a list of all states in the given country |
| 401  | Unauthorized                                      |
| 404  | Not Found.                                        |
| 429  | Rate limit exeeded                                |

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
    "https://naija-places.toneflix.com.ng/api/v1/countries/NG/states",
    options
)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/api/v1/countries/NG/states',
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
    .get("https://naija-places.toneflix.com.ng/api/v1/countries/NG/states", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/api/v1/countries/NG/states'));

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
            "id": 303,
            "name": "Abia",
            "countryId": 161,
            "countryCode": "NG",
            "fipsCode": "45",
            "iso2": "AB",
            "type": "state",
            "latitude": 5.4527354,
            "longitude": 7.5248414,
            "createdAt": "2019-10-05T21:48:37.000000Z",
            "updatedAt": "2021-10-11T10:37:55.000000Z",
            "flag": true,
            "wikiDataId": "Q320852"
        },
        {
            "id": 293,
            "name": "Abuja Federal Capital Territory",
            "countryId": 161,
            "countryCode": "NG",
            "fipsCode": "11",
            "iso2": "FC",
            "type": "capital territory",
            "latitude": 8.8940691,
            "longitude": 7.1860402,
            "createdAt": "2019-10-05T21:48:37.000000Z",
            "updatedAt": "2021-10-11T10:38:07.000000Z",
            "flag": true,
            "wikiDataId": "Q509300"
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

### 429 Error Response

```json
{
    "data": {},
    "statusCode": 429,
    "message": "Rate limit exeeded: you may try again in 54 seconds.",
    "status": "error"
}
```
