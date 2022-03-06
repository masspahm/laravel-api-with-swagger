<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="EventResource",
 *     description="Event resource",
 *     @OA\Xml(
 *         name="EventResource"
 *     )
 * )
 */
class EventResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Event[]
     */
    private $data;
}
