<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pesan Baru</title>
</head>

<body>
    <h2>Pesan Baru dari Formulir Kontak</h2>

    <p><strong>Nama:</strong> {{ $formData['name'] }}</p>
    <p><strong>Email:</strong> {{ $formData['email'] }}</p>
    <p><strong>Pesan:</strong><br>{{ $formData['message'] }}</p>
</body>

</html>