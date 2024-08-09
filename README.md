# Naija Places API

[![Test & Lint](https://github.com/toneflix/naija-places/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/toneflix/naija-places/actions/workflows/run-tests.yml)
[![codecov](https://codecov.io/gh/toneflix/naija-places/graph/badge.svg?token=2O7aFulQ9P)](https://codecov.io/gh/toneflix/naija-places)

<!-- ![GitHub Actions](https://github.com/toneflix/naija-places/actions/workflows/main.yml/badge.svg) -->

One api to rule them all, query all states, Local government areas, Wards, Polling Units and Towns in Nigeria.

# Usage

## States

**`https://ng-places.toneflix.com.ng/api/v1/states`**

### Example Response

```json
[
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
]
```

## Local Government Areas

**`https://ng-places.toneflix.com.ng/api/v1/states/{stateId}/lgas`**

### Example Response

_`https://ng-places.toneflix.com.ng/api/v1/states/1/lgas`_

```json
[
    {
        "id": 1,
        "slug": "aba-north",
        "name": "Aba North",
        "code": "EZA",
        "state": "abia",
        "stateId": 1
    },
    {
        "id": 2,
        "slug": "ohafia",
        "name": "Ohafia",
        "code": "HAF",
        "state": "abia",
        "stateId": 1
    },
    ...
]
```

## Wards

**`https://ng-places.toneflix.com.ng/api/v1/states/{state}/lgas/{lga}/wards`**

### Example Response

_`https://ng-places.toneflix.com.ng/api/v1/states/1/lgas/1/wards`_

```json
[
    {
        "id": 1,
        "slug": "ariaria-market",
        "name": "Ariaria Market",
        "lga": "Aba North",
        "lgaId": 1,
        "state": "Abia",
        "stateId": 1
    },
    {
        "id": 2,
        "slug": "eziama",
        "name": "Eziama",
        "lga": "Aba North",
        "lgaId": 1,
        "state": "Abia",
        "stateId": 1
    },
    ...
]
```

## Polling Units

**`https://ng-places.toneflix.com.ng/api/v1/states/{state}/lgas/{lga}/wards/{ward}/units`**

### Example Response

_`https://ng-places.toneflix.com.ng/api/v1/states/1/lgas/1/wards/1/units`_

```json
[
    {
        "id": 1,
        "slug": "osusu-rd-prim-school-premises-i",
        "name": "Osusu Rd Prim School Premises I",
        "lga": "Aba North",
        "lgaId": 1,
        "state": "abia",
        "stateId": 1,
        "ward": "Ariaria Market",
        "wardId": 1
    },
    {
        "id": 2,
        "slug": "osusu-rd-prim-school-premises-ii",
        "name": "Osusu Rd Prim School Premises II",
        "lga": "Aba North",
        "lgaId": 1,
        "state": "abia",
        "stateId": 1,
        "ward": "Ariaria Market",
        "wardId": 1
    },
    ...
]
```

## Towns and Cities

**`https://ng-places.toneflix.com.ng/api/v1/states/{stateId}/cities`**

### Example Response

_`https://ng-places.toneflix.com.ng/api/v1/states/1/cities`_

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
