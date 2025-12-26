<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\UserInvite;

class InviteController extends Controller
{
    /**
     * Get current user's invite code and link
     * GET /api/invites/my-invite
     */
    public function getMyInvite()
    {
        $user = $this->getCurrentUser();
        
        if (!$user) {
            return Response::json([
                'error' => true,
                'message' => 'Unauthorized. Please login first.',
            ], 401);
        }

        try {
            // Get or create invite record for this user
            $invite = UserInvite::getOrCreate($user['id']);
            
            return Response::json([
                'error' => false,
                'data' => [
                    'invite_code' => $invite->getInviteCode(),
                    'invite_link' => $invite->getInviteLink(),
                    'invited_count' => $invite->getInvitedCount(),
                    'total_rewards' => $invite->getTotalRewards(),
                ],
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'message' => 'Error retrieving invite information: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate an invite code
     * GET /api/invites/validate?code=ABC123
     */
    public function validateCode()
    {
        $code = $_GET['code'] ?? '';
        
        if (!$code) {
            return Response::json([
                'error' => true,
                'message' => 'Invite code is required.',
            ], 400);
        }

        try {
            $invite = UserInvite::findByInviteCode($code);
            
            if (!$invite) {
                return Response::json([
                    'error' => false,
                    'valid' => false,
                    'message' => 'Mã mời không hợp lệ.',
                ]);
            }
            
            return Response::json([
                'error' => false,
                'valid' => true,
                'message' => 'Mã mời hợp lệ! Bạn và người giới thiệu sẽ nhận 500 điểm.',
                'data' => [
                    'inviter_id' => $invite->getUserId(),
                ],
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'message' => 'Error validating invite code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get referral statistics for current user
     * GET /api/invites/stats
     */
    public function getStats()
    {
        $user = $this->getCurrentUser();
        
        if (!$user) {
            return Response::json([
                'error' => true,
                'message' => 'Unauthorized. Please login first.',
            ], 401);
        }

        try {
            $invite = UserInvite::findByUserId($user['id']);
            
            if (!$invite) {
                return Response::json([
                    'error' => false,
                    'data' => [
                        'invited_count' => 0,
                        'total_rewards' => 0,
                    ],
                ]);
            }
            
            return Response::json([
                'error' => false,
                'data' => [
                    'invited_count' => $invite->getInvitedCount(),
                    'total_rewards' => $invite->getTotalRewards(),
                    'invite_code' => $invite->getInviteCode(),
                    'invite_link' => $invite->getInviteLink(),
                ],
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'message' => 'Error retrieving statistics: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper method to get current user from session
     */
    private function getCurrentUser(): ?array
    {
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'] ?? '',
                'name' => $_SESSION['user_name'] ?? '',
                'role' => $_SESSION['user_role'] ?? 'user',
            ];
        }
        
        // Fallback: try to get from GET/POST parameters
        $userId = $_GET['userId'] ?? $_POST['userId'] ?? null;
        if ($userId) {
            return ['id' => (int) $userId];
        }
        
        return null;
    }
}
