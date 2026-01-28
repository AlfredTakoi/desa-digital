<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use App\Interfaces\EventRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends Controller
{
    private EventRepositoryInterface $eventRepository;
    public function __construct(EventRepositoryInterface $eventRepository){
        $this->eventRepository = $eventRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $event = $this->eventRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Event berhasil diambil', EventResource::collection($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request): JsonResponse
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer'
        ]);

        try {
            $event = $this->eventRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Event berhasil diambil', PaginateResource::make($event, EventResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $event = $this->eventRepository->create($request);
            return ResponseHelper::jsonResponse(true, "Data Event berhasil ditambahkan", new EventResource($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try {
            $event = $this->eventRepository->getById($id);
            if (!$event) {
                return ResponseHelper::jsonResponse(false, 'Event tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Event berhasil diambil', new EventResource($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $event = $this->eventRepository->getById($id);
            if (!$event) {
                return ResponseHelper::jsonResponse(false, 'Event tidak ditemukan', null, 404);
            }
            $event = $this->eventRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diupdate', new EventResource($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $event = $this->eventRepository->getById($id);
            if (!$event) {
                return ResponseHelper::jsonResponse(false, 'Event tidak ditemukan', null, 404);
            }
            $event = $this->eventRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data Event berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
