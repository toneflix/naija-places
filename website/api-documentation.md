---
layout: home

hero:
    actions:
        - theme: brand
          text: States
          link: /docs/states
        - theme: alt
          text: Cities
          link: /docs/cities
        - theme: alt
          text: LGAs
          link: /docs/lgas
        - theme: alt
          text: Wards
          link: /docs/wards
        - theme: alt
          text: Polling Units
          link: /docs/units
        - theme: brand
          text: World Regions
          link: /docs/world/regions
        - theme: alt
          text: World Subregions
          link: /docs/world/subregions
        - theme: alt
          text: Countries
          link: /docs/world/countries
        - theme: alt
          text: World States
          link: /docs/world/states
        - theme: alt
          text: World Cities
          link: /docs/world/cities
---

<!-- ## Examples -->

# Quick snippets to get started with the API

::: code-group

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

```ts [cities]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-Key", "API_KEY");

fetch("https://naija-places.toneflix.com.ng/api/v1/states/1/cities", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```ts [lgas]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-Key", "API_KEY");

fetch("https://naija-places.toneflix.com.ng/api/v1/states/1/lgas", options)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```ts [wards]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-Key", "API_KEY");

fetch(
    "https://naija-places.toneflix.com.ng/api/v1/states/1/lgas/3/wards",
    options
)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

```ts [wards]
const headers = new Headers();
const options = {
    method: "GET",
    headers: headers,
    redirect: "follow",
};

headers.append("X-Api-Key", "API_KEY");

fetch(
    "https://naija-places.toneflix.com.ng/v1/states/1/lgas/3/wards/1/units",
    options
)
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.log("error", error));
```

:::
