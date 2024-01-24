<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kết quả thanh toán Alepay</title>
</head>
<body>
    <h1>KẾT QUẢ THANH TOÁN ALEPAY</h1>

    <h4>THANH TOÁN THÀNH CÔNG</h4>
    <p>Mã giao dịch: {{$callbackData['transactionCode']}}</p>
    <br><hr><br>
    <h2>THÔNG TIN ĐƠN HÀNG</h2>
    <p>Mã đơn hàng: {{$callbackData['orderCode']}}</p>
    <p>Tổng số tiền thanh toán: {{ number_format($callbackData['amount']) }} {{ $callbackData['currency'] }}</p>
    <p>Người mua: {{$callbackData['buyerName']}}</p>
    <p>Email người mua: {{$callbackData['buyerEmail']}}</p>
    <p>Số điện thoại người mua: {{$callbackData['buyerPhone']}}</p>
    <br><hr><br>
    <h2>THÔNG TIN THANH TOÁN</h2>
    <p>Ngân hàng: {{$callbackData['bankName']}}</p>
    <p>Số thẻ: {{$callbackData['cardNumber']}}</p>
    <p>Loại thẻ: {{$callbackData['method']}}</p>
    <p>Thời gian giao dịch: {{ $callbackData['transactionTimeConvert'] }}</p>
    <p>Thời gian thanh toán thành công: {{ $callbackData['successTimeConvert'] }}</p>
    <br><hr><br>
    
</body>
</html>