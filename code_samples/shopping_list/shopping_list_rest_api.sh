BASE_URL='TODO'
CUSTOMER_USERNAME='admin'
CUSTOMER_PASSWORD='publish'
PRODUCT_CODE='TODO'

# Log in and store CSRF Token
csrf_token=`curl -s -c cookie.txt -X 'POST' \
  "$BASE_URL/api/ibexa/v2/user/sessions" \
  -H 'accept: application/vnd.ibexa.api.Session+json' \
  -H 'Content-Type: application/vnd.ibexa.api.SessionInput+json' \
  -d "{
  \"SessionInput\": {
    \"login\": \"$CUSTOMER_USERNAME\",
    \"password\": \"$CUSTOMER_PASSWORD\"
  }
}" | jq -r '.Session.csrfToken'`

# Get default shopping list identifier if it exists
default_list_identifier=`curl -s -b cookie.txt -X 'GET' \
  "$BASE_URL/api/ibexa/v2/shopping-list?isDefault=true" \
  -H 'accept: application/vnd.ibexa.api.ShoppingListCollection+json' \
  | jq -r '.ShoppingListCollection.ShoppingList[0].identifier'`

# Clear default shopping list
if [ "" != "$default_list_identifier" ]; then
  curl -s -b cookie.txt -X 'POST' \
    "$BASE_URL/api/ibexa/v2/shopping-list/$default_list_identifier/clear" \
    -H 'accept: application/vnd.ibexa.api.ShoppingList+json' \
    -H "X-CSRF-Token: $csrf_token" | jq
fi

# Add entries to the default shopping list,
# create it if it doesn't exist yet,
# and get the updated data
curl -s -b cookie.txt -X 'POST' \
  "$BASE_URL/api/ibexa/v2/shopping-list/default/entries" \
  -H 'accept: application/vnd.ibexa.api.ShoppingList+json' \
  -H "X-CSRF-Token: $csrf_token" \
  -H 'Content-Type: application/vnd.ibexa.api.ShoppingListEntriesAdd+json' \
  -d "{
  \"ShoppingListEntriesAdd\": {
    \"entries\": [
      {
        \"productCode\": \"$PRODUCT_CODE\"
      }
    ]
  }
}" | jq
