📋 Ringkasan Aliran Program:
WELCOME.BLADE.PHP → Tombol "Daftar" link ke /register
↓
AUTH.PHP → GET /register → RegisteredUserController::create()
↓
CONTROLLER CREATE() → Return view('auth.register')
↓
REGISTER.BLADE.PHP → Form dengan field: name, email, password, role
↓
USER SUBMIT FORM → POST /register
↓
AUTH.PHP → POST /register → RegisteredUserController::store()
↓
CONTROLLER STORE() →

Validasi data
Buat user di database
Emit event Registered
Auto-login dengan Auth::login()
Redirect ke dashboard

↓
DATABASE → Insert ke tabel users


↓
DASHBOARD → User authenticated & masuk

Dokumentasi lengkap sudah disimpan di ALIRAN_PROGRAM_REGISTER.md dengan:

Flow diagram step-by-step
Data flow diagram visual
Middleware chain
Request/Response HTTP
File structure reference
Validation details