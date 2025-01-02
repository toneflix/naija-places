---
outline: deep
---

# States

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/subregions`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Request Parameters

This endpoint does not require any parameters

## Response Types

| Code | Description                                       |
| ---- | ------------------------------------------------- |
| 200  | Returns a list of all the subregions in the world |
| 401  | Unauthorized                                      |
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

fetch("https://naija-places.toneflix.com.ng/api/v1/subregions", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/v1/subregions',
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
    .get("https://naija-places.toneflix.com.ng/v1/subregions", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/v1/subregions'));

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
            "name": "Northern Africa",
            "translations": {
                "korean": "북아프리카",
                "portuguese": "Norte de África",
                "dutch": "Noord-Afrika",
                "croatian": "Sjeverna Afrika",
                "persian": "شمال آفریقا",
                "german": "Nordafrika",
                "spanish": "Norte de África",
                "french": "Afrique du Nord",
                "japanese": "北アフリカ",
                "italian": "Nordafrica",
                "chinese": "北部非洲",
                "ru": "Северная Африка",
                "uk": "Північна Африка",
                "pl": "Afryka Północna"
            },
            "regionId": 1,
            "createdAt": "2023-08-14T10:41:03.000000Z",
            "updatedAt": "2023-08-24T23:40:23.000000Z",
            "flag": true,
            "wikiDataId": "Q27381"
        },
        {
            "id": 2,
            "name": "Middle Africa",
            "translations": {
                "korean": "중앙아프리카",
                "portuguese": "África Central",
                "dutch": "Centraal-Afrika",
                "croatian": "Srednja Afrika",
                "persian": "مرکز آفریقا",
                "german": "Zentralafrika",
                "spanish": "África Central",
                "french": "Afrique centrale",
                "japanese": "中部アフリカ",
                "italian": "Africa centrale",
                "chinese": "中部非洲",
                "ru": "Средняя Африка",
                "uk": "Середня Африка",
                "pl": "Afryka Środkowa"
            },
            "regionId": 1,
            "createdAt": "2023-08-14T10:41:03.000000Z",
            "updatedAt": "2023-08-24T23:52:09.000000Z",
            "flag": true,
            "wikiDataId": "Q27433"
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
