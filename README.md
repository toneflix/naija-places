# Toneflix Places API

[![Test & Lint](https://github.com/toneflix/naija-places/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/toneflix/naija-places/actions/workflows/run-tests.yml)
[![codecov](https://codecov.io/gh/toneflix/naija-places/graph/badge.svg?token=2O7aFulQ9P)](https://codecov.io/gh/toneflix/naija-places)

<!-- ![GitHub Actions](https://github.com/toneflix/naija-places/actions/workflows/main.yml/badge.svg) -->

One api to rule them all, query all states, Local government areas, Wards, Polling Units and Towns in Nigeria.

# Usage

### Apply API Key

You can get an API key by creating an account on [Toneflix Places API Portal]([)](https://naija-places.toneflix.com.ng/portal/home).
Once you have generated your API keys you can add it to every request to the API via the `X-Api-Key` header

#### Example

```js [states]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-Key", "API_KEY");

fetch("https://naija-places.toneflix.com.ng/api/v1/states", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

## States

**`https://naija-places.toneflix.com.ng/api/v1/states`**

### Example Response

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

## Local Government Areas

**`https://naija-places.toneflix.com.ng/api/v1/states/{stateId}/lgas`**

### Example Response

_`https://naija-places.toneflix.com.ng/api/v1/states/1/lgas`_

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

## Wards

**`https://naija-places.toneflix.com.ng/api/v1/states/{state}/lgas/{lga}/wards`**

### Example Response

_`https://naija-places.toneflix.com.ng/api/v1/states/1/lgas/1/wards`_

```json
{
    "data": [
        {
            "id": 2902,
            "slug": "asata-township",
            "name": "Asata Township",
            "lga": "Enugu North",
            "lgaId": 254,
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 2903,
            "slug": "china-town",
            "name": "China Town",
            "lga": "Enugu North",
            "lgaId": 254,
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 2904,
            "slug": "g-r-a",
            "name": "G R A",
            "lga": "Enugu North",
            "lgaId": 254,
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

## Polling Units

**`https://naija-places.toneflix.com.ng/api/v1/states/{state}/lgas/{lga}/wards/{ward}/units`**

### Example Response

_`https://naija-places.toneflix.com.ng/api/v1/states/1/lgas/1/wards/1/units`_

```json
{
    "data": [
        {
            "id": 37951,
            "slug": "new-haven-primary-school-i",
            "name": "New Haven Primary School I",
            "lga": "Enugu North",
            "lgaId": 254,
            "ward": "New Haven",
            "wardId": 2908,
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 37952,
            "slug": "new-haven-primary-school-ii",
            "name": "New Haven Primary School Ii",
            "lga": "Enugu North",
            "lgaId": 254,
            "ward": "New Haven",
            "wardId": 2908,
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 37953,
            "slug": "new-haven-primary-school-iii",
            "name": "New Haven Primary School Iii",
            "lga": "Enugu North",
            "lgaId": 254,
            "ward": "New Haven",
            "wardId": 2908,
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

## Towns and Cities

**`https://naija-places.toneflix.com.ng/api/v1/states/{stateId}/cities`**

### Example Response

_`https://naija-places.toneflix.com.ng/api/v1/states/1/cities`_

```json
{
    "data": [
        {
            "id": 580,
            "slug": "abakpa-nike",
            "name": "Abakpa Nike",
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 581,
            "slug": "achi",
            "name": "Achi",
            "state": "Enugu",
            "stateId": 14
        },
        {
            "id": 582,
            "slug": "agbani-road",
            "name": "Agbani Road",
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

## Errors

| Code | Description        |
| ---- | ------------------ |
| 401  | Unauthorized.      |
| 404  | Not Found.         |
| 429  | Rate limit exeeded |

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
