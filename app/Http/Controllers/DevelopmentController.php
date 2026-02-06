<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevelopmentStoreRequest;
use App\Http\Requests\DevelopmentUpdateRequest;
use App\Http\Resources\DevelopmentResource;
use App\Interfaces\DevelopmentRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class DevelopmentController extends Controller
{
    private DevelopmentRepositoryInterface $developmentRepository;
    public function __construct(DevelopmentRepositoryInterface $developmentRepository){
        $this->developmentRepository = $developmentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $development = $this->developmentRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Development berhasil diambil', DevelopmentResource::collection($development), 200);
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
            $development = $this->developmentRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Development berhasil diambil', PaginateResource::make($development, DevelopmentResource::class), 200);
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
    public function store(DevelopmentStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $development = $this->developmentRepository->create($request);
            return ResponseHelper::jsonResponse(true, "Data Development berhasil ditambahkan", new DevelopmentResource($development), 200);
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
            $development = $this->developmentRepository->getById($id);
            if (!$development) {
                return ResponseHelper::jsonResponse(false, 'Development tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Development berhasil diambil', new DevelopmentResource($development), 200);
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
    public function update(DevelopmentUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $development = $this->developmentRepository->getById($id);
            if (!$development) {
                return ResponseHelper::jsonResponse(false, 'Development tidak ditemukan', null, 404);
            }
            $development = $this->developmentRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Data Development berhasil diupdate', new DevelopmentResource($development), 200);
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
            $development = $this->developmentRepository->getById($id);
            if (!$development) {
                return ResponseHelper::jsonResponse(false, 'Development tidak ditemukan', null, 404);
            }
            $event = $this->developmentRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data Development berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
