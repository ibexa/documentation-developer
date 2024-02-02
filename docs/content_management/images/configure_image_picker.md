---
description: Install and configure Ibexa image picker as a standalone React application.
edition: headless
---

# Configure Assets library widget

Assets Library Widget is a standalone application that can be integratd 
into your web app or CMS platform. It allows users to comfortably publish, manage and share digital media assets.

## Requirements

Before you install a standalone Assets Library Widget, you must have:

- React 18
- The latest version of web browser Chrome, Firefox or Safari
- Instance that can be reached out from external services
- OAuth2 Server enabled

## Instalation

Installation should be done through `npm install`.

Go to https://github.com/ibexa/assets-library-widget-dist/pkgs/npm/assets-library-widget.

Install `assets-library-widget` package by running the command:

`npm install @ibexa/assets-library-widget`

### Get token

To get `accessToken`, send a request to authenticate the user credentials.

```bash
POST http://127.0.0.1:8001/token
Content-Type: application/json
```

```json
{
  "grant_type": "client_credentials",
  "client_id": "1234567890",
  "client_secret": "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890"
}
{
    "User": {
        "_media-type": "application\/vnd.ibexa.api.User+json",
        "_href": "\/api\/ibexa\/v2\/user\/users\/14",
        "_id": 14,
        "_remoteId": "1bb4fe25487f05527efa8bfd394cecc7",
        "ContentType": {
            "_media-type": "application\/vnd.ibexa.api.ContentType+json",
            "_href": "\/api\/ibexa\/v2\/content\/types\/4"
        },
        "name": "Administrator User",
        "Versions": {
            "_media-type": "application\/vnd.ibexa.api.VersionList+json",
            "_href": "\/api\/ibexa\/v2\/content\/objects\/14\/versions"
        },
        ...
    }
}
```

`Authorization: Bearer <token>`

Provide the obtained token in the app config file.

## Configuration

You can modify the default settings to change the behavior
of the Image picker.

```js
import logo from "./logo.svg";
import "./App.css";

import "@ibexa/assets-library-widget/build/main.css";
import AssetsLibraryWidget from "@ibexa/assets-library-widget";

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <AssetsLibraryWidget
          windowMode={true}
          language="en"
          instanceUrl="127.0.0.1"
          onConfirm={() => console.log("xxx")}
        />
      </header>
    </div>
  );
}

export default App;
```

Available parameters:

|React props|Description|
|---------|----------|
|`accessToken`|Token OAuth, used to authenticate. (Required REST API call).|
|`windowMode`|If false, Assets Library Widget renders as a fullscreen, if set to true, fills the container for its render.|
|`language`|Interface language.|
|`instanceUrl`|Base URL for REST API call.|
|`onCancel`|A callback to be invoked when user clicks the Cancel button. For more information, see [UDW documentaion](https://doc.ibexa.co/en/latest/administration/back_office/browser/browser/#configuration-available-only-through-js).|


## Launch widget

To launch installed Asset Library Widget, in the terminal run command:

```bash
  npm start
```