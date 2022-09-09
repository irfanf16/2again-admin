<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Company Name</th>
        <th>Subscription Type</th>
        <th>Months</th>
        <th>Voucher Code</th>
        <th>Is Used</th>
    </tr>
    </thead>
    <tbody>
    @foreach($vouchers as $voucher)
        <tr>
            <td>{{$index++}}</td>
            <td>{{ $voucher->company->name }}</td>
            <td> @if($voucher->subscription_type=='vip') VIP @elseif($voucher->subscription_type=='bs' && $voucher->associate_product_credit==1) Big Spender - Associate @else Big Spender @endif</td>
            <td>{{ $voucher->subscription_month }}</td>
            <td>{{ $voucher->voucher_code }}</td>
            <td>@if($voucher->is_used==0) No @else Yes @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
