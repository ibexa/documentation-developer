#!/bin/bash
set -e

baseUrl='http://localhost' # Adapt to your test case

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d '{
        "JWTInput": {
          "_media-type": "application/vnd.ibexa.api.JWTInput+json",
          "username": "ibexa-example",
          "password": "Ibexa-3xample"
        }
      }' | jq -r .JWT.token)

exec npx -y supergateway \
  --streamableHttp "$baseUrl/mcp/example" \
  --oauth2Bearer "$jwtToken" \
  --logLevel none
