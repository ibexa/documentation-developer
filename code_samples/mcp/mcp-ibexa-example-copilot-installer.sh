#!/bin/bash
set -e

# Adapt to your test case
baseUrl='http://localhost'
serverUrl="$baseUrl/mcp/example"
serverName='ibexa-example'
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

if [[ -n $(copilot mcp list | grep "  $serverName (http)") ]]
then
  copilot mcp remove "$serverName"
fi

copilot mcp add --transport http \
  --header "Authorization: Bearer $jwtToken" \
  "$serverName" "$serverUrl"
