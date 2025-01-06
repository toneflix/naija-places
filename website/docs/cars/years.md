---
outline: deep
---

# Make Years

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/vehicle/years`

OR BY Origin/Country

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/vehicle/countries/{cid}/years`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Main Request Parameters

This endpoint does not require any parameters.

## Origin/Country Request Parameters

| Code    | In  | Description   | Required                           | Type   |
| ------- | --- | ------------- | ---------------------------------- | ------ |
| \{cid\} | URL | ID of Country | <Badge type="danger" text="YES" /> | String |

## Request Query

| Key     | In        | Description            | Required                        | Type   | Example   |
| ------- | --------- | ---------------------- | ------------------------------- | ------ | --------- |
| \{min\} | URL Query | Minimum Year to return | <Badge type="info" text="NO" /> | String | ?min=1994 |
| \{max\} | URL Query | Maximum Year to return | <Badge type="info" text="NO" /> | String | ?max=2004 |

## Response Types

| Code | Description                          |
| ---- | ------------------------------------ |
| 200  | Returns a list of vehicle make years |
| 401  | Unauthorized                         |
| 429  | Rate limit exeeded                   |

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

fetch("https://naija-places.toneflix.com.ng/api/v1/vehicle/years", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/v1/vehicle/years',
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
    .get("https://naija-places.toneflix.com.ng/v1/vehicle/years", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/v1/vehicle/years'));

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
            "id": 724,
            "name": 1904
        },
        {
            "id": 571,
            "name": 1908
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
