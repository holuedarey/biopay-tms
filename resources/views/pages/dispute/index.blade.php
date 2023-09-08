@extends('../layout/'.  config('view.menu-style'))

@section('title', "Audit Trail")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dispute</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
            <h2 class="text-lg font-medium">
                Dispute
            </h2>

        </div>
    </section>

    <section class="mt-8 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing all the disputes on TeqTMS</p>
        </div>
        <div >
            <div class="intro-y overflow-auto lg:overflow-visible">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th scope="col">User ID</th>

                        <th scope="col">Serial</th>

                        <th scope="col">Reference</th>

                        <th scope="col">info</th>

                        <th scope="col">Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($disputes->count() > 0)
                        @foreach ($disputes as $dispute)

                            <tr class="intro-x">
                                <td class="w-56">{{ $dispute->user_id }}</td>

                                <td class="w-56">{{ $dispute->serial }}</td>

                                <td class="w-56">{{ $dispute->reference }}</td>

                                <td class="w-56">{{ $dispute->info }}</td>

                                <td class="w-32">{{ $dispute->created_at }}</td>
                            </tr>
                        @endforeach

                    @else
                        <tr class="intro-x"><td colspan="10" class="text-center">No Record on Disputes</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
