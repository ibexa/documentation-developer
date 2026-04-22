baseUrl='http://localhost' # Adapt to your test case

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/json' \
  -d '{
        "JWTInput": {
          "_media-type": "application/vnd.ibexa.api.JWTInput",
          "username": "admin",
          "password": "publish"
        }
      }' | jq -r .JWT.token)

mcpSessionId=$(curl -s -i -X 'POST' "$baseUrl/mcp/example" \
  -H "Authorization: Bearer $jwtToken" \
  -d '{
        "jsonrpc": "2.0",
        "id": 1,
        "method": "initialize",
        "params": {
          "protocolVersion": "2025-03-26",
          "capabilities": {},
          "clientInfo": {
            "name": "test-curl-client",
            "version": "1.0.0"
          }
        }
      }' | grep 'Mcp-Session-Id:' | sed 's/Mcp-Session-Id: \([0-9a-f-]*\).*/\1/')

curl -s -i -X 'POST' "$baseUrl/mcp/example" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "method": "notifications/initialized"
      }'

curl -s -X 'POST' "$baseUrl/mcp/example" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 2,
        "method": "tools/list"
      }' | jq

curl -s -X 'POST' "$baseUrl/mcp/example" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 3,
        "method": "tools/call",
        "params": {
          "name": "greet",
          "arguments": {
            "name": "World"
          }
        }
      }' | jq

curl -s -X 'POST' "$baseUrl/mcp/example" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 4,
        "method": "prompts/list"
      }' | jq

curl -s -X 'POST' "$baseUrl/mcp/example" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 5,
        "method": "prompts/get",
        "params": {
          "name": "greet",
          "arguments": {
            "name": "Firstname Lastname"
          }
        }
      }' | jq
