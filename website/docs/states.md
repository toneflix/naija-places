---
outline: deep
---

# States

<Badge type="warning" text="GET" /> `https://ng-places.toneflix.com.ng/api/v1/states`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-key: API_KEY
In: header
```

## Request Parameters

This endpoint does not require any parameters

## Response Types

| Code | Description                  |
| ---- | ---------------------------- |
| 200  | Returns a list of all states |
| 401  | Unauthorized                 |
| 429  | Rate limit exeeded           |

## Example Usage

::: code-group

```js [javascript]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-key", "API_KEY");

fetch("https://naija-places.toneflix.ng/v1/states", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.ng/v1/states',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer API_KEY'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

```js [axios]
import axios from "axios";

axios
    .get("https://naija-places.toneflix.ng/v1/states", {
        headers: {
            Authorization: "Bearer API_KEY",
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
  'Authorization': 'Bearer API_KEY'
};

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.ng/v1/states'));

request.headers.addAll(headers);

http.StreamedResponse response = await request.send();

if (response.statusCode == 200) {
  print(await response.stream.bytesToString());
} else {
  print(response.reasonPhrase);
}
```

:::

### Success Response

```json
{
    "data": [
        {
            "id": 1,
            "slug": "abia",
            "name": "Abia",
            "code": "AB"
        },
        {
            "id": 2,
            "slug": "adamawa",
            "name": "Adamawa",
            "code": "AD"
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
