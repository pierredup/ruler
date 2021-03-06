<?php

declare(strict_types=1);

/*
 * This file is part of the ruler project.
 *
 * @author     SolidWorx <open-source@solidworx.co>
 * @copyright  Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ruler\Storage;

use Ruler\Ruler;

interface StorageInterface
{
    public function add(string $name, Ruler $ruler);

    public function get(string $name): Ruler;
}