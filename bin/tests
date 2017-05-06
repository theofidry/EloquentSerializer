#!/usr/bin/env bash

#
# This file is part of the EloquentSerializer package.
#
# (c) Théo FIDRY <theo.fidry@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#

set -ex

vendor/phpunit/phpunit/phpunit -c phpunit.xml.dist
vendor-bin/laravel/vendor/phpunit/phpunit/phpunit -c phpunit_laravel.xml.dist
vendor-bin/symfony/vendor/phpunit/phpunit/phpunit -c phpunit_symfony.xml.dist
