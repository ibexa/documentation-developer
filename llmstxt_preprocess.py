"""mkdocs-llmstxt ``preprocess:`` entry point — delegates to the installable llms_txt package."""

from llms_txt.llmstxt_preprocess import preprocess

__all__ = ["preprocess"]
