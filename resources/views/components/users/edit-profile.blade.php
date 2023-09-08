<div id="edit-profile" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--            <form method="post" action="">--}}
            <form method="post" class="my-form" action="{{ route('users.update', $user) }}">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Edit Profile Information
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="first_name" class="form-label sm:w-24">First Name</label>
                        <div class="w-full">
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                            <x-input-error input-name="first_name" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="other_names" class="form-label sm:w-24">Other Names</label>
                        <div class="w-full">
                            <input id="other_names" type="text" class="form-control" name="other_names" value="{{ $user->other_names }}">
                            <x-input-error input-name="other_names" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="email" class="form-label sm:w-24">Email Address</label>
                        <div class="w-full">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">
                            <x-input-error input-name="email" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="phone" class="form-label sm:w-24">Phone</label>
                        <div class="w-full">
                            <input id="phone" type="tel" class="form-control" name="phone" value="{{ $user->phone }}">
                            <x-input-error input-name="phone" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="gender" class="form-label sm:w-24">Gender</label>
                        <div class="w-full">
                            <select id="gender" class="form-select" name="gender">
                                <option value="" disabled selected></option>
                                <option value="MALE" @selected(old('gender', $user->gender) == 'MALE')>Male</option>
                                <option value="FEMALE" @selected(old('gender', $user->gender) == 'FEMAIL')>Female</option>
                            </select>
                            <x-input-error input-name="gender" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="dob" class="form-label sm:w-24">DOB</label>
                        <div class="w-full">
                            <input id="dob" type="date" max="{{ now()->subYears(18)->toDateString() }}" class="form-control" name="dob"
                                   value="{{ $user->dob }}"
                            >
                            <x-input-error input-name="dob" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="state" class="form-label sm:w-24">States</label>
                        <div class="w-full">
                            <select id="state" class="form-select" name="state">
                                <option value="" disabled selected>-- Select state of residence --</option>
                                @foreach(config('states') as $state)
                                    <option value="{{ $state }}" @selected(old('state', $user->state) == $state)>{{ $state }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="state" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="address" class="form-label sm:w-24">Address</label>
                        <div class="w-full">
                            <input id="address" type="text" class="form-control" name="address" value="{{ $user->address }}">
                            <x-input-error input-name="address" />
                        </div>
                    </div>

                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">
                    <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary px-5 w-fit">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 w-fit">Save</button>
                </div>
                <!-- END: Slide Over Footer -->

            </form>
        </div>
    </div>
</div>
