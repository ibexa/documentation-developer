import sys
from pathlib import Path

# Make repo-root shim modules (llmstxt_preprocess.py, update_llmstxt_config.py)
# importable; the llms_txt package itself is available via the editable
# install (`-e .` in requirements-dev.txt).
sys.path.insert(0, str(Path(__file__).resolve().parents[2]))
