@extends('../layout/'.  config('view.menu-style'))

@section('title', "Audit Trail")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Audit Trail</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
            <h2 class="text-lg font-medium">
                Audit Trail
            </h2>

        </div>
    </section>

    <section class="mt-8 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing all the activities on TeqTMS</p>
        </div>
        <div >
            <div class="intro-y overflow-auto lg:overflow-visible">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th scope="col">Subject</th>

                        <th scope="col">Role</th>

                        <th scope="col">Action</th>

                        <th scope="col">Causer</th>

                        <th scope="col">Date</th>

                        <th class="text-center whitespace-nowrap">
                            Details
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($activities->count() > 0)
                        @foreach ($activities as $activity)

                            <tr class="intro-x">
                                <td class="w-56">{{ $activity->log_name }}</td>

                                <td class="w-56">{{ $activity->causer?->role_name }}</td>

                                <td class="w-56">{{ $activity->description }}</td>

                                <td class="w-56">{{ $activity->causer?->email }}</td>

                                <td class="w-96">{{ $activity->created_at->format('d/m/Y G:i') }}</td>

                                <td class="text-center whitespace-nowrap">
                                    <a href="{{ route('activities.show', [$activity->id]) }}">
                                        <span class="flex justify-center">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr class="intro-x"><td colspan="10" class="text-center">No Activity has occurred</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="m-3">
                {{$activities->links()}}
            </div>
        </div>
    </section>
@endsection
