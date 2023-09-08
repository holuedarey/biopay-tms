@props(['inputName'])
@error($inputName)
    <div id="error-password" class="login__input-error text-danger mt-2">{{ $message }}</div>
@enderror
