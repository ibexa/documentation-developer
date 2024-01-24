---
description: Configure Ibexa image picker as a standalone React application.
---

# Configure Ibexa image picker

## Requirements

- React 18
- Latest version of web browser Chrome, Firefox or Safari

## Instalation

Go to https://github.com/ibexa/assets-library-widget-dist/pkgs/npm/assets-library-widget.
Install `assets-library-widget` package by running the command:

`npm install @ibexa/assets-library-widget`

To get `accessToken`, send a request call:




## Configuration

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

|React props|Values|Required|Description|
|-----------|------|--------|-----------|
|`accessToken`|||Token OAuth (Required a request to endpoint)|

|`accessToken`|||Token OAuth (Required a request to endpoint)|
|`windowMode`|||If false, Assets Library Widget renders as a fullscreen, if set to true, fills the container for its render.|
|`language`|||Interface language|
|`instanceUrl`|||Base URL for REST API call.|
|`onCancel`|||Standard callback on event Cancel. For more information, see [UDW documentaion](https://doc.ibexa.co/en/latest/administration/back_office/browser/browser/#configuration-available-only-through-js).|