---
outline: deep
---

# Cities

<Badge type="warning" text="GET" /> `https://ng-places.toneflix.com.ng/api/v1/states/{siso}/cities`

## Security

This endpoint uses the API KEY as a bearer token for authentication.

```
Name: Authorization: Bearer API_KEY
In: header
```

## Request Parameters

| Code     | In  | Description        | Required                           | Type   |
| -------- | --- | ------------------ | ---------------------------------- | ------ |
| \{siso\} | URL | ISO2 Code of State | <Badge type="danger" text="YES" /> | String |

## Response Types

| Code | Description                                      |
| ---- | ------------------------------------------------ |
| 200  | Returns a list of all cities for the given state |
| 401  | Unauthorized.                                    |
| 404  | Not Found.                                       |

## Example Usage

::: code-group

```js [javascript]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("Authorization", "Bearer API_KEY");

fetch("https://naija-places.toneflix.ng/v1/states/ab/cities", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```php [php]
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://naija-places.toneflix.ng/v1/states/ab/cities',
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
    .get("https://naija-places.toneflix.ng/v1/states/ab/cities", {
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

var request = http.Request('GET', Uri.parse('https://naija-places.toneflix.ng/v1/states/ab/cities'));

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
[
    {
        "id": 1,
        "slug": "aba",
        "name": "Aba",
        "state": "abia",
        "stateId": 1
    },
    {
        "id": 2,
        "slug": "abala",
        "name": "Abala",
        "state": "abia",
        "stateId": 1
    },
    ...
]
```

### 401 Error Response

```json
{
    "error": "Unauthorized. You do not have access to this resource."
}
```

### 404 Error Response

```json
{
    "error": "State not found."
}
```
