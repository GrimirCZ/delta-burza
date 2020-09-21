#!/bin/sh
set -e

#TODO: testing
#vendor/bin/phpunit

(git push) || true

git checkout production
git merge master

git push origin production

git checkout master
