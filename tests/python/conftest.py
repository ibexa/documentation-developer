import sys
from pathlib import Path

import pytest

# Make repo-root shim modules (llmstxt_preprocess.py, update_llmstxt_config.py)
# importable; the llms_txt package itself is available via the editable
# install (`-e .` in requirements-dev.txt).
sys.path.insert(0, str(Path(__file__).resolve().parents[2]))


# TEMPORARY: the option and the fixtures below serve
# test_conversion_invariants.py only, and are removed together with it by
# conversion ticket 20.
def pytest_addoption(parser):
    parser.addoption(
        "--update-invariant-baseline",
        action="store_true",
        default=False,
        help=(
            "Rewrite tests/python/invariants-baseline.yaml from the "
            "documentation tree's current SaaS-conversion violations."
        ),
    )


@pytest.fixture(scope="session")
def repo_root() -> Path:
    return Path(__file__).resolve().parents[2]


@pytest.fixture(scope="session")
def docs_dir(repo_root: Path) -> Path:
    return repo_root / "docs"
