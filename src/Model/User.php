<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Model;

final class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var int|null
     */
    private $age;

    /**
     * @var string|null
     */
    private $gender;

    /**
     * @var int
     */
    private $playcount;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @param string      $name
     * @param string|null $country
     * @param int|null    $age
     * @param string|null $gender
     * @param int         $playcount
     * @param string|null $url
     */
    public function __construct(
        string $name,
        ?string $country,
        ?int $age,
        ?string $gender,
        int $playcount,
        ?string $url
    ) {
        $this->name      = $name;
        $this->country   = $country;
        $this->age       = $age;
        $this->gender    = $gender;
        $this->playcount = $playcount;
        $this->url       = $url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getPlaycount(): int
    {
        return $this->playcount;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public static function fromApi(array $data): self
    {
        return new self(
            $data['name'],
            $data['country'] ?? null,
            $data['age'] ? (int) $data['age'] : null,
            $data['gender'] ?? null,
            $data['playcount'] ? (int) $data['playcount'] : 0,
            $data['url'] ?? null
        );
    }
}
