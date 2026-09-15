#!/bin/bash
set -e

export NODE_TLS_REJECT_UNAUTHORIZED=0

baseUrl='http://localhost' # Adapt to your test case
mcpServer="$baseUrl/admin/mcp/data-intelligence"

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H "X-Siteaccess: admin" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d '{
        "JWTInput": {
          "_media-type": "application/vnd.ibexa.api.JWTInput+json",
          "username": "admin",
          "password": "publish"
        }
      }' | jq -r .JWT.token)

exec npx -y supergateway \
  --streamableHttp "$mcpServer" \
  --oauth2Bearer "$jwtToken" \
  --header 'Accept-Language: en' \
  --logLevel none
