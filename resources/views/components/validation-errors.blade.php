@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="toastify-validation validation-msg" data-msg="{{ $error }}"></div>
    @endforeach
@endif
