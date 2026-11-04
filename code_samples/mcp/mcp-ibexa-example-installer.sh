#!/bin/bash
set -e

baseUrl='http://ddev-ibexa-tmp.ddev.site:8080' # Adapt to your test case
serverUrl="$baseUrl/mcp/example"
serverName='ibexa-example'

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d '{
        "JWTInput": {
          "_media-type": "application/vnd.ibexa.api.JWTInput+json",
          "username": "admin",
          "password": "publish"
        }
      }' | jq -r .JWT.token)

if [[ -n $(copilot mcp list | grep $serverName) ]]
then
  copilot mcp remove $serverName
fi

copilot mcp add --transport http \
  --header "Authorization: Bearer $jwtToken" \
  $serverName "$serverUrl"
