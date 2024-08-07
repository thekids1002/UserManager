<?php

namespace App\Services;

use App\Libs\{DateUtil};
use App\Repositories\UserRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function search(array $params) {
        if (isset($params['started_date_from'])) {
            $params['started_date_from'] = DateUtil::formatDate2($params['started_date_from'], 'Y/m/d');
        }

        if (isset($params['started_date_to'])) {
            $params['started_date_to'] = DateUtil::formatDate2($params['started_date_to'], 'Y/m/d');
        }
        $users = $this->userRepository->search($params);

        return $users;
    }

    public function exportCSV(array $params) {
        if (isset($params['started_date_from'])) {
            $params['started_date_from'] = DateUtil::formatDate2($params['started_date_from'], 'Y/m/d');
        }

        if (isset($params['started_date_to'])) {
            $params['started_date_to'] = DateUtil::formatDate2($params['started_date_to'], 'Y/m/d');
        }
         
        $users = $this->userRepository->exportCSV($params);
        return $users;
    }

    public function create($data)
    {
        $email = $data['email'];
        $password = $data['password'];
        $name = $data['name'];
        $group_id = $data['group_id'];
        $started_date = $data['started_date'] ?? null;
        $position_id = $data['position_id'] ?? null;

        $userData = [
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
            'group_id' => $group_id,
            'started_date' => $started_date ? DateTime::createFromFormat('d/m/Y', $started_date)->format('Y-m-d') : null,
            'position_id' => $position_id,
        ];
        return $this->userRepository->save(null, $userData, true);

    }


    public function edit($data)
    {   $id = $data['id'];
        $email = $data['email'];
        $newPassword  = $data['password'];
        $name = $data['name'];
        $group_id = $data['group_id'];
        $started_date = $data['started_date'] ?? null;
        $position_id = $data['position_id'] ?? null;

        $userData = [
            'email' => $email,
            'name' => $name,
            'group_id' => $group_id,
            'started_date' => $started_date ? DateTime::createFromFormat('d/m/Y', $started_date)->format('Y-m-d') : null,
            'position_id' => $position_id,
        ];
        if ($newPassword) {
            $userData['password'] = Hash::make($newPassword);
        }
        return $this->userRepository->save($id , $userData, true);

    }
}
