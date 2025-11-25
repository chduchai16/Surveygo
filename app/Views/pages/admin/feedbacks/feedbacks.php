<?php
$appName = $appName ?? 'Admin - Quản lý Feedbacks';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/public/assets/css/admin.css" rel="stylesheet">
</head>

<body>
    <?php include BASE_PATH . '/app/Views/components/admin/_sidebar.php'; ?>

    <header class="admin-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Quản lý Feedback</h5>
            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Tìm kiếm feedback..." id="search-input">
                </div>
                <div class="user-menu" id="admin-user-menu">
                    <div class="user-avatar">AD</div>
                </div>
            </div>
        </div>
    </header>

    <main class="admin-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="feedback-search" class="form-control"
                            placeholder="Tìm theo tên người dùng...">
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Người gửi</th>
                                    <th>Đánh giá</th>
                                    <th>Bình luận</th>
                                    <th>Ngày gửi</th>
                                    <th style="width:160px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="feedback-table-body"></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3" id="feedback-pagination"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Thêm / Chỉnh sửa Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="feedback-form">
                        <input type="hidden" id="feedback-id">
                        <div class="mb-3">
                            <label class="form-label">Tên người dùng</label>
                            <input type="text" id="feedback-tenNguoiDung" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đánh giá</label>
                            <select id="feedback-danhGia" class="form-select" required>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bình luận</label>
                            <textarea id="feedback-binhLuan" class="form-control" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="feedback-save">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin-helpers.js"></script>
    <script src="/public/assets/js/admin-feedback.js"></script>
</body>

</html>