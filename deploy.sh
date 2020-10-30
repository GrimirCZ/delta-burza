#!/bin/sh
set -e

#TODO: testing
#vendor/bin/phpunit

(git push) || true

git checkout deploy
git merge --no-edit -q master

git push origin deploy --force

git checkout master
