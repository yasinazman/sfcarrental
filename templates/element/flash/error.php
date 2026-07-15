<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="toast-message toast-error" role="alert">
    <i class="fas fa-times-circle toast-icon"></i>
    <span class="toast-text"><?= $message ?></span>
    <i class="fas fa-times toast-close" onclick="this.closest('.toast-message').remove()"></i>
</div>