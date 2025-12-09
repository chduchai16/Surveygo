<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Container;
use PDO;

/**
 * Activity Log Model - Track user actions
 * 
 * Ghi lại tất cả hoạt động của user:
 * - Login, logout
 * - CRUD operations
 * - File uploads
 * - Status changes
 */
class ActivityLog
{
    private PDO $db;
    private string $table = 'activity_logs';

    public function __construct()
    {
        $this->db = Container::get('db');
    }


    public function log(int $userId, string $action, array $options = []): bool
    {
        $entityType = $options['entity_type'] ?? null;
        $entityId = $options['entity_id'] ?? null;
        $description = $options['description'] ?? null;
        $oldValues = $options['old_values'] ?? null;
        $newValues = $options['new_values'] ?? null;
        $ipAddress = $options['ip_address'] ?? ($this->getClientIp());
        $userAgent = $options['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? null;

        $query = "
            INSERT INTO {$this->table} 
            (user_id, action, entity_type, entity_id, description, ip_address, user_agent, old_values, new_values, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ";

        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $userId,
            $action,
            $entityType,
            $entityId,
            $description,
            $ipAddress,
            $userAgent,
            $oldValues ? json_encode($oldValues) : null,
            $newValues ? json_encode($newValues) : null,
        ]);
    }

    public function getByUserId(int $userId, int $limit = 50, int $offset = 0): array
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getByEntity(string $entityType, int $entityId, int $limit = 50): array
    {
        $query = "SELECT al.*, u.name as user_name, u.email FROM {$this->table} al LEFT JOIN users u ON al.user_id = u.id WHERE al.entity_type = ? AND al.entity_id = ? ORDER BY al.created_at DESC LIMIT {$limit}";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$entityType, $entityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getByAction(string $action, int $limit = 50, int $offset = 0): array
    {
        $query = "SELECT al.*, u.name as user_name, u.email FROM {$this->table} al LEFT JOIN users u ON al.user_id = u.id WHERE al.action = ? ORDER BY al.created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$action]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $query = "SELECT al.*, u.name as user_name, u.email FROM {$this->table} al LEFT JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function countAll(): int
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($result['total'] ?? 0);
    }

    public function countByUserId(int $userId): int
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) ($result['total'] ?? 0);
    }

    public function deleteOldLogs(int $days = 90): bool
    {
        $query = "DELETE FROM {$this->table} WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([$days]);
    }

    private function getClientIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        }
    }
}
