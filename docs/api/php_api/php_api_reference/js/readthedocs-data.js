var READTHEDOCS_DATA = {
    "project": "ez-systems-developer-documentation",
    "version": "latest",
    "language": "en",
    "programming_language": "words",
    "page": null,
    "theme": "material",
    "builder": "mkdocs",
    "docroot": "docs",
    "source_suffix": ".md",
    "api_host": "https://readthedocs.com",
    "ad_free": false,
    "commit": [
        "d00930493348a81a5559564399d39214dcf9fe55"
    ],
    "global_analytics_code": "UA-17997319-2",
    "user_analytics_code": "UA-303624-13",
    "proxied_static_path": "/_/static/",
    "proxied_api_host": "/_"
}

// Old variables
var doc_version = "latest";
var doc_slug = "ez\u002Dsystems\u002Ddeveloper\u002Ddocumentation";
var page_name = "None";
var html_theme = "material";

// mkdocs_page_input_path is only defined on the RTD mkdocs theme but it isn't
// available on all pages (e.g. missing in search result)
if (typeof mkdocs_page_input_path !== "undefined") {
  READTHEDOCS_DATA["page"] = mkdocs_page_input_path.substr(
      0, mkdocs_page_input_path.lastIndexOf(READTHEDOCS_DATA.source_suffix));
}
