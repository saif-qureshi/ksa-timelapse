<!-- BEGIN: Success Notification Content -->
<div
    id="success-notification-content"
    class="toastify-content hidden flex"
>
    <i class="text-success" data-lucide="check-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium capitalize">Registration success!</div>
        <div class="text-slate-500 mt-1">
            Please check your e-mail for further info!
        </div>
    </div>
</div>
<!-- END: Success Notification Content -->
<!-- BEGIN: Failed Notification Content -->
<div
    id="failed-notification-content"
    class="toastify-content hidden flex"
>
    <i class="text-danger" data-lucide="x-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium capitalize">Registration failed!</div>
        <div class="text-slate-500 mt-1">
            Please check the fileld form.
        </div>
    </div>
</div>
<!-- END: Failed Notification Content -->

<script>
    @if(Session::has('message'))
    @php
        [$type, $message] = explode('|', Session::get('message'));
    @endphp
    window.addEventListener('load', function () {
        toaster('{{ $type }}', '{{ $message }}')
    })
    @endif
</script>
