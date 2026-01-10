<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyMemberStoreRequest;
use App\Http\Requests\FamilyMemberUpdateRequest;
use App\Http\Resources\FamilyMemberResource;
use Illuminate\Http\Request;
use App\Interfaces\FamilyMemberRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;

class FamilyMemberController extends Controller
{
    private FamilyMemberRepositoryInterface $familyMemberRepository;
    public function __construct(FamilyMemberRepositoryInterface $familyMemberRepository){
        $this->familyMemberRepository = $familyMemberRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
         try {
            $familyMember = $this->familyMemberRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diambil', FamilyMemberResource::collection($familyMember), 200);
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
            $familyMembers = $this->familyMemberRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diambil', PaginateResource::make($familyMembers, FamilyMemberResource::class), 200);
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
    public function store(FamilyMemberUpdateRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $familyMember = $this->familyMemberRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil ditambahkan', new FamilyMemberResource($familyMember), 200);
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
            $familyMember = $this->familyMemberRepository->getById($id);
            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Anggota Keluarga tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diambil', new FamilyMemberResource($familyMember), 200);
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
    public function update(FamilyMemberUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $familyMember = $this->familyMemberRepository->getById($id);
            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Anggota Keluarga tidak ditemukan', null, 404);
            }

            $familyMember = $this->familyMemberRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil diupdate', new FamilyMemberResource($familyMember), 200);
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
            $familyMember = $this->familyMemberRepository->getById($id);
            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Anggota Keluarga tidak ditemukan', null, 404);
            }
            $this->familyMemberRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
