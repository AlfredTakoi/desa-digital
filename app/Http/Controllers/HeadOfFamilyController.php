<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeadOfFamilyStoreRequest;
use App\Http\Requests\HeadOfFamilyUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\PaginateResource;

class HeadOfFamilyController extends Controller
{
    private HeadOfFamilyRepositoryInterface $headOfFamilyRepository;
    public function __construct(HeadOfFamilyRepositoryInterface $headOfFamilyRepository){
        $this->headOfFamilyRepository = $headOfFamilyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request):JsonResponse
    {
        try {
            $headOfFamilies = $this->headOfFamilyRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Kepala Keluarga berhasil diambil', HeadOfFamilyResource::collection($headOfFamilies), 200);
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
            $headOfFamilies = $this->headOfFamilyRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Kepala Keluarga berhasil diambil', PaginateResource::make($headOfFamilies, HeadOfFamilyResource::class), 200);
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
    public function store(HeadOfFamilyStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $headOfFamily = $this->headOfFamilyRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Kepala Keluarga berhasil ditambahkan', new HeadOfFamilyResource($headOfFamily), 201);
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
            $headOfFamily = $this->headOfFamilyRepository->getById($id);
            if (!$headOfFamily) {
                return ResponseHelper::jsonResponse(false, 'Kepala Keluarga tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Kepala Keluarga berhasil diambil', new HeadOfFamilyResource($headOfFamily), 200);
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
    public function update(HeadOfFamilyUpdateRequest $request, string $id): JsonResponse
    {
        $request = $request->validated();

        try {
            $headOfFamily = $this->headOfFamilyRepository->getById($id);
            if (!$headOfFamily) {
                return ResponseHelper::jsonResponse(false, 'Kepala Keluarga tidak ditemukan', null, 404);
            }
            $headOfFamily = $this->headOfFamilyRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Kepala Keluarga berhasil diupdate', new HeadOfFamilyResource($headOfFamily), 200);
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
            $headOfFamily = $this->headOfFamilyRepository->getById($id);
            if (!$headOfFamily) {
                return ResponseHelper::jsonResponse(false, 'Kepala Keluarga tidak ditemukan', null, 404);
            }

            $this->headOfFamilyRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data Kepala Keluarga berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
