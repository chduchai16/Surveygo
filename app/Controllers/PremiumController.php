<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Container;

/**
 * Controller for premium subscription features
 * Gọi trực tiếp external service, không lưu database
 */
class PremiumController extends Controller
{
    /**
     * Get the premium check URL from config
     */
    private function getPremiumServiceUrl(): string
    {
        $config = Container::get('config');
        return $config['premium_check_url'] ?? 'http://localhost:8002';
    }

    /**
     * Create a new premium transaction - gọi external service để lấy QR
     * POST /api/premium/create-transaction
     */
    public function createTransaction(Request $request): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return Response::json([
                'error' => true,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Generate unique external ID dựa trên user ID
        $externalId = 'user_' . $userId;

        // Call external service to create transaction
        $serviceUrl = $this->getPremiumServiceUrl();
        $url = $serviceUrl . '/transactions';

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode(['external_id' => $externalId]),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                return Response::json([
                    'error' => true,
                    'message' => 'Không thể kết nối tới dịch vụ thanh toán: ' . $curlError,
                ], 500);
            }

            if ($httpCode !== 200 && $httpCode !== 201) {
                return Response::json([
                    'error' => true,
                    'message' => 'Dịch vụ thanh toán trả về lỗi',
                ], 500);
            }

            $data = json_decode($response, true);
            if (!$data) {
                return Response::json([
                    'error' => true,
                    'message' => 'Không thể đọc phản hồi từ dịch vụ thanh toán',
                ], 500);
            }

            return Response::json([
                'error' => false,
                'message' => 'Tạo giao dịch thành công',
                'external_id' => $externalId,
                'qr_link' => $data['qr_link'] ?? null,
                'amount_expected' => $data['amount_expected'] ?? 15000,
                'amount_received' => $data['amount_received'] ?? 0,
            ]);

        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'message' => 'Lỗi khi tạo giao dịch: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check premium status - gọi external service /check/{external_id}
     * GET /api/premium/status
     */
    public function getStatus(Request $request): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return Response::json([
                'error' => true,
                'message' => 'Unauthorized',
            ], 401);
        }

        $externalId = 'user_' . $userId;
        $serviceUrl = $this->getPremiumServiceUrl();
        $url = $serviceUrl . '/check/' . $externalId;

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                // Service không trả về hoặc lỗi -> chưa có giao dịch -> chưa premium
                return Response::json([
                    'error' => false,
                    'is_premium' => false,
                    'status' => 'pending',
                ]);
            }

            $data = json_decode($response, true);
            $status = $data['status'] ?? 'pending';
            $isPremium = ($status === 'completed');

            return Response::json([
                'error' => false,
                'is_premium' => $isPremium,
                'status' => $status,
                'external_id' => $data['external_id'] ?? $externalId,
            ]);

        } catch (\Exception $e) {
            return Response::json([
                'error' => false,
                'is_premium' => false,
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Check payment status for current transaction
     * GET /api/premium/check-payment
     */
    public function checkPayment(Request $request): Response
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return Response::json([
                'error' => true,
                'message' => 'Unauthorized',
            ], 401);
        }

        $externalId = 'user_' . $userId;
        $serviceUrl = $this->getPremiumServiceUrl();
        $url = $serviceUrl . '/check/' . $externalId;

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                return Response::json([
                    'error' => false,
                    'is_paid' => false,
                    'status' => 'pending',
                    'status_text' => 'Chưa thanh toán',
                ]);
            }

            $data = json_decode($response, true);
            $status = $data['status'] ?? 'pending';
            $isPaid = ($status === 'completed');

            $statusText = 'Chưa thanh toán';
            if ($isPaid) {
                $statusText = 'Đã thanh toán thành công';
            }

            return Response::json([
                'error' => false,
                'is_paid' => $isPaid,
                'status' => $status,
                'status_text' => $statusText,
            ]);

        } catch (\Exception $e) {
            return Response::json([
                'error' => false,
                'is_paid' => false,
                'status' => 'pending',
                'status_text' => 'Chưa thanh toán',
            ]);
        }
    }
}
