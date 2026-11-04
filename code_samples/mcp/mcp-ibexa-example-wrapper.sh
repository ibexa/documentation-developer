#!/bin/bash
set -e

# Adapt to your test case
baseUrl='http://localhost'
mcpServer="$baseUrl/mcp/example"
username='ibexa-example'
password='Ibexa-3xample'

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d "{
        \"JWTInput\": {
          \"_media-type\": \"application/vnd.ibexa.api.JWTInput+json\",
          \"username\": \"$username\",
          \"password\": \"$password\"
        }
      }" | jq -r .JWT.token)

exec npx -y supergateway@v3.4.3 \
  --streamableHttp "$mcpServer" \
  --oauth2Bearer "$jwtToken" \
  --logLevel none
