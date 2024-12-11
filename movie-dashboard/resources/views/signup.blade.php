<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Popular Movies Analytics Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gradient-to-r from-gray-900 to-gray-700 text-white">
    <div class="bg-black bg-opacity-80 p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-yellow-400 mb-6">Sign Up</h1>
        <form action="/signup" method="POST" class="flex flex-col">
            @csrf
            <input 
                type="text" 
                name="username" 
                placeholder="Username" 
                value="{{ old('username') }}"
                required 
                class="p-3 mb-4 rounded border border-gray-700 bg-gray-800 focus:outline-none focus:ring focus:ring-yellow-400"
            >
            @error('username')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror
            <input 
                type="email" 
                name="email" 
                placeholder="Email Address" 
                value="{{ old('email') }}"
                required 
                class="p-3 mb-4 rounded border border-gray-700 bg-gray-800 focus:outline-none focus:ring focus:ring-yellow-400"
            >
            @error('email')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror
            <input 
                type="password" 
                name="password" 
                placeholder="Password" 
                required 
                class="p-3 mb-4 rounded border border-gray-700 bg-gray-800 focus:outline-none focus:ring focus:ring-yellow-400"
            >
            @error('password')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror
            <input 
                type="password" 
                name="password_confirmation" 
                placeholder="Confirm Password" 
                required 
                class="p-3 mb-4 rounded border border-gray-700 bg-gray-800 focus:outline-none focus:ring focus:ring-yellow-400"
            >
            <input 
                type="submit" 
                value="Create Account" 
                class="bg-yellow-400 text-black font-bold p-3 rounded cursor-pointer hover:bg-yellow-500 transition"
            >
        </form>
        <p class="mt-4 text-sm">Already have an account? <a href="/login" class="text-yellow-400 hover:underline">Log in</a></p>
    </div>
</body>
</html>
