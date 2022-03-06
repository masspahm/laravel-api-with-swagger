<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Event",
 *     description="Event model",
 *     @OA\Xml(
 *         name="Event"
 *     )
 * )
 */
class Event
{

    /**
     * @OA\Property(
     *     title="id",
     *     description="event ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of event",
     *      example="Open Mic"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Date",
     *      description="Date of event",
     *      example="2022-03-05"
     * )
     *
     * @var \Date
     */
    public $date;

    /**
     * @OA\Property(
     *     title="event time",
     *     description="event time",
     *     example="12:00:00",
     *     format="time",
     *     type="string"
     * )
     *
     * @var \Time
     */

    public $time;

    /**
     * @OA\Property(
     *     title="event location",
     *     description="event location",
     *     example="Yogyakarta, Indonesia",     
     *     type="string"
     * )
     *
     * @var \Date
     */

    public $location;

    /**
     * @OA\Property(
     *     title="created at",
     *     description="created at",
     *     example="2022-03-05T10:45:04.000000Z",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \Date
     */

    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2022-03-05T10:45:04.000000Z",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="null",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;

    /**
     * @OA\Property(
     *      title="Author ID",
     *      description="Author's id of the new project",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $created_by;


    /**
     * @OA\Property(
     *     title="Created By",
     *     description="user who created"
     * )
     *
     * @var \App\Virtual\Models\User
     */
    private $author;
}
