<?php

namespace App\Managers;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserManager
{
    protected UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }


    public function getUserById($id)
    {
        return $this->users->find($id);
    }

    public function checkUserContacts($userId): JsonResponse
    {
        // Fetch the user with their contacts
        $user = User::with('contacts')->find($userId);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Check if the user has multiple contacts
        if ($user->contacts->count() > 1) {
            return response()->json([
                'status' => 'success',
                'message' => 'User has multiple contacts.',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'User has no contacts.',
            ]);
        }
    }
}
