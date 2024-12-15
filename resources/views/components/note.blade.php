@props(['message' => ''])
<div class="note-container mb-2 ">
    <div class="note-header d-flex align-items-center">
        <i class="fas fa-info-circle text-info me-2"></i>
        <strong class="text-muted">Note:</strong>
    </div>
    <p class="text-muted fss-12 mb-0">{!! $message ?? '' !!}</p>
</div>
