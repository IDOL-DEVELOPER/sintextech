<div class="">
    <div
        class="{{ $title ? 'w-max-content border-start border-top border-light border-1 border-light border-end p-2 px-5 bg-light card-rounded rounded-bottom-right-0 rounded-bottom-left-0  border-bottom-0' : 'd-none' }}">
        <span class="text-dark fs-14">{!! $title ?? '' !!}</span>
    </div>
    <div
        class="content-body p-2 card-rounded bg-csub shadow  overflow-hidden border border-light border-1{{ $title ? ' rounded-top-left-0 ':'' }}">
        {{ $slot }}
    </div>
</div>
