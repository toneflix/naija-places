---
outline: deep
---

# States

<Badge type="warning" text="GET" /> `https://naija-places.toneflix.com.ng/api/v1/countries`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
X-Api-Key: API_KEY
In: header
```

## Request Parameters

This endpoint does not require any parameters

## Response Types

| Code | Description                                  |
| ---- | -------------------------------------------- |
| 200  | Returns a list of all countries in the world |
| 401  | Unauthorized                                 |
| 429  | Rate limit exeeded                           |

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

fetch("https://naija-places.toneflix.com.ng/v1/countries", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.com.ng/v1/countries',
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
    .get("https://naija-places.toneflix.com.ng/v1/countries", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.com.ng/v1/countries'));

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
            "id": 161,
            "name": "Nigeria",
            "iso3": "NGA",
            "numericCode": "566",
            "iso2": "NG",
            "phonecode": "234",
            "capital": "Abuja",
            "currency": "NGN",
            "currencyName": "Nigerian naira",
            "currencySymbol": "₦",
            "tld": ".ng",
            "native": "Nigeria",
            "region": "Africa",
            "regionId": 1,
            "subregion": "Western Africa",
            "subregionId": 3,
            "nationality": "Nigerian",
            "timezones": [
                {
                    "zoneName": "Africa/Lagos",
                    "gmtOffset": 3600,
                    "gmtOffsetName": "UTC+01:00",
                    "abbreviation": "WAT",
                    "tzName": "West Africa Time"
                }
            ],
            "translations": {
                "kr": "나이지리아",
                "pt-BR": "Nigéria",
                "pt": "Nigéria",
                "nl": "Nigeria",
                "hr": "Nigerija",
                "fa": "نیجریه",
                "de": "Nigeria",
                "es": "Nigeria",
                "fr": "Nigéria",
                "ja": "ナイジェリア",
                "it": "Nigeria",
                "cn": "尼日利亚",
                "tr": "Nijerya",
                "ru": "Нигерия",
                "uk": "Нігерія",
                "pl": "Nigeria"
            },
            "latitude": 10,
            "longitude": 8,
            "emoji": "🇳🇬",
            "emojiU": "U+1F1F3 U+1F1EC",
            "createdAt": "2018-07-21T12:41:03.000000Z",
            "updatedAt": "2023-08-10T00:53:19.000000Z",
            "flag": true,
            "wikiDataId": "Q1033"
        },
        {
            "id": 162,
            "name": "Niue",
            "iso3": "NIU",
            "numericCode": "570",
            "iso2": "NU",
            "phonecode": "683",
            "capital": "Alofi",
            "currency": "NZD",
            "currencyName": "New Zealand dollar",
            "currencySymbol": "$",
            "tld": ".nu",
            "native": "Niuē",
            "region": "Oceania",
            "regionId": 5,
            "subregion": "Polynesia",
            "subregionId": 22,
            "nationality": "Niuean",
            "timezones": [
                {
                    "zoneName": "Pacific/Niue",
                    "gmtOffset": -39600,
                    "gmtOffsetName": "UTC-11:00",
                    "abbreviation": "NUT",
                    "tzName": "Niue Time"
                }
            ],
            "translations": {
                "kr": "니우에",
                "pt-BR": "Niue",
                "pt": "Niue",
                "nl": "Niue",
                "hr": "Niue",
                "fa": "نیووی",
                "de": "Niue",
                "es": "Niue",
                "fr": "Niue",
                "ja": "ニウエ",
                "it": "Niue",
                "cn": "纽埃",
                "tr": "Niue",
                "ru": "Ниуэ",
                "uk": "Ніуе",
                "pl": "Niue"
            },
            "latitude": -19.03333333,
            "longitude": -169.86666666,
            "emoji": "🇳🇺",
            "emojiU": "U+1F1F3 U+1F1FA",
            "createdAt": "2018-07-21T12:41:03.000000Z",
            "updatedAt": "2023-08-10T00:53:19.000000Z",
            "flag": true,
            "wikiDataId": "Q34020"
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
