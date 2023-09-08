<!-- BEGIN: Notification Content -->

@if(session()->has('status') || session()->has('message'))
    <div id="info-notification-content" class="toastify-content hidden flex bg-info/20">
        <div class="mt-1">
            <i class="text-info" data-lucide="alert-circle"></i>
        </div>
        <div class="ml-4 mr-4">
            <div class="font-bold text-lg text-info">Message!</div>
            <div class="text-slate-500 mt-1">{{ session('message') ?? session('status') }}</div>
        </div>
    </div>
@endif

@if(session()->has('pending'))
    <div id="pending-notification-content" class="toastify-content hidden flex bg-warning/20">
        <div class="mt-1">
            <i class="text-pending" data-lucide="alert-circle"></i>
        </div>
        <div class="ml-4 mr-4">
            <div class="font-bold text-lg text-pending">Awaiting Approval!</div>
            <div class="text-slate-500 mt-1">{{ session('pending') }}</div>
        </div>
    </div>
@endif

@if(session()->has('success'))
    <div id="success-notification-content" class="toastify-content hidden flex bg-success/20">
        <div class="mt-1">
            <i class="text-success" data-lucide="check-circle"></i>
        </div>
        <div class="ml-4 mr-4">
            <div class="font-bold text-lg text-success">Success!</div>
            <div class="text-slate-500 mt-1 message">{{ session('success') }}</div>
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div id="error-notification-content" class="toastify-content hidden flex bg-danger/20">
        <div class="mt-1">
            <i class="text-danger" data-lucide="alert-triangle"></i>
        </div>
        <div class="ml-4 mr-4">
            <div class="font-bold text-lg text-danger">Error!</div>
            <div class="text-slate-500 mt-1">{{ session('error') }}</div>
        </div>
    </div>
@endif
