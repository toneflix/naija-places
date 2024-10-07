---
outline: deep
---

# States

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/regions`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Request Parameters

This endpoint does not require any parameters

## Response Types

| Code | Description                                |
| ---- | ------------------------------------------ |
| 200  | Returns a list of all regions in the world |
| 401  | Unauthorized                               |
| 429  | Rate limit exeeded                         |

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

fetch("https://naija-places.toneflix.com.ng/v1/regions", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/v1/regions',
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
    .get("https://naija-places.toneflix.com.ng/v1/regions", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/v1/regions'));

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
            "id": 1,
            "name": "Africa",
            "translations": {
                "kr": "아프리카",
                "pt-BR": "África",
                "pt": "África",
                "nl": "Afrika",
                "hr": "Afrika",
                "fa": "آفریقا",
                "de": "Afrika",
                "es": "África",
                "fr": "Afrique",
                "ja": "アフリカ",
                "it": "Africa",
                "cn": "非洲",
                "tr": "Afrika",
                "ru": "Африка",
                "uk": "Африка",
                "pl": "Afryka"
            },
            "createdAt": "2023-08-14T10:41:03.000000Z",
            "updatedAt": "2023-08-14T10:41:03.000000Z",
            "flag": true,
            "wikiDataId": "Q15"
        },
        {
            "id": 2,
            "name": "Americas",
            "translations": {
                "kr": "아메리카",
                "pt-BR": "América",
                "pt": "América",
                "nl": "Amerika",
                "hr": "Amerika",
                "fa": "قاره آمریکا",
                "de": "Amerika",
                "es": "América",
                "fr": "Amérique",
                "ja": "アメリカ州",
                "it": "America",
                "cn": "美洲",
                "tr": "Amerika",
                "ru": "Америка",
                "uk": "Америка",
                "pl": "Ameryka"
            },
            "createdAt": "2023-08-14T10:41:03.000000Z",
            "updatedAt": "2024-06-16T04:09:55.000000Z",
            "flag": true,
            "wikiDataId": "Q828"
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
