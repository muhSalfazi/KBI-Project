<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Import Excel File ADM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 500px;
      margin-top: 100px;
      padding: 30px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <h3 class="text-center mb-4">Import Excel File ADM</h3>
    <form action="{{ route('import.excelADM') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="excelFile" class="form-label">Choose Excel File (.xls, .xlsx)</label>
        <input class="form-control" type="file" id="excelFile" name="excel_file" accept=".xls,.xlsx" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Import</button>
    </form>
        <div class="text-center mt-3">
      <a href="{{ asset('assets/template/template_import.xlsx') }}" class="btn btn-success">
        Unduh Template Excel
      </a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 2000
    })
  </script>
@endif

@if (session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: '{{ session('error') }}',
      showConfirmButton: true
    })
  </script>
@endif
</body>
</html>
