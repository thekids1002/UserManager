<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{Hash};

class UserRepository extends BaseRepository
{
    public function getModel() {
        return User::class;
    }

    /**
     * Get user login
     *
     * @param array $params
     * @return mixed
     */
    /**
     * Get user login
     *
     * @param array $params
     * @return mixed
     */
    public function getUserLogin(array $params) {
        $query = User::query()
            ->where('email', $params['email'] ?? null)
            ->where('deleted_date', null);

        $user = $query->get()->first();
        if ($user && Hash::check($params['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    public function checkDuplicateEmailForLogin(string $email, string $password) {
        try {
            $result = $this->model->where('email', $email)
                ->whereNull('deleted_date')
                ->get();
        } catch (Exception $exption) {
        }
        if ($result) {
            $duplicate = [];
            foreach ($result as $user) {
                if (Hash::check($password, $user->password)) {
                    $duplicate[] = $user;
                }
            }

            return count($duplicate) > 1;
        }

        return false;
    }

   /**
     * Get user list by email
     *
     * @param string email
     * @param @mixed id
     * @return @mixed $result
     */
    public function getByEmail(string $email, $id = null)
    {
        if (isset($id)) {
            $result = $this->model->where('email', $email)->whereNull('deleted_date')
                ->where('id', '!=', $id)
                ->get();
        } else {
            // OrderSpecChange #128501
            $result = $this->model->where('email', $email)->whereNull('deleted_date')
                ->get();
        }

        if ($result) {
            return $result;
        }

        return [];
    }


    public function search(array $params) {
        $query = User::whereRaw('1=1');
        $query->whereNull('deleted_date');

        if (isset($params['name'])) {
            $query->where('name', 'LIKE', '%' . $params['name'] . '%');
        }

        if (isset($params['started_date_from'])) {
            $dateFrom = $params['started_date_from'];
            $query->where('started_date', '>=', $dateFrom);
        }
        if (isset($params['started_date_to'])) {
            $dateTo = $params['started_date_to'];
            $query->where('started_date', '<=', $dateTo);
        }

        $query->orderBy('name', 'asc')
            ->orderBy('started_date', 'asc')
            ->orderBy('id', 'asc');

        return $query;
    }

    public function exportCSV(array $params) {
        $query = $this->search($params);
        $results = [];
        $query->chunk(100, function ($users) use (&$results) {
            foreach ($users as $user) {
                $results[] = $this->mapUserToCsvRow($user);
            }
        });
        
        return $results;
    }

    private function mapUserToCsvRow($user) {
        $started_date = $user->started_date ? $user->started_date->format('d/m/Y') : '';
        $created_date = $user->created_date ? $user->created_date->format('d/m/Y') : '';
        $updated_date = $user->updated_date ? $user->updated_date->format('d/m/Y') : '';

        return array_map(function ($value) {
            return '"' . $value . '"';
        }, [
            $user->id,
            $user->name,
            $user->email,
            $user->group_id,
            $user->group->name ?? '',
            $started_date,
            $user->getPosition(),
            $created_date,
            $updated_date,
        ]);

        // return [
        //     '"' . $user->id . '"',
        //     '"' . $user->name . '"',
        //     '"' . $user->email . '"',
        //     '"' . $user->group_id . '"',
        //     ($user->group && $user->group->name) ? '"' . $user->group->name . '"' : '',
        //     '"' . $started_date . '"',
        //     '"' . $user->position_id . '"',
        //     '"' . $created_date . '"',
        //     '"' . $updated_date . '"',
        // ];
    }
}
