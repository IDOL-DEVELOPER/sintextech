@props(['message' => '', 'position' => ''])
<span class="question-tooltip position-relative">
    <span class="question-icon">?</span>
    <span class="tooltip-content text-muted" data-position="{{ $position }}">{!! $message !!}</span>
</span>
