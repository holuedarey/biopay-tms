@extends('../layout/'.  config('view.menu-style'))

@section('title', 'KYC Level')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">KYC Documents</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
            <h2 class="text-lg font-medium">
                KYC Documents
            </h2>

{{--            <a class="btn btn-primary sm:mt-0 mt-5 text-left">Add New Document</a>--}}
        </div>
    </section>

    <section class="mt-8 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing list of Recent KYC Documents</p>
        </div>
        <div >
            <div class="intro-y overflow-auto mt-8 sm:mt-0">
                <table class="table table-report table-auto table-hover sm:mt-2">
                    <thead>
                    <tr class="bg-gray-200">
                        <th scope="col">Agent's Name</th>

                        <th scope="col">Document Name</th>

                        <th scope="col">Document</th>

                        <th scope="col">Verified At</th>

                        <th scope="col">Date Created</th>
                    </tr>
                    </thead>

                    <tbody>
                     @forelse($kyc_docs as $doc)
                        <tr class="intro-x">
                            <td class="w-56">
                                <a href="{{ route('users.show', $doc->agent) }}">
                                    <span class="text-primary">{{ $doc->agent->name }}</span>
                                    <br>
                                    <span class="small text-gray-400"> {{ $doc->agent->email }}</span>
                                </a>
                            </td>

                            <td class="w-56">{{ $doc->name }}</td>

                            <td class="w-56 file ">
                                <a href="{{ $doc->path }}" target="_blank" class="w-1/4 file__icon file__icon--file">
                                    <div class="file__icon__file-name">{{ strtoupper($doc->ext) }}</div>
                                </a>
                            </td>

                            <td class="whitespace-nowrap">
                                @if($doc->isVerified())
                                    <span class="text-success">{{ $doc->verified_at->toDayDateTimeString()}}</span>
                                @else
                                    @can('edit kyc-level')
                                        <form action="{{ route('kyc-docs.update', $doc) }}" method="post" class="my-form">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="form-check form-switch tooltip w-fit flex items-center spinner-dark" title="Mark as verified">
                                                <input id="checkbox-switch-7" class="form-check-input" type="checkbox"
                                                       onchange="this.closest('form').submit()">
                                            </button>
                                        </form>
                                    @else
                                        ...
                                    @endcan
                                @endif
                            </td>

                            <td class="whitespace-nowrap">{{ $doc->created_at->toDayDateTimeString()}}</td>
                        </tr>
                     @empty
                         <tr class="intro-x"><td colspan="4" class="text-center">No Kyc document has been added yet</td></tr>
                     @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
