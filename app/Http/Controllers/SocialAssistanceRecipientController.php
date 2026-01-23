<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocialAssistanceRecipientStoreRequest;
use App\Http\Requests\SocialAssistanceRecipientUpdateRequest;
use Illuminate\Http\Request;
use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SocialAssistanceRecipientResource;

class SocialAssistanceRecipientController extends Controller
{
    private $socialAssistanceRecipientRepository;
    public function __construct(SocialAssistanceRecipientRepositoryInterface $socialAssistanceRecipientRepository)
    {
        $this->socialAssistanceRecipientRepository = $socialAssistanceRecipientRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $recipients = $this->socialAssistanceRecipientRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil Diambil', SocialAssistanceRecipientResource::collection($recipients), 200);
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
            $recipients = $this->socialAssistanceRecipientRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );
            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil diambil', SocialAssistanceRecipientResource::collection($recipients), 200);
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
    public function store(SocialAssistanceRecipientStoreRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil ditambahkan', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 201);
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
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Penerima antuan Sosial tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial berhasil diambil', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 200);
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
    public function update(SocialAssistanceRecipientUpdateRequest $request, $id): JsonResponse
    {
        $request = $request->validated();
        try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Penerima antuan Sosial tidak ditemukan', null, 404);
            }
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->update($id, $request);
            return ResponseHelper::jsonResponse(true, 'Penerima Bantuan Sosial berhasil diperbarui', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 200);
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
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Penerima antuan Sosial tidak ditemukan', null, 404);
            }
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Penerima Bantuan Sosial berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
