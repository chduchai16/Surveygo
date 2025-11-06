<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Container;
use PDO;

class Survey
{
    private int $id;
    private string $maKhaoSat;
    private string $tieuDe;
    private ?string $moTa;
    private ?string $loaiKhaoSat;
    private ?string $thoiGianBatDau;
    private ?string $thoiGianKetThuc;
    private int $maNguoiTao;
    private string $trangThai;
    private int $diemThuong;
    private ?int $danhMuc;
    private ?int $maSuKien;
    private string $trangThaiKiemDuyet;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(array $attributes)
    {
        $this->id = (int)($attributes['id'] ?? 0);
        $this->maKhaoSat = $attributes['maKhaoSat'] ?? '';
        $this->tieuDe = $attributes['tieuDe'] ?? '';
        $this->moTa = $attributes['moTa'] ?? null;
        $this->loaiKhaoSat = $attributes['loaiKhaoSat'] ?? null;
        $this->thoiGianBatDau = $attributes['thoiGianBatDau'] ?? null;
        $this->thoiGianKetThuc = $attributes['thoiGianKetThuc'] ?? null;
        $this->maNguoiTao = (int)($attributes['maNguoiTao'] ?? 0);
        $this->trangThai = $attributes['trangThai'] ?? 'draft';
        $this->diemThuong = (int)($attributes['diemThuong'] ?? 0);
        $this->danhMuc = $attributes['danhMuc'] ? (int)$attributes['danhMuc'] : null;
        $this->maSuKien = $attributes['maSuKien'] ? (int)$attributes['maSuKien'] : null;
        $this->trangThaiKiemDuyet = $attributes['trangThaiKiemDuyet'] ?? 'pending';
        $this->createdAt = $attributes['created_at'] ?? '';
        $this->updatedAt = $attributes['updated_at'] ?? '';
    }

    /**
     * Lấy tất cả khảo sát (sắp xếp theo created_at DESC)
     */
    public static function all(): array
    {
        /** @var PDO $db */
        $db = Container::get('db');

        $statement = $db->query('SELECT * FROM surveys ORDER BY created_at DESC');
        $rows = $statement->fetchAll();

        return array_map(fn($row) => new self($row), $rows);
    }

    /**
     * Lấy khảo sát theo ID
     */
    public static function find(int $id): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');

        $statement = $db->prepare('SELECT * FROM surveys WHERE id = :id LIMIT 1');
        $statement->execute([':id' => $id]);
        $row = $statement->fetch();

        return $row ? new self($row) : null;
    }

    /**
     * Lấy khảo sát theo maKhaoSat
     */
    public static function findByMa(string $maKhaoSat): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');

        $statement = $db->prepare('SELECT * FROM surveys WHERE maKhaoSat = :ma LIMIT 1');
        $statement->execute([':ma' => $maKhaoSat]);
        $row = $statement->fetch();

        return $row ? new self($row) : null;
    }

    /**
     * Tạo khảo sát mới
     * - Auto-gen maKhaoSat nếu không cung cấp
     * - Validate maNguoiTao phải tồn tại
     */
    public static function create(array $data): ?self
    {
        /** @var PDO $db */
        $db = Container::get('db');

        // Validate required fields
        if (empty($data['tieuDe'])) {
            return null; // Validation failed, nên throw exception trong controller
        }

        if (empty($data['maNguoiTao'])) {
            return null;
        }

        // Verify user exists
        $userStmt = $db->prepare('SELECT id FROM users WHERE id = :id LIMIT 1');
        $userStmt->execute([':id' => $data['maNguoiTao']]);
        if (!$userStmt->fetch()) {
            return null; // User không tồn tại
        }

        // Auto-gen maKhaoSat nếu chưa có
        $maKhaoSat = $data['maKhaoSat'] ?? 'KS-' . time();

        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        try {
            $statement = $db->prepare(
                'INSERT INTO surveys (maKhaoSat, tieuDe, moTa, loaiKhaoSat, thoiGianBatDau, thoiGianKetThuc, maNguoiTao, trangThai, diemThuong, danhMuc, soLuongCauHoi, soNguoiThamGia, maSuKien, trangThaiKiemDuyet, created_at, updated_at)
                VALUES (:ma, :tieu, :mo, :loai, :start, :end, :user, :status, :diem, :danh, :soluong, :songuoi, :sukien, :kiemduyet, :created, :updated)'
            );

            $statement->execute([
                ':ma' => $maKhaoSat,
                ':tieu' => $data['tieuDe'],
                ':mo' => $data['moTa'] ?? null,
                ':loai' => $data['loaiKhaoSat'] ?? null,
                ':start' => $data['thoiGianBatDau'] ?? null,
                ':end' => $data['thoiGianKetThuc'] ?? null,
                ':user' => $data['maNguoiTao'],
                ':status' => $data['trangThai'] ?? 'draft',
                ':diem' => (int)($data['diemThuong'] ?? 0),
                ':danh' => $data['danhMuc'] ?? null,
                ':soluong' => 0,
                ':songuoi' => (int)($data['soNguoiThamGia'] ?? 0),
                ':sukien' => $data['maSuKien'] ?? null,
                ':kiemduyet' => 'pending',
                ':created' => $now,
                ':updated' => $now,
            ]);

            $id = (int)$db->lastInsertId();
            return self::find($id);
        } catch (\PDOException $e) {
            return null; // Duplicate maKhaoSat hoặc lỗi DB
        }
    }

    /**
     * Cập nhật khảo sát
     */
    public function update(array $data): bool
    {
        /** @var PDO $db */
        $db = Container::get('db');

        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $tieuDe = $data['tieuDe'] ?? $this->tieuDe;
        $moTa = $data['moTa'] ?? $this->moTa;
        $loaiKhaoSat = $data['loaiKhaoSat'] ?? $this->loaiKhaoSat;
        $thoiGianBatDau = $data['thoiGianBatDau'] ?? $this->thoiGianBatDau;
        $thoiGianKetThuc = $data['thoiGianKetThuc'] ?? $this->thoiGianKetThuc;
        $trangThai = $data['trangThai'] ?? $this->trangThai;
        $diemThuong = $data['diemThuong'] ?? $this->diemThuong;
        $danhMuc = $data['danhMuc'] ?? $this->danhMuc;
        $maSuKien = $data['maSuKien'] ?? $this->maSuKien;
        $trangThaiKiemDuyet = $data['trangThaiKiemDuyet'] ?? $this->trangThaiKiemDuyet;

        $statement = $db->prepare(
            'UPDATE surveys SET tieuDe = :tieu, moTa = :mo, loaiKhaoSat = :loai, thoiGianBatDau = :start, thoiGianKetThuc = :end,
             trangThai = :status, diemThuong = :diem, danhMuc = :danh, maSuKien = :sukien, trangThaiKiemDuyet = :kiemduyet, updated_at = :updated WHERE id = :id'
        );

        return $statement->execute([
            ':tieu' => $tieuDe,
            ':mo' => $moTa,
            ':loai' => $loaiKhaoSat,
            ':start' => $thoiGianBatDau,
            ':end' => $thoiGianKetThuc,
            ':status' => $trangThai,
            ':diem' => (int)$diemThuong,
            ':danh' => $danhMuc,
            ':sukien' => $maSuKien,
            ':kiemduyet' => $trangThaiKiemDuyet,
            ':updated' => $now,
            ':id' => $this->id,
        ]);
    }

    /**
     * Xóa khảo sát (cascade xóa câu hỏi)
     */
    public function delete(): bool
    {
        /** @var PDO $db */
        $db = Container::get('db');

        $statement = $db->prepare('DELETE FROM surveys WHERE id = :id');
        return $statement->execute([':id' => $this->id]);
    }

    /**
     * Cập nhật trạng thái khảo sát
     */
    public function updateStatus(string $trangThai): bool
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        /** @var PDO $db */
        $db = Container::get('db');

        $statement = $db->prepare('UPDATE surveys SET trangThai = :status, updated_at = :updated WHERE id = :id');
        return $statement->execute([
            ':status' => $trangThai,
            ':updated' => $now,
            ':id' => $this->id,
        ]);
    }

    /**
     * Cập nhật trạng thái kiểm duyệt
     */
    public function updateVerificationStatus(string $trangThaiKiemDuyet): bool
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        /** @var PDO $db */
        $db = Container::get('db');

        $statement = $db->prepare('UPDATE surveys SET trangThaiKiemDuyet = :kiemduyet, updated_at = :updated WHERE id = :id');
        return $statement->execute([
            ':kiemduyet' => $trangThaiKiemDuyet,
            ':updated' => $now,
            ':id' => $this->id,
        ]);
    }

    /**
     * Chuyển đổi thành array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'maKhaoSat' => $this->maKhaoSat,
            'tieuDe' => $this->tieuDe,
            'moTa' => $this->moTa,
            'loaiKhaoSat' => $this->loaiKhaoSat,
            'thoiGianBatDau' => $this->thoiGianBatDau,
            'thoiGianKetThuc' => $this->thoiGianKetThuc,
            'maNguoiTao' => $this->maNguoiTao,
            'trangThai' => $this->trangThai,
            'diemThuong' => $this->diemThuong,
            'danhMuc' => $this->danhMuc,
            'maSuKien' => $this->maSuKien,
            'trangThaiKiemDuyet' => $this->trangThaiKiemDuyet,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getMaKhaoSat(): string { return $this->maKhaoSat; }
    public function getTieuDe(): string { return $this->tieuDe; }
    public function getMoTa(): ?string { return $this->moTa; }
    public function getMaNguoiTao(): int { return $this->maNguoiTao; }
    public function getTrangThai(): string { return $this->trangThai; }
    public function getTrangThaiKiemDuyet(): string { return $this->trangThaiKiemDuyet; }
}