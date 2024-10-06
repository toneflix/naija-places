---
outline: deep
---

# Local Government Areas

<Badge type="warning" text="GET" /> `https://ng-places.toneflix.com.ng/api/v1/states/{siso}/lgas`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
Name: X-Api-Key: API_KEY
In: header
```

## Request Parameters

| Code     | In  | Description        | Required                           | Type   |
| -------- | --- | ------------------ | ---------------------------------- | ------ |
| \{siso\} | URL | ISO2 Code of State | <Badge type="danger" text="YES" /> | String |

## Response Types

| Code | Description                                                      |
| ---- | ---------------------------------------------------------------- |
| 200  | Returns a list of all Local Government Areas for the given state |
| 401  | Unauthorized.                                                    |
| 404  | Not Found.                                                       |
| 429  | Rate limit exeeded                                               |

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

fetch("https://naija-places.toneflix.com.ng/v1/states/ab/lgas", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/v1/states/ab/lgas',
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
    .get("https://naija-places.toneflix.com.ng/v1/states/ab/lgas", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/v1/states/ab/lgas'));

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
            "id": 251,
            "slug": "aninri",
            "name": "Aninri",
            "code": "DBR",
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 252,
            "slug": "awgu",
            "name": "Awgu",
            "code": "AWG",
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 253,
            "slug": "enugu-east",
            "name": "Enugu East",
            "code": "NKW",
            "state": "Enugu",
            "stateId": 14
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

### 429 Error Response

```json
{
    "data": {},
    "statusCode": 429,
    "message": "Rate limit exeeded: you may try again in 54 seconds.",
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
