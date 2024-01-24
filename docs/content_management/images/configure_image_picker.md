---
description: Install and configure Ibexa image picker as a standalone React application.
---

# Configure Ibexa image picker



## Requirements

- React 18
- Latest version of web browser Chrome, Firefox or Safari
- Instance can be reached out from external services

## Instalation

Installation should be done through `npm install``.

Go to https://github.com/ibexa/assets-library-widget-dist/pkgs/npm/assets-library-widget.

Install `assets-library-widget` package by running the command:

`npm install @ibexa/assets-library-widget`

### Get token

To get `accessToken`, send a request call:




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