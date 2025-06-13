<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-4 bg-light rounded-4 shadow p-4 border">
        <h3 class="text-center text-primary mb-4">
            <i class="bi bi-diagram-3 me-2"></i>So sánh xe
        </h3>

        <!-- Select so sánh -->
        <div class="row mb-3">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Xe <?= $i ?>:</label>
                    <select class="form-select compare-select" data-index="<?= $i ?>">
                        <option value="">-- Chọn xe <?= $i ?> --</option>
                        <?php foreach ($cars as $car): ?>
                            <?php
                            $selected = ($i === 1 && isset($_POST['car_id']) && $_POST['car_id'] == $car['id']) ? 'selected' : '';
                            ?>
                            <option value="<?= $car['id'] ?>" <?= $selected ?>><?= htmlspecialchars($car['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Kết quả so sánh -->
        <div id="compare-result"></div>

        <!-- Nút quay lại -->
        <div class="text-center mt-4">
            <a href="/home" class="btn btn-primary">
                <i class="fa fa-home me-1"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    const selects = document.querySelectorAll('.compare-select');

    function fetchCompare() {
        const carIds = Array.from(selects).map(sel => sel.value).filter(v => v !== "");
        const uniqueIds = [...new Set(carIds)];

        const result = document.getElementById('compare-result');

        // Kiểm tra trùng
        if (uniqueIds.length < carIds.length) {
            result.innerHTML = `<div class="alert alert-danger text-center">🚫 Không được chọn trùng xe.</div>`;
            return;
        }

        // Cần ít nhất 2 xe để so sánh
        if (carIds.length >= 2) {
            result.innerHTML = `<div class="text-center my-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>`;
            fetch('/compareCars', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ car_ids: carIds })
            })
            .then(res => res.text())
            .then(html => {
                result.innerHTML = html;
            });
        } else {
            result.innerHTML = `<div class="alert alert-warning text-center">⚠️ Vui lòng chọn ít nhất 2 xe để so sánh.</div>`;
        }
    }

    selects.forEach(sel => sel.addEventListener('change', fetchCompare));

    if (selects.length > 0 && selects[0].value !== "") {
        fetchCompare();
    }
</script>
