@extends('../layout/'.  config('view.menu-style'))

@section('title', "Audit Trail")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{url()->previous()}}">Audit Trail</a></li>
    <li class="breadcrumb-item active" aria-current="page">Single Trail</li>
@endsection

@section('subcontent')

    <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
        <h5>Activity Log - <span class="f-w-100 f-20"><em>For {{ ucfirst($activity->log_name) }}</em></span></h5>
        <button class="btn btn-primary w-24"><a href="{{ url()->previous() }}">Go back</a></button>
    </div>

    <section>
        <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
            <h2 class="text-lg font-medium">
                Single Trail
            </h2>
        </div>
    </section>

    <section class="mt-8 bg-white px-5 py-3">

        <div >
            <div class="intro-y overflow-auto lg:overflow-visible">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th scope="col">Subject</th>

                        <th scope="col">Role</th>

                        <th scope="col">Action</th>

                        <th scope="col">Causer</th>

                        <th scope="col">Properties</th>

                        @if(isset($old))
                            <th scope="col" class="text-center">Previous Values</th>
                            <th scope="col" class="text-center">Current Values</th>
                        @else
                            <th scope="col" class="text-center">Values</th>
                        @endif

                        <th scope="col">Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr class="intro-x">
                        <td class="w-56">{{ $activity->log_name }}</td>

                        <td class="w-56">{{ $activity->causer?->role_name }}</td>

                        <td class="w-56">{{ $activity->description }}</td>

                        <td class="w-56">{{ $activity->causer?->email }}</td>

                        <td class="w-56 pl-3">
                            @foreach(array_keys($current) as $key)
                                {{ ucwords($key)}}: <br>
                            @endforeach
                        </td>



                        @if(isset($old))
                            <td class="w-56 text-center">
                                @switch($activity->log_name)
                                    @case('User')
                                    {{$old['name'] ?? '---'}} <br />
                                    {{$old['email'] ?? '---'}} <br />
                                    @break

                                    @case('GL')
                                    {{'N'.$old['balance'] ?? '---'}} <br />
                                    @break

                                    @case('Fee')
                                    {{$old['title'] ?? '---'}} <br />
                                    @break

                                    @case('Wallet')
                                    {{$old['account_number'] ?? '---'}} <br />
                                    {{$old['status'] ?? '---'}} <br />
                                    @break

                                    @case('KycLevel')
                                    {{$old['name'] ?? '---'}} <br />
                                    {{$old['daily_limit'] ?? '---'}} <br />
                                    @break

                                    @default
                                    {{$old['name'] ?? '---'}} <br />
                                    {{$old['description'] ?? '---'}} <br />
                                    @foreach($old as $val)
                                        @if(is_array($val))
                                            {{$val['name'] ?? '---'}}
                                        @endif
                                    @endforeach
                                    @break
                                @endswitch
                            </td>
                        @endif

                        <td class="w-96 text-center">
                            @switch($activity->log_name)
                                @case('User')
                                {{$current['name'] ?? '---'}} <br />
                                {{$current['email'] ?? '---'}} <br />
                                @break

                                @case('GL')
                                {{'N'.$current['balance'] ?? '---'}} <br />
                                @break

                                @case('Fee')
                                {{$current['title'] ?? '---'}} <br />
                                @break

                                @case('Wallet')
                                {{$current['account_number'] ?? '---'}} <br />
                                {{$current['status'] ?? '---'}} <br />
                                @break

                                @case('KycLevel')
                                {{$current['name'] ?? '---'}} <br />
                                {{$current['daily_limit'] ?? '---'}} <br />
                                @break

                                @default
                                {{$current['name'] ?? '---'}} <br />
                                {{$current['description'] ?? '---'}} <br />
                                @foreach($current as $val)
                                    @if(is_array($val))
                                        {{$val['name'] ?? '---'}}
                                    @endif
                                @endforeach
                                @break
                            @endswitch
                        </td>

                        <td class="w-96">{{ $activity->created_at->format('d/m/Y G:i') }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
