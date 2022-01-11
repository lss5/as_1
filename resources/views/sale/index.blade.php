@extends('backend.layouts.app')

@section('content')
    <div class="container">
        @if (session('success_create'))
        <div class="alert alert-success" role="alert">
            <a href="{{ session('success_create') }}">Запись</a> о продаже добавлена
        </div>
        @endif
        <div class="row">
            {{-- head 1/3 --}}
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-6">
                        <h1>Продажи</h1>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.sale.create') }}" class="btn btn-success" role="button">Добавить</a>
                    </div>
                </div>
            </div>
            {{-- head 1/3 --}}
            {{-- filter 2/3 --}}
            <div class="col-12 col-md-8">
                {!! Form::open(array('route' => 'admin.sale.index', 'method' => 'get')) !!}
                <div class="row">
                    <div class="col-12 col-md-3 text-center text-md-right">
                        {{ Form::label('date_start', 'С', ['class' => 'mt-1']) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-left">
                        {{ Form::date('date_start', request()->get('date_start'), ['class' => 'form-control']) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-right">
                        {{ Form::label('date_end', 'По', ['class' => 'mt-1']) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-left">
                        {{ Form::date('date_end', request()->get('date_end'), ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 col-md-3 text-center text-md-right">
                        {{ Form::label('status', 'Статус', ['class' => 'mt-2']) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-left">
                        {{ Form::select(
                            'status',
                            \App\Sale::$statusDom,
                            request()->get('status'),
                            ['class' => 'form-control', 'placeholder' => 'Выберите...']
                        ) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-right">
                        {{ Form::label('user', 'Пользователь', ['class' => 'mt-2']) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-left">
                        {{ Form::select(
                            'user',
                            \App\User::pluck('name', 'id')->toArray(),
                            request()->get('user'),
                            ['class' => 'form-control', 'placeholder' => 'Выберите...']
                        ) }}
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 col-md-3 text-center text-md-right">
                        {{ Form::label('account', 'Аккаунт', ['class' => 'mt-2']) }}
                    </div>
                    <div class="col-12 col-md-3 text-center text-md-left">
                        {{ Form::select('account',
                                        \App\Account::pluck('title', 'id')->toArray(),
                                        request()->get('account'),
                                        ['class' => 'form-control', 'multiple' => 'multiple', 'name' => 'account[]']
                        ) }}
                    </div>
                    <div class="offset-0 offset-md-3 col-12 col-md-3 text-center text-md-right">
                        {{ Form::button('Применить', ['class' => 'btn btn-primary float-right', 'type' => 'submit']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            {{-- filter 2/3 --}}
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h4>Доходы</h4>
                <div class="row text-muted">
                    <div class="col-4">
                        <span class="text-dark">{{ $sales->sum('quantity') }}</span> шт. на
                        <span class="text-success"> {{ $sales->sum('price') }}</span> $
                    </div>
                    <div class="col-4">Прибыль: <span class="text-success">{{ $sales->sum('profit') }}</span> R</div>
                    <div class="col-4">PayPal: <span class="text-dark">{{ $sales->sum('paypal_out') }}</span> R</div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h4>Расходы</h4>
                <div class="row text-muted">
                    <div class="col-4">Товары: <span class="text-danger">{{ $sales->sum('price_products') }}</span> R</div>
                    <div class="col-4">Доставка: <span class="text-danger">{{ $sales->sum('ship_fee') }}</span> R</div>
                    <div class="col-4">Комиссии: <span class="text-dark">{{ $sales->sum('costs_fee') }}</span> $</div>
                </div>
            </div>
        </div>
        <hr class="d-none d-md-block my-1">
    </div>
    <div class="container mt-2">
        <div class="row">
            <div class="col-6 col-md-1 col-lg-1 mb-2 mb-md-0">
                <div class="text-center d-none d-md-block">Дата</div>
            </div>
            <div class="col-6 col-md-1 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">User</div>
            </div>
            <div class="col-6 col-md-2 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Трек-номер</div>
            </div>
            <div class="col-6 col-md-1 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Действия</div>
            </div>
            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Товар</div>
            </div>
            <div class="col-6 col-md-1 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Цена</div>
            </div>
            <div class="col-4 col-md-1 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Расходы</div>
            </div>

            <div class="col-4 col-md-1 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Прибыль</div>
            </div>
            <div class="col-4 col-md-1 mb-2 mb-md-0">
                <div class="text-center w-100 d-none d-md-block">Вывод</div>
            </div>
        </div>
        @forelse ($sales as $sale)
            <hr class="my-1">
            <div class="row">
                <div class="col-4 col-md-1 col-lg-1 mb-2 mb-md-0">
                    <div class="text-center d-block d-md-none"><small>Дата</small></div>
                    <div class="text-center @if (date('N', strtotime($sale->date_sale)) > 5) text-danger @endif">
                        {{ date('d M', strtotime($sale->date_sale)) }}
                    </div>
                </div>

                <div class="col-4 col-md-1 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>User</small></div>
                    <div class="text-center w-100 {{ $sale->status }}">{{ $sale->user->name }}</div>
                </div>

                <div class="col-4 col-md-2 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Трек-номер</small></div>
                    <div class="text-center w-100">
                        @if (!empty($sale->track_number))
                            <a href="https://www.pochta.ru/tracking#{{ $sale->track_number }}" target="_blank">{{ $sale->track_number }}</a>
                            {{-- <a href="https://www.pochta.ru/portal-pdf-form/api/v2/mail.generate-blanks?track-number={{ $sale->track_number }}" target="_blank"><i class="fa fa-print"></i></a> --}}
                        @endif
                    </div>
                </div>

                <div class="col-3 col-md-1 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Действия</small></div>
                    <div class="text-center w-100">
                        @if ($sale->status == 'paid')
                            <a href="{{ route('admin.sale.workflow', ['action' => 'sent', 'sale' => $sale]) }}" onclick='confirm("Отметить как отправленный ?")' class="btn btn-primary btn-sm" title="Отметить как отправленный">
                                <i class="fa fa-paper-plane"></i>
                            </a>
                        @endif
                        @if ($sale->status == 'sent')
                            <a href="{{ route('admin.sale.workflow', ['action' => 'delivered', 'sale' => $sale]) }}" onclick='confirm("Отметить как полученный ?")' class="btn btn-secondary btn-sm" title="Отметить как полученный">
                                <i class="fa fa-user-check"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-9 col-md-3 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Товар</small></div>
                    <div class="text-center w-100">
                        <a href="{{ route('admin.sale.show', $sale) }}" class="text-bolder">{{ $sale->stock->product->title}}</a> | {{ $sale->quantity }}шт
                    </div>
                </div>

                <div class="col-3 col-md-1 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Цена</small></div>
                    <div class="text-center w-100">{{ $sale->price }} $</div>
                </div>

                <div class="col-3 col-md-1 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Расходы</small></div>
                    <div class="text-center w-100 text-danger">{{ $sale->price_products + $sale->ship_fee }} R</div>
                </div>

                <div class="col-3 col-md-1 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Прибыль</small></div>
                    <div class="text-center w-100" style="color: #00b34c;">{{ $sale->profit }} R</div>
                </div>

                <div class="col-3 col-md-1 mb-2 mb-md-0">
                    <div class="text-center w-100 d-block d-md-none"><small>Вывод</small></div>
                    <div class="text-center w-100">{{ $sale->paypal_out }} R</div>
                </div>
            </div>
        @endforeach
    </div>
@endsection