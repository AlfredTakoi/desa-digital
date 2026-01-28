<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use App\Http\Resources\EventParticipantResource;
use App\Interfaces\EventParticipantRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventParticipantController extends Controller
{
    private EventParticipantRepositoryInterface $eventParticipantRepository;
    public function __construct(EventParticipantRepositoryInterface $eventParticipantRepository){
        $this->eventParticipantRepository = $eventParticipantRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $eventParticipants = $this->eventParticipantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Event berhasil diambil', EventParticipantResource::collection($eventParticipants), 200);
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
            $eventParticipants = $this->eventParticipantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Event berhasil diambil', PaginateResource::make($eventParticipants, EventParticipantResource::class), 200);
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
    public function store(EventParticipantStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $eventParticipant = $this->eventParticipantRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Event berhasil ditambahkan', new EventParticipantResource($eventParticipant), 200);
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
            $eventParticipant = $this->eventParticipantRepository->getById($id);
            if (!$eventParticipant) {
                return ResponseHelper::jsonResponse(false, 'Pendaftar Event tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diambil', new EventParticipantResource($eventParticipant), 200);
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
    public function update(EventParticipantUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);
            if (!$eventParticipant) {
                return ResponseHelper::jsonResponse(false, 'Pendaftar Event tidak ditemukan', null, 404);
            }
            $eventParticipant = $this->eventParticipantRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diupdate', new EventParticipantResource($eventParticipant), 200);
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
            $eventParticipant = $this->eventParticipantRepository->getById($id);
            if (!$eventParticipant) {
                return ResponseHelper::jsonResponse(false, 'Pendaftar Event tidak ditemukan', null, 404);
            }
            $eventParticipant = $this->eventParticipantRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Event berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
