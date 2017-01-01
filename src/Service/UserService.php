<?php

/*
 * This file is part of the ni-ju-san CMS.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Service;

use Core23\LastFm\Exception\ApiException;

final class UserService extends AbstractService
{
    /**
     * Get a list of tracks by a given artist scrobbled by this user, including scrobble time.
     *
     * @param string    $username
     * @param string    $artist
     * @param \DateTime $startTimestamp
     * @param \DateTime $endTimestamp
     * @param int       $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getArtistTracks($username, $artist, \DateTime $startTimestamp = null, \DateTime $endTimestamp = null, $page = 1)
    {
        return $this->connection->unsignedCall('user.getArtistTracks', array(
            'user'           => $username,
            'artist'         => $artist,
            'startTimestamp' => $this->toTimestamp($startTimestamp),
            'endTimestamp'   => $this->toTimestamp($endTimestamp),
            'page'           => $page,
        ));
    }

    /**
     * Get a list of the user's friends on Last.fm.
     *
     * @param string $username
     * @param bool   $recenttracks
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getFriends($username, $recenttracks = false, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getFriends', array(
            'user'         => $username,
            'recenttracks' => (int) $recenttracks,
            'limit'        => $limit,
            'page'         => $page,
        ));
    }

    /**
     * Get information about a user profile.
     *
     * @param string $username
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getInfo($username)
    {
        return $this->connection->unsignedCall('user.getInfo', array(
            'user' => $username,
        ));
    }

    /**
     * Get the last 50 tracks loved by a user.
     *
     * @param string $username
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getLovedTracks($username, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getLovedTracks', array(
            'user'  => $username,
            'limit' => $limit,
            'page'  => $page,
        ));
    }

    /**
     * Get a list of the recent tracks listened to by this user. Indicates now playing track if the user is currently listening.
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     * @param bool      $extended
     * @param int       $limit
     * @param int       $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getRecentTracks($username, \DateTime $from = null, \DateTime $to = null, $extended = false, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getRecentTracks', array(
            'user'     => $username,
            'limit'    => $limit,
            'page'     => $page,
            'extended' => (int) $extended,
            'from'     => $this->toTimestamp($from),
            'to'       => $this->toTimestamp($to),
        ));
    }

    /**
     * Get the user's personal tags.
     *
     * @param string $username
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getPersonalTagsForArtist($username, $tag, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getPersonalTags', array(
            'taggingtype' => 'artist',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ));
    }

    /**
     * Get the user's personal tags.
     *
     * @param string $username
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getPersonalTagsForAlbum($username, $tag, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getPersonalTags', array(
            'taggingtype' => 'album',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ));
    }

    /**
     * Get the user's personal tags.
     *
     * @param string $username
     * @param string $tag
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getPersonalTagsForTracks($username, $tag, $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getPersonalTags', array(
            'taggingtype' => 'track',
            'user'        => $username,
            'tag'         => $tag,
            'limit'       => $limit,
            'page'        => $page,
        ));
    }

    /**
     * Get the top albums listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @param string $username
     * @param string $period
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopAlbums($username, $period = 'overall', $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getTopAlbums', array(
            'user'   => $username,
            'period' => $period,
            'limit'  => $limit,
            'page'   => $page,
        ));
    }

    /**
     * Get the top artists listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @param string $username
     * @param string $period
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopArtists($username, $period = 'overall', $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getTopArtists', array(
            'user'   => $username,
            'period' => $period,
            'limit'  => $limit,
            'page'   => $page,
        ));
    }

    /**
     * Get the top tags used by this user.
     *
     * @param string $username
     * @param int    $limit
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTags($username, $limit = 50)
    {
        return $this->connection->unsignedCall('user.getTopTags', array(
            'user'  => $username,
            'limit' => $limit,
        ));
    }

    /**
     * Get the top tracks listened to by a user. You can stipulate a time period. Sends the overall chart by default.
     *
     * @param string $username
     * @param string $period
     * @param int    $limit
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getTopTracks($username, $period = 'overall', $limit = 50, $page = 1)
    {
        return $this->connection->unsignedCall('user.getTopTracks', array(
            'user'   => $username,
            'period' => $period,
            'limit'  => $limit,
            'page'   => $page,
        ));
    }

    /**
     * Get an album chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent album chart for this user.
     *
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getWeeklyAlbumChart($username, \DateTime $from = null, \DateTime $to = null)
    {
        return $this->connection->unsignedCall('user.getWeeklyAlbumChart', array(
            'user' => $username,
            'from' => $this->toTimestamp($from),
            'to'   => $this->toTimestamp($to),
        ));
    }

    /**
     * Get an artist chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent artist chart for this user.
     *
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getWeeklyArtistChart($username, \DateTime $from = null, \DateTime $to = null)
    {
        return $this->connection->unsignedCall('user.getWeeklyArtistChart', array(
            'user' => $username,
            'from' => $this->toTimestamp($from),
            'to'   => $this->toTimestamp($to),
        ));
    }

    /**
     * Get a list of available charts for this user, expressed as date ranges which can be sent to the chart services.
     *
     * @param $username
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getWeeklyChartList($username)
    {
        return $this->connection->unsignedCall('user.getWeeklyChartList', array(
            'user' => $username,
        ));
    }

    /**
     * Get a track chart for a user profile, for a given date range. If no date range is supplied, it will return the most recent track chart for this user.
     *
     *
     * @param string    $username
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return array
     *
     * @throws ApiException
     */
    public function getWeeklyTrackChart($username, \DateTime $from = null, \DateTime $to = null)
    {
        return $this->connection->unsignedCall('user.getWeeklyTrackChart', array(
            'user' => $username,
            'from' => $this->toTimestamp($from),
            'to'   => $this->toTimestamp($to),
        ));
    }
}
