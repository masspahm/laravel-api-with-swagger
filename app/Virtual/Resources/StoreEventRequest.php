<?php
namespace App\Virtual\Resources;
/**
 * @OA\Schema(
 *      title="Store Event request",
 *      description="Store Event request body data",
 *      type="object",
 *      required={"name","date","time","location"}
 * )
 */

class StoreEventRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new event",
     *      example="Open Mic"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="date",
     *      description="Date of the new event",
     *      example="2022-03-05"
     * )
     *
     * @var \Date
     */
    public $date;

    /**
     * @OA\Property(
     *      title="time",
     *      description="Time of the new event with h:m:s",
     *      format="time",
     *      example="00:00:00"
     * )
     *
     * @var \Time
     */
    public $time;

     /**
     * @OA\Property(
     *      title="location",
     *      description="location of the new event",
     *      example="Yogyakarta, Indonesia"
     * )
     *
     * @var string
     */
    public $location;
}