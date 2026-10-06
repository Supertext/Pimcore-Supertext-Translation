#!/bin/sh
# Copies the bundle's files into demo/module, which the demo installs through a Composer path
# repository. Run it before `composer install`/`composer update` in demo/project.
# The Studio plugin must be built first (cd assets && npm ci && npm run build).
set -e
cd "$(dirname "$0")/.."
rm -rf demo/module
mkdir -p demo/module
cp -R composer.json config public src translations demo/module/
