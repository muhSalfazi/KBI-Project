<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login | Double Check Delivery</title>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"/>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="login">
        <div class="login-container">
            <h3 class="text-center login-title" style="font-weight: 600">
                LOGIN DELIVERY SISTEM
            </h3>
            <form action="{{ route('login-process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="job">Pilih Job</label>
                    <select id="job" name="job" class="form-control" required>
                        <option value="" disabled selected>Pilih Job</option>
                        <option value="admin">Admin</option>
                        <option value="prepare">Prepare Member</option>
                        <option value="check-prepare">Check Prepare - Leader</option>
                        <option value="check-loading">Loading Check - Leader</option>
                    </select>
                </div>

                <div class="form-group">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="ID Card"
                        autofocus
                        required
                    />
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('hero') }}" class="btn btn-secondary">Dashboard</a>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session("error") }}'
                });
            </script>
            @endif

        </div>
    </body>
</html>
