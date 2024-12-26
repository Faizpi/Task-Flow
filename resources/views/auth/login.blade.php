<x-guest-layout>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('{{ asset('images/background.png') }}'); /* URL gambar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.5); /* Background transparan */
            border-radius: 30px; /* Membulatkan sudut */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan */
            padding: 30px 40px;
            text-align: center;
            width: 100%;
            max-width: 400px; /* Membatasi lebar */
            backdrop-filter: blur(10px)
        }

        .login-container img {
            width: 200px; /* Ukuran logo */
            display: block; /* Memastikan elemen img menjadi blok */
            margin: 0 auto 20px; /* Memusatkan logo secara horizontal & menambahkan jarak bawah */
        }

        .login-container h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .login-container p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .login-container input:focus {
            outline: none;
            border-color: #ff9a9e;
            box-shadow: 0 0 8px rgba(255, 154, 158, 0.5);
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: linear-gradient(90deg, #ff9a9e, #fad0c4);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .login-container button:hover {
            background: linear-gradient(90deg, #fbc2eb, #a6c1ee);
            transform: scale(1.02);
        }

        .helper-text {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .helper-text a {
            color: #ff9a9e;
            text-decoration: none;
        }

        .helper-text a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="login-container">
        <!-- Logo -->
        <img src="{{ asset('images/your-logo.png') }}" alt="Logo"> <!-- Ganti 'your-logo.png' dengan nama file Anda -->

        <h2>Log in to TaskFlow</h2>
        <p>Welcome back! Please enter your email and password to continue.</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required autofocus />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        
        <p class="helper-text">
            Don't have an account? <a href="{{ route('register') }}">Register here.</a>
        </p>
    </div>
</x-guest-layout>
