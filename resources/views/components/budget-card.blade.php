<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="text-muted mb-1 small fw-medium">{{ $title }}</p>
                <p class="h5 fw-semibold mb-0">{{ $value }}</p>
            </div>
            <div class="round-8 text-bg-{{ $color }} rounded-circle me-6">
                <i class="{{ $icon }}"></i>
            </div>
        </div>
    </div>
</div>
