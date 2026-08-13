import os


def on_config(config, **kwargs):
    """Determine at build time whether this build is for an End-Of-Life version.

    Each version is built by RTD as its own separate build (one per branch/tag),
    with READTHEDOCS_VERSION_NAME set to the version slug (matching the
    ``extra.eol_versions`` entries, e.g. "2.5", "3.3"). Computing this here
    lets the theme render the EOL warning only where it's actually true,
    instead of always emitting it in the HTML and hiding it via JS/CSS
    (which is present in the served page whether the visible warning applies
    or not).
    """
    current_version = os.environ.get("READTHEDOCS_VERSION_NAME", "")
    eol_versions = config["extra"].get("eol_versions") or []
    config["extra"]["current_version_is_eol"] = current_version in eol_versions

    return config
