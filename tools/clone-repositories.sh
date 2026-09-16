#!/usr/bin/env bash
# Clones and builds versioned documentation repositories used by lychee's remap rules,
# then generates lychee.toml from lychee.toml.dist with absolute paths substituted in.
#
# Usage: ./tools/clone-repositories.sh [DEVDOC_60_BRANCH] [DEVDOC_50_BRANCH] [DEVDOC_46_BRANCH] [USERDOC_SAAS_BRANCH] [USERDOC_60_BRANCH] [USERDOC_50_BRANCH] [USERDOC_46_BRANCH] [CONNECT_BRANCH]
#
#   DEVDOC_60_BRANCH    Branch of ibexa/documentation-developer to use for 6.0  (default: 6.0)
#   DEVDOC_50_BRANCH    Branch of ibexa/documentation-developer to use for 5.0  (default: 5.0)
#   DEVDOC_46_BRANCH    Branch of ibexa/documentation-developer to use for 4.6  (default: 4.6)
#   USERDOC_SAAS_BRANCH Branch of ibexa/documentation-user to use for SaaS      (default: saas)
#   USERDOC_60_BRANCH   Branch of ibexa/documentation-user to use for 6.0       (default: 6.0)
#   USERDOC_50_BRANCH   Branch of ibexa/documentation-user to use for 5.0       (default: 5.0)
#   USERDOC_46_BRANCH   Branch of ibexa/documentation-user to use for 4.6       (default: 4.6)
#   CONNECT_BRANCH      Branch of ibexa/documentation-connect                   (default: main)
#
# The SaaS developer documentation is not cloned: this branch *is* the SaaS
# documentation, so doc.ibexa.co/en/saas/ links are remapped to the local build.
#
# Run this once before running lychee. Re-run to refresh clones or after moving
# the repository to a new path (the path in lychee.toml will be updated automatically).

set -euo pipefail

DEVDOC_60_BRANCH="${1:-6.0}"
DEVDOC_50_BRANCH="${2:-5.0}"
DEVDOC_46_BRANCH="${3:-4.6}"
USERDOC_SAAS_BRANCH="${4:-saas}"
USERDOC_60_BRANCH="${5:-6.0}"
USERDOC_50_BRANCH="${6:-5.0}"
USERDOC_46_BRANCH="${7:-4.6}"
CONNECT_BRANCH="${8:-main}"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
# The script lives in tools/; all paths (repositories/, lychee.toml.dist, lychee.toml)
# are relative to the repository root one level up.
REPO_DIR="$(dirname "$SCRIPT_DIR")"

# Prepend the local Python installation so pip/mkdocs resolve correctly.
# Adjust this if your Python is installed elsewhere.
export PATH="$HOME/python/bin:$PATH"

cd "$REPO_DIR"

REPOSITORIES=(
    devdoc-4.6
    devdoc-5.0
    devdoc-6.0
    userdoc-4.6
    userdoc-5.0
    userdoc-6.0
    userdoc-saas
    connect
)

echo "==> Cloning versioned repositories..."
echo "    devdoc  6.0  → branch '$DEVDOC_60_BRANCH'"
echo "    devdoc  5.0  → branch '$DEVDOC_50_BRANCH'"
echo "    devdoc  4.6  → branch '$DEVDOC_46_BRANCH'"
echo "    userdoc saas → branch '$USERDOC_SAAS_BRANCH'"
echo "    userdoc 6.0  → branch '$USERDOC_60_BRANCH'"
echo "    userdoc 5.0  → branch '$USERDOC_50_BRANCH'"
echo "    userdoc 4.6  → branch '$USERDOC_46_BRANCH'"
echo "    connect      → branch '$CONNECT_BRANCH'"
mkdir -p repositories
git clone --depth=1 --branch "$DEVDOC_46_BRANCH"    https://github.com/ibexa/documentation-developer.git repositories/devdoc-4.6 &
git clone --depth=1 --branch "$DEVDOC_50_BRANCH"    https://github.com/ibexa/documentation-developer.git repositories/devdoc-5.0 &
git clone --depth=1 --branch "$DEVDOC_60_BRANCH"    https://github.com/ibexa/documentation-developer.git repositories/devdoc-6.0 &
git clone --depth=1 --branch "$USERDOC_46_BRANCH"   https://github.com/ibexa/documentation-user.git repositories/userdoc-4.6 &
git clone --depth=1 --branch "$USERDOC_50_BRANCH"   https://github.com/ibexa/documentation-user.git repositories/userdoc-5.0 &
git clone --depth=1 --branch "$USERDOC_60_BRANCH"   https://github.com/ibexa/documentation-user.git repositories/userdoc-6.0 &
git clone --depth=1 --branch "$USERDOC_SAAS_BRANCH" https://github.com/ibexa/documentation-user.git repositories/userdoc-saas &
git clone --depth=1 --branch "$CONNECT_BRANCH"      https://github.com/ibexa/documentation-connect.git repositories/connect &
wait

echo "==> Installing dependencies for versioned repositories..."
for name in "${REPOSITORIES[@]}"; do
    (cd "repositories/$name" && pip install -q -r requirements.txt)
done

echo "==> Building versioned repositories..."
for name in "${REPOSITORIES[@]}"; do
    (cd "repositories/$name" && mkdocs build --quiet) &
done
wait

echo "==> Generating lychee.toml from lychee.toml.dist..."
sed "s|__BASE_DIR__|$REPO_DIR|g" lychee.toml.dist > lychee.toml
echo "    __BASE_DIR__ → '$REPO_DIR'"

echo "Done."
