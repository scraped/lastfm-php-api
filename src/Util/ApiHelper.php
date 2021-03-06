<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Util;

final class ApiHelper
{
    /**
     * Cleans the api response, so that you always get a list of elements.
     *
     * @param callable $callback
     * @param array    $data
     *
     * @return array
     */
    public static function mapList(callable $callback, array $data): array
    {
        if (!isset($data[0])) {
            $data = [$data];
        }

        return array_map($callback, $data);
    }
}
