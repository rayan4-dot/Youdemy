<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 text-center">Welcome Back</h2>
    <p class="text-sm text-gray-600 text-center mb-6">Please login to your account</p>

    <form action="#" method="POST">
      <!-- Email Input -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" required
          class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <!-- Password Input -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
          class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <!-- Remember Me Checkbox -->
      <div class="flex items-center justify-between mb-4">
        <label class="flex items-center">
          <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
          <span class="ml-2 text-sm text-gray-700">Remember me</span>
        </label>
        <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot your password?</a>
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
        Login
      </button>
    </form>

    <p class="mt-6 text-sm text-center text-gray-600">
      Don't have an account? 
      <a href="register.php" class="text-indigo-600 hover:underline">Sign up</a>
    </p>
  </div>

</body>
</html>
