<?php

namespace App\Repositories;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Models\SocialAssistance;
use Illuminate\Support\Facades\DB;

class SocialAssistanceRepository implements SocialAssistanceRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
    ) {
        $query = SocialAssistance::where(function ($query) use ($search, $limit, $execute) {
            if ($search) {
                $query->search($search);
            }
        });

        $query->orderBy('created_at', 'desc');

        if ($limit) {
            $query->take($limit);
        }

        if ($execute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(
        ?string $search,
        ?int $rowPerPage,
    ) {
        $query = $this->getAll($search, $rowPerPage, false);
        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
       DB::beginTransaction();
       try {
            $soclaAssistance = new SocialAssistance;
            $soclaAssistance->name = $data['name'];
            $soclaAssistance->thumbnail = $data['thumbnail']->store('assets/social_assistances', 'public');
            $soclaAssistance->category = $data['category'];
            $soclaAssistance->amount = $data['amount'];
            $soclaAssistance->provider = $data['provider'];
            $soclaAssistance->description = $data['description'];
            $soclaAssistance->is_available = $data['is_available'];
            $soclaAssistance->save();
            DB::commit();
            return $soclaAssistance;
       } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
       }
    }

    public function getById(string $id)
    {
        $query = SocialAssistance::where('id', $id);
        return $query->first();
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $socialAssistance = SocialAssistance::find($id);

            $socialAssistance->name = $data['name'];
            if (isset($data['thumbnail'])) {
                $socialAssistance->thumbnail = $data['thumbnail']->store('assets/social_assistances', 'public');
            }
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'];

            $socialAssistance->save();
            DB::commit();
            return $socialAssistance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $socialAssistance = SocialAssistance::find($id);
            $socialAssistance->delete();
            DB::commit();
            return $socialAssistance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
