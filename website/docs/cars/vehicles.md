---
outline: deep
---

# Vehicles

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/vehicle/vehicles`

BY Manufacturer ID

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/vehicle/manufacturers/{mid}/vehicles`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Main Request Parameters

This endpoint does not require any parameters.

## Manufacturer ID Request Parameters

| Code    | In  | Description        | Required                           | Type   |
| ------- | --- | ------------------ | ---------------------------------- | ------ |
| \{mid\} | URL | ID of Manufacturer | <Badge type="danger" text="YES" /> | String |

## Request Query

| Key        | In        | Description    | Required                        | Type   | Example     |
| ---------- | --------- | -------------- | ------------------------------- | ------ | ----------- |
| \{search\} | URL Query | Search by name | <Badge type="info" text="NO" /> | String | ?search=bmw |

## Response Types

| Code | Description                    |
| ---- | ------------------------------ |
| 200  | Returns a list of all vehicles |
| 401  | Unauthorized                   |
| 429  | Rate limit exeeded             |

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

fetch("https://naija-places.toneflix.com.ng/api/v1/vehicle/vehicles", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/v1/vehicle/vehicles',
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
    .get("https://naija-places.toneflix.com.ng/v1/vehicle/vehicles", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/v1/vehicle/vehicles'));

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
            "id": 3717,
            "name": "190 (W201) 1 generation",
            "model": "190 (W201)",
            "generation": "1 generation",
            "year": 1982,
            "country": "Germany Database",
            "derivative": "1.7 AT",
            "doors": 4,
            "class": "Sedan",
            "engine": {},
            "mileage": {},
            "rel": {
                "year_id": 407,
                "country_id": 4,
                "manufacturer_id": 152
            },
            "createdAt": "2024-10-06T22:30:52.000000Z",
            "updatedAt": "2024-10-06T22:30:52.000000Z"
        },
        {
            "id": 3718,
            "name": "190 SL R121",
            "model": "190 SL",
            "generation": "R121",
            "year": 1955,
            "country": "Germany Database",
            "derivative": "1.9 MT",
            "doors": 2,
            "class": "Roadster",
            "engine": {},
            "mileage": {},
            "rel": {
                "year_id": 718,
                "country_id": 4,
                "manufacturer_id": 152
            },
            "createdAt": "2024-10-06T22:30:52.000000Z",
            "updatedAt": "2024-10-06T22:30:52.000000Z"
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
