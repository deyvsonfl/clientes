<style>
    #flash-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 320px;
    }

    .flash-alert {
        animation: slideInRight 0.5s ease;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .slide-out {
        animation: slideOutRight 0.5s ease forwards;
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

<div id="flash-container">
    <?php foreach (['success', 'error', 'errors'] as $type): ?>
        <?php
            $flash = session()->getFlashdata($type);
            $messages = is_array($flash) ? $flash : ($flash ? [$flash] : []);
            $class = match ($type) {
                'success' => 'alert-success',
                'error' => 'alert-danger',
                'errors' => 'alert-warning',
                default => 'alert-info'
            };
            $icon = match ($type) {
                'success' => 'bi-check-circle-fill',
                'error' => 'bi-exclamation-triangle-fill',
                'errors' => 'bi-exclamation-circle-fill',
                default => 'bi-info-circle-fill'
            };
        ?>
        <?php foreach ($messages as $msg): ?>
            <div class="alert <?= $class ?> alert-dismissible fade show d-flex align-items-center shadow-sm mb-3 flash-alert" role="alert">
                <i class="bi <?= $icon ?> me-2"></i>
                <?= is_array($msg) ? implode('<br>', array_map('esc', $msg)) : esc($msg) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<script>
    // Auto animação de saída após 5s
    setTimeout(() => {
        document.querySelectorAll('.flash-alert').forEach(alert => {
            alert.classList.add('slide-out');
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 500); // espera a animação de saída terminar
        });
    }, 5000);
</script>
