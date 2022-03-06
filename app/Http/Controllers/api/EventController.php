<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="Bearer",
 *      bearerFormat="JWT",
 * ),
 */
class EventController extends ResponseController
{
    /**
     * @OA\Get(
     * path="/event",
     * summary="get event",
     * description="get all event with paginate",
     * operationId="getListEvents",
     * security={{"bearerAuth":{}}},
     * tags={"Events"},
     *      @OA\Parameter(
     *          name="per_page",
     *          description="limit pagination",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Request success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="request success"),
     *              @OA\Property(property="payload", type="object",      
     *                  @OA\Property(property="current_page", type="integer", example="1"),
     *                  @OA\Property(property="data",type="array",
     *                    @OA\Items(ref="#/components/schemas/Event"),
     *                  ),
     *                  @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/v1/event?page=1"),
     *                  @OA\Property(property="from", type="integer", example="1"),
     *                  @OA\Property(property="last_page", type="integer", example="1"),
     *                  @OA\Property(property="last_page_url", type="integer", example="http://localhost:8000/api/v1/event?page=1"),
     *                  @OA\Property(property="links", type="string", example="Invalid credentials"),
     *                  @OA\Property(property="next_page_url", type="string", example="null"),
     *                  @OA\Property(property="path", type="string", example="http://localhost:8000/api/v1/event"),
     *                  @OA\Property(property="per_page", type="integer", example="10"),
     *                  @OA\Property(property="prev_page_url", type="string", example="null"),
     *                  @OA\Property(property="to", type="integer", example="10"),
     *                  @OA\Property(property="total", type="integer", example="1-"),
     *             ),
     *          ),     
     *      )
     * ),
     */

    public function index(Request $request)
    {
        $limit = 10;
        if ($request->query('per_page')) {
            $limit = $request->query('per_page');
        }
        $events = Event::with('author')->paginate($limit);

        return $this->responseSuccess($events, 'request success');
    }

    /**
     * @OA\Post(
     * security={{"bearerAuth":{}}},
     *      path="/event",
     *      operationId="storeEvent",
     *      tags={"Events"},
     *      summary="Store new event",
     *      description="Returns event data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreEventRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",     
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="request success"),
     *              @OA\Property(property="payload", type="object",      
     *                    ref="#/components/schemas/Event"
     *              )
     *          ),
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="false"),
     *              @OA\Property(property="message", type="string", example="Validation errors"),
     *              @OA\Property(property="payload", type="object",      
     *                  @OA\Property(property="name", type="array",
     *                      @OA\Items(
     *                          example="The name field is required."
     *                      )
     *                  ),
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * ),
     */
    public function store(StoreEventRequest $request)
    {
        $input['name'] = $request['name'];
        $input['date'] = $request['date'];
        $input['time'] = $request['time'];
        $input['location'] = $request['location'];
        $input['created_by'] = Auth::user()->id;

        $event = Event::create($input);

        return $this->responseSuccess($event, 'Event created');
    }

    /**
     * @OA\Get(
     * security={{"bearerAuth":{}}},
     *      path="/event/{id}",
     *      operationId="getEventById",
     *      tags={"Events"},
     *      summary="Get event information",
     *      description="Returns event data",
     *      @OA\Parameter(
     *          name="id",
     *          description="event id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="request success"),
     *              @OA\Property(property="payload", type="object",      
     *                    ref="#/components/schemas/Event"
     *              )
     *          ),
     *       ),     
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function show($id)
    {
        try {
            $event = Event::with('author')->findOrFail($id);
            return $this->responseSuccess($event, 'request success');
        } catch (ModelNotFoundException $th) {
            return $this->responseError('data not found', $th);
        }
    }

    /**
     * @OA\Put(
     * security={{"bearerAuth":{}}},
     *      path="/event/{id}",
     *      operationId="updateEvent",
     *      tags={"Events"},
     *      summary="Update existing Event",
     *      description="Returns updated Event data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Event id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateEventRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="request success"),
     *              @OA\Property(property="payload", type="object",      
     *                    ref="#/components/schemas/Event"
     *              )
     *          ),
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="false"),
     *              @OA\Property(property="message", type="string", example="Validation errors"),
     *              @OA\Property(property="payload", type="object",      
     *                  @OA\Property(property="name", type="array",
     *                      @OA\Items(
     *                          example="The name field is required."
     *                      )
     *                  ),
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::with('author')->findOrFail($id);
        $event->with('author');
        $event->name = $request['name'];
        $event->save();

        return $this->responseSuccess($event, 'Request success');
    }

    /**
     * @OA\Delete(
     * security={{"bearerAuth":{}}},
     *      path="/event/{id}",
     *      operationId="deleteEvent",
     *      tags={"Events"},
     *      summary="Delete existing Event",
     *      description="Deletes a record and returns content that deleted",
     *      @OA\Parameter(
     *          name="id",
     *          description="Event id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="request success"),
     *              @OA\Property(property="payload", type="object",      
     *                    ref="#/components/schemas/Event"
     *              )
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        $event = Event::with('author')->findOrFail($id);
        $event->delete($event->id);

        return $this->responseSuccess($event, 'Request success');
    }
}
