import sys
from pathlib import Path

# Make repo-root modules (llmstxt_preprocess.py) importable.
sys.path.insert(0, str(Path(__file__).resolve().parents[2]))
