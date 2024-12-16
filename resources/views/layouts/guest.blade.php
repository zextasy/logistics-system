<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistics Solutions</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            line-height: 1.6;
            color: #333;
        }

        /* Navbar */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header .logo {
            font-size: 20px;
            font-weight: bold;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
        }

        .buttons a {
            text-decoration: none;
            margin-left: 10px;
            padding: 5px 10px;
            border: 1px solid #333;
            border-radius: 5px;
            color: #333;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #f3f3f3;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .hero p {
            margin: 20px 0;
            color: #555;
        }

        .hero .btn {
            margin: 10px;
            padding: 10px 20px;
            background: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .placeholder {
            width: 100%;
            height: 300px;
            background: #d3d3d3;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #777;
        }

        /* Section Style */
        .section {
            padding: 40px 20px;
            text-align: center;
        }

        .section h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .section p {
            margin-bottom: 20px;
            color: #555;
        }

        .card-wrapper {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            flex: 1 1 calc(33.333% - 20px);
            background: #fff;
            border: 1px solid #e6e6e6;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        /* Process Section */
        .process {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .process-step {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fafafa;
        }

        /* CTA */
        .cta {
            background: #f3f3f3;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }

        .cta a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Footer */
        footer {
            background: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }
        /* Filament */
        [x-cloak] {
            display: none !important;
        }
    </style>
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="min-h-screen">
    <!-- Navbar -->
    <header>
        <div class="logo">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </div>
        <nav>
            <a href="{{route('home')}}#">Home Page</a>
            <a href="{{route('home')}}#">Services Offered</a>
            <a href="{{route('home')}}#">Contact Us</a>
            <a href="{{route('home')}}#">More Info</a>
            <a href="{{route('quote.create')}}#">Get a Quote</a>
            <a href="{{route('tracking.form')}}#">Track a Shipment</a>
        </nav>
        <div class="buttons">
            <a href="{{route('register')}}">Join</a>
            <a href="{{route('login')}}">Login</a>
        </div>
    </header>
    {{$slot}}
    @livewire('notifications')
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Logistics Solutions | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>
    @filamentScripts
</div>
</body>
</html>
