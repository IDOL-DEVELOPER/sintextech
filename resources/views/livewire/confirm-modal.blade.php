<div class="position-relativ" style="z-index: 10000000">
    @if ($showModal)
        <form action="{{ route($route ?? '') }}" method="POST">
            @csrf
            <div class="modal fade d-block show" wire:ignore.self id="see" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog card-rounded p-0">
                    <div class="border-none modal-content card-rounded p-0 m-0 modal-sm">
                        <div class="modal-body bg-csub card-rounded">
                            <input type="hidden" name="action" value="{{ $action ?? '' }}">
                            <input type="hidden" name="id" value="{{ $id ?? '' }}">
                          <span class="note text-danger font-bold">  {{ $message }}</span>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="submit" class="btn btn-primary btn-rounded">Confirm</button>
                            <button type="button" class="btn btn-secondary btn-rounded" aria-label="Close"
                                wire:click="cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-backdrop fade show "></div>
    @endif
</div>
