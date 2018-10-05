<?php

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
    /**
     * @param string $name
     * @param Ruler  $ruler
     *
     * @return mixed
     */
    public function add($name, Ruler $ruler);

    /**
     * @param string $name
     *
     * @return Ruler
     */
    public function get($name);
}