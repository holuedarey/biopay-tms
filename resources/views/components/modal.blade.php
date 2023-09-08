@props(['modalId', 'modalTitle', 'isLarge' => true])

<!-- BEGIN: Modal Content -->
<div id="{{ $modalId }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-{{ $isLarge ? 'xl' : 'lg'}}">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">{{ $modalTitle }}</h2>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                {{ $slot }}
            </div> <!-- END: Modal Body -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
