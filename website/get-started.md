---
outline: deep
---

# Getting Started with Naija Places API

To start using the Naija Places API, you’ll need to generate an API key. Follow these simple steps:

## Step 1: Register or Log In

1. Visit the Naija Places API [Portal](portal).
2. Register for an account if you don’t have one. Provide the necessary details and verify your email address.
3. If you already have an account, simply log in using your credentials.

## Step 2: Generate Your API Key

1. Once logged in, navigate to your Dashboard.
2. Look for the API Keys section on the dashboard.
3. Click on Generate API Key.
4. Your unique API key will be generated and displayed.

    - Note: Make sure to copy and store your API key securely. You’ll only see it once and will need it to authenticate your API requests.

## Step 3: Start Making API Requests

With your API key, you can now begin making requests to the Naija Places API. Include the key in your request headers as follows:

```http
Authorization: Bearer YOUR_API_KEY
```

You’re all set! Check out the [API Documentation](api-documentation) for detailed instructions on how to use the API endpoints.

<SimpleComp />

<script setup>
import SimpleComp from './components/SimpleComp.vue'
</script>
