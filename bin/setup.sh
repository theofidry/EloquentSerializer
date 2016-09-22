#!/usr/bin/env bash

#
# This file is part of the EloquentSerializer package.
#
# (c) Théo FIDRY <theo.fidry@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#

rm fixtures/database.sqlite
touch fixtures/database.sqlite
php bin/artisan migrate
