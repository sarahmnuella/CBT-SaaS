<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Ditangguhkan - CBT SaaS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0b0f19;
            color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 1.5rem;
            background-image: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.08) 0%, transparent 60%);
        }
        .card {
            background: rgba(22, 31, 48, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 3rem 2rem;
            max-width: 550px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .icon {
            font-size: 5rem;
            color: #ef4444;
            margin-bottom: 2rem;
            text-shadow: 0 0 30px rgba(239, 68, 68, 0.3);
        }
        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        p {
            color: #9ca3af;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #ef4444;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-ban"></i></div>
        <h1>Sekolah Ditangguhkan</h1>
        <p>Akses portal CBT untuk sekolah <strong>{{ $tenant->nama_sekolah }}</strong> sedang ditangguhkan atau dinonaktifkan sementara oleh Super Admin. Harap hubungi admin sekolah Anda.</p>
        <a href="https://wa.me/#" class="btn"><i class="fa-solid fa-circle-question"></i> Ajukan Pertanyaan</a>
    </div>
</body>
</html>
