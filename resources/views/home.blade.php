@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Usuarios</div>
                    @php
                    use App\User;
                    $count = User::count();
                    @endphp
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-people f-left"></i><span> {{ $count }}</span></h2>
                        <p class="card-text"><a href="/users" class="text-white">Ver más</a></p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    </section>
@endsection

