import os

def on_config(config, **kwargs):
    if os.environ.get("READTHEDOCS_VERSION_TYPE") == "external":
        ref = os.environ.get("READTHEDOCS_GIT_COMMIT_HASH")
    else:
        ref = os.environ.get("GITHUB_HEAD_REF")

    if ref:
        config["edit_uri"] = f"edit/{ref}/docs/"

    return config
