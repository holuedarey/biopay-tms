@extends('../layout/'.  config('view.menu-style'))

@section('title', 'KYC Document')

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
        </div>
    </section>

    <section class="mt-8 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing list of all KYC Documents Uploaded by {{$user->name}}</p>
        </div>
        <div >
            <div class="intro-y overflow-auto lg:overflow-visible">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th scope="col">#</th>

                        <th scope="col">Name Of Doc</th>

                        <th class="text-center whitespace-nowrap">
                            <span class="flex justify-center">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                            </span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($kyc_docs->count() > 0)
                        @foreach ($kyc_docs as $docs)

                            <tr class="intro-x">
                                <td class="w-56">{{ $docs->id }}</td>

                                <td class="w-56">{{ $docs->name }}</td>

{{--                                <td class=""><span class="text-info">@money($level->daily_limit)</span></td>--}}

{{--                                <td class=""><span class="text-pending">@money($level->single_trans_max)</span></td>--}}

{{--                                <td class=""><span class="text-dark">@money($level->max_balance)</span></td>--}}

                                <td class="table-report__action w-48">
                                    <div class="flex justify-around items-center">
                                        <a href="" class="flex items-center text-blue-600">
                                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr class="intro-x"><td colspan="10" class="text-center">No Terminal has been added yet</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
