{{--
    Alert session dikonversi otomatis ke Toast Notification oleh JS di layouts/app.blade.php.
    Div di bawah ini tetap ditulis agar JS bisa mendeteksi & mengambil pesannya, lalu menghapusnya.
--}}
@if (session('success'))
    <div class="alert alert-success" style="display:none;">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error" style="display:none;">{{ session('error') }}</div>
@endif
