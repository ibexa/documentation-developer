---
toc: false
nav: false
---

<!-- vale off -->

<script src="https://cdn.redoc.ly/redoc/latest/bundles/redoc.standalone.js"></script>
<div id="redoc-container"></div>
<script>
Redoc.init("https://gist.githubusercontent.com/mnocon/0094456f313ea2943b3b852bf76d9a95/raw/3423f2d97bba77e5080179cb9e2994c98d8dec9f/api_no_logo.yaml",
{ expandResponses: "200,400",
    nativeScrollbars: true,
    theme: {
      typography: { links: {color: '#000' }},
      colors: { primary: { main: '#654d31' } },
      sidebar: { backgroundColor: '#FFF'},
      // rightPanel: { backgroundColor: '#FFF', textColor: '#333' }
    }
  },
document.querySelector("#redoc-container"), (function (e) { 
    document.querySelector('#redoc-container [title]').setAttribute("style", "background-color: grey") 
    })
)</script>
