<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Tests\Session;

use Core23\LastFm\Session\Session;
use Core23\LastFm\Session\SessionInterface;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testItIsInstantiable(): void
    {
        static::assertInstanceOf(SessionInterface::class, new Session('Username', 'key'));
    }

    public function testGetName(): void
    {
        $session = new Session('Username', 'key');

        static::assertSame('Username', $session->getName());
    }

    public function testGetKey(): void
    {
        $session = new Session('Username', 'key');

        static::assertSame('key', $session->getKey());
    }

    public function testGetSubscriber(): void
    {
        $session = new Session('Username', 'key', 32);

        static::assertSame(32, $session->getSubscriber());
    }
}
