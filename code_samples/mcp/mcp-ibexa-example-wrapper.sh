#!/bin/bash
set -e

baseUrl='http://localhost' # Adapt to your test case
mcpServer="$baseUrl/mcp/example"

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
  --streamableHttp "$mcpServer" \
  --oauth2Bearer "$jwtToken" \
  --logLevel none
