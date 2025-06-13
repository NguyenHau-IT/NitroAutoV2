<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container d-flex justify-content-center align-items-center mt-2">
        <div class="bg-white text-dark shadow-lg rounded-4 p-4 w-100" style="max-width: 700px;">
            <div class="mb-4 border-bottom pb-2">
                <h3 class="card-title text-center mb-4">
                    <i class="bi bi-shield-lock-fill me-2 text-primary"></i> Đổi mật khẩu
                </h3>

                <form action="" method="POST">
                    <!-- Mật khẩu cũ -->
                    <div class="mb-4">
                        <label for="old_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-1 text-secondary"></i> Mật khẩu cũ
                        </label>
                        <div class="input-group password-toggle-group">
                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                            <input type="password" name="old_password" id="old_password" class="form-control" required>
                            <span class="input-group-text toggle-password" data-target="old_password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Mật khẩu mới -->
                    <div class="mb-4">
                        <label for="new_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-1 text-secondary"></i> Mật khẩu mới
                        </label>
                        <div class="input-group password-toggle-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Ít nhất 8 ký tự, chữ hoa/thường/số/ký tự đặc biệt" required
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
                                title="Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt">
                            <span class="input-group-text toggle-password" data-target="new_password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Nhập lại mật khẩu -->
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-1 text-secondary"></i> Nhập lại mật khẩu mới
                        </label>
                        <div class="input-group password-toggle-group">
                            <span class="input-group-text"><i class="bi bi-check2-square"></i></span>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            <span class="input-group-text toggle-password" data-target="confirm_password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Nút submit + quay lại -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 rounded-3 shadow-sm transition-all duration-300 hover:bg-primary-dark">
                            <i class="bi bi-arrow-repeat me-1"></i> Cập nhật mật khẩu
                        </button>
                        <a href="/profile" class="btn btn-outline-secondary py-2 rounded-3 shadow-sm transition-all duration-300 hover:bg-gray-200">
                            <i class="bi bi-arrow-left-circle me-1"></i> Quay lại trang cá nhân
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Style cho nút toggle -->
<style>
    .toggle-password {
        cursor: pointer;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }

    .input-group-text i {
        color: #495057;
    }

    .form-control {
        border-radius: 0.375rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
    }

    .btn {
        border-radius: 0.375rem;
    }

    .card {
        border-radius: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Script toggle mật khẩu + kiểm tra khớp -->
<script>
    // Kiểm tra mật khẩu nhập lại có khớp không
    document.querySelector("form").addEventListener("submit", function(e) {
        const newPass = document.getElementById("new_password").value;
        const confirm = document.getElementById("confirm_password").value;
        if (newPass !== confirm) {
            alert("❌ Mật khẩu nhập lại không khớp.");
            e.preventDefault();
        }
    });

    // Toggle ẩn/hiện mật khẩu
    document.querySelectorAll(".toggle-password").forEach(function(toggle) {
        toggle.addEventListener("click", function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>