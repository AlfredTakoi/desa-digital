<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevelopmentApplicantStoreRequest;
use App\Http\Requests\DevelopmentApplicantUpdateRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;
    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository){
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan berhasil diambil', DevelopmentApplicantResource::collection($developmentApplicant), 200);
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
            $developmentApplicant = $this->developmentApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan berhasil diambil', PaginateResource::make($developmentApplicant, DevelopmentApplicantResource::class), 200);
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
    public function store(DevelopmentApplicantStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $developmentApplicant = $this->developmentApplicantRepository->create($request);
            return ResponseHelper::jsonResponse(true, "Data Pendaftar Pembangunan berhasil ditambahkan", new DevelopmentApplicantResource($developmentApplicant), 200);
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
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Pendaftar Pembangunan tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan berhasil diambil', new DevelopmentApplicantResource($developmentApplicant), 200);
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
    public function update(DevelopmentApplicantUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Pendaftar Pembangunan tidak ditemukan', null, 404);
            }
            $developmentApplicant = $this->developmentApplicantRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan berhasil diupdate', new DevelopmentApplicantResource($developmentApplicant), 200);
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
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Pendaftar Pembangunan tidak ditemukan', null, 404);
            }
            $developmentApplicant = $this->developmentApplicantRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
