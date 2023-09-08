@extends('../layout/'.  config('view.menu-style'))

@section('title', 'KYC Documents')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.show', ['user' => $user->id]) }}">Agent</a></li>
    <li class="breadcrumb-item active" aria-current="page">KYC Level & Documents</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                KYC Level & Documents
            </h2>
        </div>
    </section>

    <section class="mt-5">
        <p class="py-2 my-2">
            <a href="{{ route('users.show', ['user' => $user->id]) }}"><strong>{{ $user->name }}</strong></a> |
            <a href="mailto:{{ $user->email }}" class="italic text-info hover:opacity-70">{{$user->email}}</a> |
            {{ $user->phone }}
        </p>
        <div class="grid md:grid-cols-3 grid-cols-4 gap-5">
            <div class="col-span-4 sm:col-span-2 md:col-span-1">
                <div class="box p-5 mb-2">
                    <form method="post" action="{{ route('users.update', $user->id) }}" class="my-form">
                        @csrf
                        @method('PUT')
                        <div class="form-inline mt-3">
                            <label for="bvn" class="form-label">BVN</label>
                            <div class="w-full">
                                <input id="bvn" type="text" class="form-control"
                                       placeholder="Agent's bank verification number"
                                       name="bvn" value="{{old('bvn') ?? $user->bvn }}"
                                >
                                <x-input-error input-name="bvn" />
                            </div>
                        </div>
                        {{--<div class="form-inline mt-6">
                            <label for="nin" class="form-label">NIN</label>
                            <div class="w-full">
                                <input id="nin" type="text" class="form-control"
                                       placeholder="Agent's National identification number"
                                       name="nin" value="{{ old('nin') ?? $user->nin }}"
                                >
                                <x-input-error input-name="nin" />
                            </div>
                        </div>--}}

                        <div class="flex justify-end mt-5 pt-4 border-t">
                            <button type="submit" class="btn btn-primary w-24">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="box p-5 mt-2">
                    <h5 class="font-semibold mb-3 flex items-center">
                        <i data-lucide="file-plus"></i>
                        <span class="ml-2">Upload New Document.</span>
                    </h5>
                    <form method="post" class="my-form" action="{{ route('users.kyc-docs.store', $user->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-3">
                            <label for="type" class="pr-2">Document Type</label>
                            <div class="w-full">
                                <select id="type" name="type" class="form-control form-select" required>
                                    <option disabled selected>-- Selected document type --</option>
                                    @foreach(\App\Enums\Documents::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->name() }}</option>
                                    @endforeach
                                </select>
                                <x-input-error input-name="type" />
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="name" class="form-label pr-2">Document Name</label>
                            <div class="w-full">
                                <input id="name" type="text" class="form-control"
                                       placeholder="Driver's license, voter's card, waste bill, etc."
                                       name="name" value="{{old('name')}}"
                                       required
                                >
                                <x-input-error input-name="name" />
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="file" class="form-label pr-2">File</label>
                            <div class="w-full">
                                <input type="file" id="file" name="file" class="dropify"
                                       data-allowed-file-extensions="pdf png jpg jpeg doc docx"
                                       data-max-file-size="5M" required
                                />
                            </div>
                        </div>

                        <div class="flex justify-end mt-3 pt-4 border-t">
                            <button type="submit" class="btn btn-primary w-24">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <section class="order-first sm:order-2 col-span-4 sm:col-span-2">
                <x-note>
                    <x-slot:message>
                        @php($levels = app('levels'))
                        <div>
                            <p class="pb-1">
                                There are {{ $levels->count() }} levels and to update to a higher level requires certain documents to be uploaded as stated below:
                            </p>
                            <ul>
                                @foreach($levels as $level)
                                    <li>
                                        {{ $level->name }} -
                                        <span @class(['text-slate-600', 'text-slate-400' => is_null($level->required_doc)])>
                                            {{ $level->required_doc ?? 'None' }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </x-slot:message>
                </x-note>

                <div class="box p-5 mt-2">
                    <p class="mb-3">
                        {{ $user->first_name }}'s current level - <span class="font-medium">{{ $user->kycLevel->name }}</span>
                    </p>
                    <form action="{{ route('users.manage-level.store', $user) }}" class="form-inline my-form" method="post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <div class="md:col-span-5 lg:form-inline">
                                <label for="level" class="form-label w-28">Change Level</label>
                                <div class="w-full">
                                    <select name="level_id" id="level" class="form-control form-select">
                                        @foreach(app('levels') as $level)
                                            <option value="{{ $level->id }}" @selected($level->id == $user->level_id)>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error input-name="level_id" />
                                </div>

                            </div>

                            <div class="md:col-span-1 flex justify-end mt-1 md:mt-0">
                                <button type="submit" class="btn btn-primary w-24 h-fit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-10 gap-5 mt-8">
                    <div class="col-span-10">
                        <h3 class="text-lg font-medium">Documents Uploaded</h3>
                    </div>
                    @forelse($user->kycDocs as $doc)
                        <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 2xl:col-span-2">
                            <div class="file box rounded-md pt-8 pb-5 px-3 sm:px-5 relative zoom-in">

                                <a href="{{ $doc->path }}" target="_blank" class="w-3/5 file__icon file__icon--file mx-auto">
                                    <div class="file__icon__file-name">{{ strtoupper($doc->ext) }}</div>
                                </a>

                                <a href="{{ $doc->path }}" target="_blank" class="block font-medium mt-4 text-center truncate">
                                    {{ $doc->name }}
                                </a>

                                @unless(!$doc->isVerified())
                                    <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-vertical"></i> </a>
                                        <div class="dropdown-menu w-44">
                                            <ul class="dropdown-content">
                                                @can('edit kyc-level')
                                                    <li>
                                                        <form action="{{ route('kyc-docs.update', $doc) }}" method="post" class="delete">
                                                            @csrf
                                                            @method('PUT')
                                                            <div href="" class="dropdown-item text-primary hover:opacity-70 cursor-pointer"
                                                                 onclick="this.closest('form').submit()"
                                                            >
                                                                <i data-lucide="check-square" class="w-3 h-3 mr-2"></i> Mark&nbsp;as&nbsp;verified
                                                            </div>
                                                        </form>
                                                    </li>
                                                @endcan
                                                <li>
                                                    <form action="{{ route('kyc-docs.destroy', $doc->id) }}" method="post" class="delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <span href="" class="dropdown-item text-danger hover:opacity-70  cursor-pointer"
                                                              onclick="this.closest('form').submit()"
                                                        >
                                                        <i data-lucide="trash" class="w-3 h-3 mr-2"></i> Delete
                                                    </span>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endunless
                            </div>
                        </div>
                    @empty
                        <div class="col-span-12 text-center mt-20 text-sm text-slate-500">No document has been uploaded yet!</div>
                    @endforelse
                </div>
            </section>
        </div>
    </section>

@endsection

