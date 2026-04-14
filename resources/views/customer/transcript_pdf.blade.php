<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transkripsi Pesanan #{{ $pesanan->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        pre { white-space: pre-wrap; }
    </style>
</head>
<body>

<h3>Hasil Transkripsi AI</h3>
<p>Pesanan #{{ $pesanan->id }}</p>
<hr>

<pre>
{{ $pesanan->transkripsi->hasil }}
</pre>

</body>
</html>
