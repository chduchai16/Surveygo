<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Container;
use PDO;

class UserInvite
{
    private int $id;
    private int $userId;
    private string $inviteCode;
    private ?string $inviteToken;
    private string $inviteLink;
    private int $invitedCount;
    private int $totalRewards;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(array $attributes)
    {
        $this->id = (int) ($attributes['id'] ?? 0);
        $this->userId = (int) $attributes['user_id'];
        $this->inviteCode = (string) $attributes['invite_code'];
        $this->inviteToken = $attributes['invite_token'] ?? null;
        $this->inviteLink = (string) $attributes['invite_link'];
        $this->invitedCount = (int) ($attributes['invited_count'] ?? 0);
        $this->totalRewards = (int) ($attributes['total_rewards'] ?? 0);
        $this->createdAt = $attributes['created_at'];
        $this->updatedAt = $attributes['updated_at'];
    }

    /**
     * Generate a unique 6-digit alphanumeric invite code
     */
    private static function generateInviteCode(): string
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $maxAttempts = 10;
        for ($i = 0; $i < $maxAttempts; $i++) {
            // Generate 6-character alphanumeric code (uppercase and numbers)
            $code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);
            
            // Check if code already exists
            $stmt = $db->prepare('SELECT COUNT(*) as count FROM user_invites WHERE invite_code = :code');
            $stmt->execute([':code' => $code]);
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                return $code;
            }
        }
        
        // Fallback: use timestamp-based code
        return strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 6));
    }

    /**
     * Generate a unique random invite token
     */
    private static function generateInviteToken(): string
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $maxAttempts = 10;
        for ($i = 0; $i < $maxAttempts; $i++) {
            // Generate 32-character random token
            $token = bin2hex(random_bytes(16));
            
            // Check if token already exists
            $stmt = $db->prepare('SELECT COUNT(*) as count FROM user_invites WHERE invite_token = :token');
            $stmt->execute([':token' => $token]);
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                return $token;
            }
        }
        
        // Fallback (unlikely to happen)
        return bin2hex(random_bytes(16));
    }

    /**
     * Generate invite link based on token
     */
    private static function generateInviteLink(string $token): string
    {
        // Get base URL from server configuration
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        return "{$protocol}://{$host}/register?token={$token}";
    }

    /**
     * Create a new invite record for a user
     */
    public static function create(int $userId): self
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $code = self::generateInviteCode();
        $token = self::generateInviteToken();
        $link = self::generateInviteLink($token);
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        
        $stmt = $db->prepare(
            'INSERT INTO user_invites (user_id, invite_code, invite_token, invite_link, invited_count, total_rewards, created_at, updated_at) 
             VALUES (:user_id, :invite_code, :invite_token, :invite_link, 0, 0, :created_at, :updated_at)'
        );
        
        $stmt->execute([
            ':user_id' => $userId,
            ':invite_code' => $code,
            ':invite_token' => $token,
            ':invite_link' => $link,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);
        
        $id = (int) $db->lastInsertId();
        
        return self::findById($id);
    }

    /**
     * Find invite record by ID
     */
    public static function findById(int $id): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $stmt = $db->prepare('SELECT * FROM user_invites WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new self($row);
    }

    /**
     * Find invite record by user ID
     */
    public static function findByUserId(int $userId): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $stmt = $db->prepare('SELECT * FROM user_invites WHERE user_id = :user_id LIMIT 1');
        $stmt->execute([':user_id' => $userId]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new self($row);
    }

    /**
     * Find invite record by invite code
     */
    public static function findByInviteCode(string $code): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $stmt = $db->prepare('SELECT * FROM user_invites WHERE invite_code = :code LIMIT 1');
        $stmt->execute([':code' => strtoupper($code)]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new self($row);
    }

    /**
     * Find invite record by invite token
     */
    public static function findByToken(string $token): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $stmt = $db->prepare('SELECT * FROM user_invites WHERE invite_token = :token LIMIT 1');
        $stmt->execute([':token' => $token]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new self($row);
    }

    /**
     * Get or create invite record for a user
     */
    public static function getOrCreate(int $userId): self
    {
        $invite = self::findByUserId($userId);
        
        if (!$invite) {
            $invite = self::create($userId);
        }
        
        return $invite;
    }

    /**
     * Increment the invited count for this user
     */
    public function incrementInviteCount(): void
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        
        $stmt = $db->prepare(
            'UPDATE user_invites 
             SET invited_count = invited_count + 1, updated_at = :updated_at 
             WHERE id = :id'
        );
        
        $stmt->execute([
            ':updated_at' => $now,
            ':id' => $this->id,
        ]);
        
        $this->invitedCount++;
    }

    /**
     * Add to total rewards earned from referrals
     */
    public function addRewards(int $amount): void
    {
        /** @var PDO $db */
        $db = Container::get('db');
        
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        
        $stmt = $db->prepare(
            'UPDATE user_invites 
             SET total_rewards = total_rewards + :amount, updated_at = :updated_at 
             WHERE id = :id'
        );
        
        $stmt->execute([
            ':amount' => $amount,
            ':updated_at' => $now,
            ':id' => $this->id,
        ]);
        
        $this->totalRewards += $amount;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getInviteCode(): string
    {
        return $this->inviteCode;
    }

    public function getInviteLink(): string
    {
        return $this->inviteLink;
    }

    public function getInvitedCount(): int
    {
        return $this->invitedCount;
    }

    public function getTotalRewards(): int
    {
        return $this->totalRewards;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getInviteToken(): ?string
    {
        return $this->inviteToken;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'invite_code' => $this->inviteCode,
            'invite_token' => $this->inviteToken,
            'invite_link' => $this->inviteLink,
            'invited_count' => $this->invitedCount,
            'total_rewards' => $this->totalRewards,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
