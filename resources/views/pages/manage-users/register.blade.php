@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Register Admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    @if(str_contains($title, 'Admin'))
        <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Registration</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">Onboarding</li>
    @endif
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $title }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5"
         x-data="{role: '{{ old('role', '') }}', super_agent: '{{ old('super_agent_id', '') }}'}"
         x-init="$watch('role', (value) => super_agent = null)"
    >
        <div class="intro-y col-span-12 lg:col-span-11 xl:col-span-10">
            <!-- BEGIN: Form Layout -->
            <form class="intro-y box p-5 my-form" method="post" action="{{ route('users.store') }}">
                @csrf
                <div>
                    <label class="form-label">Name</label>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-6">
                            <input type="text" class="form-control" placeholder="First Name" aria-label="admin first name"
                                   name="first_name" value="{{ old('first_name') }}" required
                            />
                            <x-input-error input-name="first_name" />
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <input type="text" class="form-control" placeholder="Other Names (Surname first)" aria-label="admin first name"
                                   name="other_names" value="{{ old('other_names') }}" required
                            />
                            <x-input-error input-name="other_names" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4 mt-6">
                    <div class="col-span-12 md:col-span-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="example@test.com" aria-label="admin's email address"
                               name="email" value="{{ old('email') }}"
                        />
                        <x-input-error input-name="email" />
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label class="form-label" for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="08123456789" aria-label="admin's phone number"
                               name="phone" value="{{ old('phone') }}"
                        />
                        <x-input-error input-name="phone" />
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label class="form-label" id="state">State</label>
                        <select class="form-control" id="state" name="state" >
                            <option disabled selected>-- Select State of Residence --</option>
                            @foreach(config('states') as $state)
                                <option value="{{ $state }}" @selected(old('state') == $state)>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error input-name="state" />
                    </div>
                </div>
                <div class="mt-6">
                    <label class="form-label" id="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Enter admin's street address" aria-label="admin's street address"
                           name="address" value="{{ old('address') }}"
                    />
                    <x-input-error input-name="address" />
                </div>
                <div class="grid grid-cols-12 gap-4 mt-6">
                    <div class="col-span-12 md:col-span-4">
                        <label class="form-label" id="type">Role</label>
                        <select class="form-select" aria-label="Select admin Type" name="role" x-model="role" id="type">
                            <option selected> --- Select Role ---</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <x-input-error input-name="role" />
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" aria-label="Select admin Gender" name="gender">
                            <option disabled selected> --- Select Gender ---</option>
                            <option value="MALE" @if(old('gender') == 'MALE') selected @endif>Male</option>
                            <option value="FEMALE" @if(old('gender') == 'FEMALE') selected @endif>Female</option>
                        </select>
                        <x-input-error input-name="gender" />
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <label for="dob" class="form-label">Date of Birth</label>

                        <div class="relative mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div>
                            <input id="dob" type="text" class="datepicker form-control pl-12" data-single-mode="true" aria-label="Enter admin's Date of Birth"
                                   name="dob" value="{{ old('dob') ?? ' ' }}" placeholder="dd/mm/yyyy"
                            />
                        </div>
                        <x-input-error input-name="dob" />
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4 mt-6">
                    <div class="col-span-12 md:col-span-4">
                        <div x-show="role === '{{ \App\Models\Role::AGENT }}'" x-transition>
                            <label class="form-label">{{ \App\Models\Role::SUPERAGENT }} (optional)</label>
                            <select data-placeholder="Select {{ \App\Models\Role::SUPERAGENT }}" class="tom-select w-full"
                                    name="super_agent_id" x-model="super_agent"
                            >
                                <option value=""></option>
                                @foreach($super_agents as $super_agent)
                                    <option value="{{ $super_agent->id }}">{{ $super_agent->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="super_agent_id" />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-10 pt-6 border-t">
                    <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Reset</button>
                    <button type="submit" class="btn btn-primary w-24">Register</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection
