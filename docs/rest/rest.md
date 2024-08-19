---
toc: false
nav: false
---

<!-- vale off -->

# Rest reference

<script src="https://cdn.redoc.ly/redoc/latest/bundles/redoc.standalone.js"></script>
<div id="redoc-container"></div>
<script>
Redoc.init("https://gist.githubusercontent.com/mnocon/c52c5c1be4810f637c49a4f8040fd1c0/raw/c2ab62907051a77bf549d233d95d2986827cb457/api.yaml",
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
    document.querySelector('#redoc-container [title]').setAttribute("style", "background-color: red") 
    })
)</script>