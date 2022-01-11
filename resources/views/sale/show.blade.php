@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h1> Продажа #{{ $sale->id }} </h1>
        <div class="form-inline">
            <a href="{{ route('admin.sale.create') }}" class="btn btn-success mx-1" role="button">
                <i class="fas fa-plus"></i>
            </a>
            <a href="{{ route('admin.sale.edit', $sale) }}" class="btn btn-primary mx-1" role="button">
                <i class="fas fa-pen"></i>
            </a>
            {{ Form::open(['route' => ['admin.sale.destroy', $sale], 'method' => 'delete']) }}
            {{ Form::button('<i class="fas fa-trash"></i>', [
                'type' => 'submit',
                'class' => 'btn btn-danger mx-1',
                'onclick'=>'return confirm("Удалить ?")',
            ]) }}
            {{ Form::close() }}
            <a class="btn btn-light ml-2" href="{{ route('admin.sale.index') }}">
                <i class="fas fa-list"></i>
            </a>
        </div>
    </div>
    
    <div class="container mt-3">
        <table class="table table-sm table-striped">
            <tbody>
                <tr valign="center">
                    <th scope="col" class="text-right" width="30%">Поступление</th>
                    <td class="text-left"><a href="{{ route('admin.stock.show', $sale->stock) }}">{{ $sale->stock->product->title}}</a></td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Количество</th>
                    <td class="text-left">{{ $sale->quantity }} шт.</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Цена продажи</th>
                    <td class="text-left text-success"><b>{{ $sale->price }} $</b></td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Дата продажи</th>
                    <td class="text-left">{{ date('d M Y', strtotime($sale->date_sale)) }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Дата отправки</th>
                    <td class="text-left">
                        @if (empty($sale->date_sent))
                            <span class="text-danger">Не заполнено</span>
                        @else
                            {{ date('d M Y', strtotime($sale->date_sent)) }}
                        @endif
                    </td>
                </tr>
                <tr valign="center">
                    <th scope="col" class="text-right" width="30%">Статус</th>
                    <td class="text-left">{{ \App\Sale::$statusDom[$sale->status] }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Трек-номер</th>
                    <td class="text-left">
                        @if (!empty($sale->track_number))
                            <a href="https://www.pochta.ru/tracking#{{ $sale->track_number }}" target="_blank">{{ $sale->track_number }}</a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-sm table-striped">
            <thead class="thead-light">
                <tr>
                    <th colspan="2" class="text-center">Комиссии</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col" class="text-right" width="30%">PayPal</th>
                    <td class="text-left">{{ $sale->paypal_fee }} $</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Market</th>
                    <td class="text-left">{{ $sale->ebay_fee }} $</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Реклама</th>
                    <td class="text-left">{{ $sale->ad_fee }} $</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Всего</th>
                    <td class="text-left text-danger"><b> {{ $sale->paypal_fee + $sale->ebay_fee + $sale->ad_fee }} $</b></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-sm table-striped">
            <thead class="thead-light">
                <tr>
                    <th colspan="2" class="text-center">Расходы</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col" class="text-right" width="30%">Почтовые расходы</th>
                    <td class="text-left">{{ $sale->ship_fee }} R</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Стоимость товара</th>
                    <td class="text-left">{{ $sale->stock->price * $sale->quantity }} R</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Всего расходы</th>
                    <td class="text-left text-danger"><b>{{ ($sale->stock->price * $sale->quantity) + $sale->ship_fee }} R</b></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-sm table-striped">
            <thead class="thead-light">
                <tr>
                    <th colspan="2" class="text-center">Доход</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col" class="text-right" width="30%">Выручка</th>
                    <td class="text-left text-success"><b>{{ $sale->price - $sale->paypal_fee - $sale->ebay_fee - $sale->ad_fee }} $</b></td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Курс</th>
                    <td class="text-left text-muted">{{ $sale->rub_usd }} R</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Вывод</th>
                    <td class="text-left">{{ round(($sale->price - $sale->paypal_fee - $sale->ebay_fee - $sale->ad_fee) * $sale->rub_usd) }} R</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Прибыль</th>
                    <td class="text-left text-success"><b>{{ round(($sale->price - $sale->paypal_fee - $sale->ebay_fee - $sale->ad_fee) * $sale->rub_usd - (($sale->stock->price * $sale->quantity) + $sale->ship_fee)) }} R</b></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-sm table-striped">
            <thead class="thead-light">
                <tr>
                    <th colspan="2" class="text-center">Дополнительно</th>
                </tr>
            </thead>
            <tbody>
                <tr valign="center">
                    <th scope="col" class="text-right" width="30%">Пользователь</th>
                    <td class="text-left">{{ $sale->user->name }}</td>
                </tr>
                <tr valign="center">
                    <th scope="col" class="text-right" width="30%">Аккаунт</th>
                    <td class="text-left">{{ $sale->account->title }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Дата добавления</th>
                    <td class="text-left">{{ date('d M Y', strtotime($sale->created_at)) }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Последнее изменение</th>
                    <td class="text-left">{{ date('d M Y', strtotime($sale->updated_at)) }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Номер заказа eBay</th>
                    <td class="text-left">{{ $sale->ebay_order_number }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection