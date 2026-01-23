<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocialAssistanceStoreRequest;
use App\Http\Requests\SocialAssistanceUpdateRequest;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Resources\SocialAssistanceResource;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PaginateResource;

class SocialAssistanceController extends Controller
{
    private SocialAssistanceRepositoryInterface $socialAssistanceRepository;
    public function __construct(SocialAssistanceRepositoryInterface $socialAssistanceRepository)
    {
        $this->socialAssistanceRepository = $socialAssistanceRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request):JsonResponse
    {
        try {
            $socialAssistances = $this->socialAssistanceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil Diambil', SocialAssistanceResource::collection($socialAssistances), 200);
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
            $socialAssstances = $this->socialAssistanceRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil diambil', PaginateResource::make($socialAssstances, SocialAssistanceResource::class), 200);
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
    public function store(SocialAssistanceStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $socialAssistance = $this->socialAssistanceRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial berhasil ditambahkan', new SocialAssistanceResource($socialAssistance), 201);
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
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Bantuan Sosial tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Bantuan Sosial berhasil diambil', new SocialAssistanceResource($socialAssistance), 200);
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
    public function update(SocialAssistanceUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Bantuan Sosial tidak ditemukan', null, 404);
            }
            $socialAssistance = $this->socialAssistanceRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial berhasil diperbarui', new SocialAssistanceResource($socialAssistance), 200);
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
            $socialAssistance = $this->socialAssistanceRepository->getById($id);
            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Bantuan Sosial tidak ditemukan', null, 404);
            }
            $this->socialAssistanceRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Bantuan Sosial berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
