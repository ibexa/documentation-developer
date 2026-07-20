"""MkDocs hooks entry point — delegates to the installable llms_txt package."""

from llms_txt.hooks import on_config, on_page_content

__all__ = ["on_config", "on_page_content"]
