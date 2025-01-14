<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Register</title>
    <style>
        /* Animated gradient background */
        @keyframes gradient-animation {
            0% {
                background: linear-gradient(45deg, #ff6ec7, #ff9a8b);
            }
            50% {
                background: linear-gradient(45deg, #00d2ff, #3a7bd5);
            }
            100% {
                background: linear-gradient(45deg, #ff6ec7, #ff9a8b);
            }
        }

        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #f7f7f7;
            animation: gradient-animation 15s ease infinite; /* Gradient animation */
        }

        .form-container {
            background: rgba(0, 0, 0, 0.6); /* Semi-transparent background for readability */
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: absolute;
            z-index: 10;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        h2 {
            font-size: 2.5rem;
            color: #fff;
        }

        .form-input,
        .form-select,
        .form-textarea {
            background-color: #ffffff;
            border: 1px solid #dcdfe6;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            transition: border-color 0.3s ease-in-out;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #4f46e5;
            outline: none;
        }

        .form-input,
        .form-select {
            height: 50px;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .file-input {
            width: 100%;
            padding: 12px;
            background-color: #ffffff;
            border: 1px solid #dcdfe6;
            border-radius: 10px;
            transition: border-color 0.3s ease-in-out;
        }

        .file-input:focus {
            border-color: #4f46e5;
        }

        #image-preview {
            display: none;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: 10px;
            border: 2px solid #ffffff;
        }

        button[type="submit"] {
            background-color: #4f46e5;
            color: #fff;
            border: none;
            padding: 15px;
            border-radius: 10px;
            width: 100%;
            font-size: 1.125rem;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button[type="submit"]:hover {
            background-color: #3730a3;
        }

        .login-link {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease-in-out;
        }

        .login-link:hover {
            color: #a0aec0;
        }

        .text-gray-600 {
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
    <script>
        function updateImagePreview(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</head>

<body>

    <div class="form-container">
        <h2 class="text-center mb-8">Create Account</h2>
        <form>
            <div class="mb-6">
                <label class="block text-gray-200">Full Name</label>
                <input type="text" placeholder="Your Name" class="form-input" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-200">Email</label>
                <input type="email" placeholder="Your Email" class="form-input" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-200">Password</label>
                <input type="password" placeholder="Your Password" class="form-input" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-200">Select Role</label>
                <select class="form-select" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-gray-200">Bio</label>
                <textarea placeholder="Tell us about yourself..." class="form-textarea" rows="4" required></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-gray-200">Profile Picture</label>
                <input type="file" accept="image/*" onchange="updateImagePreview(event)" class="file-input" required>
                <div class="flex justify-center mt-3">
                    <img id="image-preview" alt="Profile Preview" />
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
        <p class="mt-6 text-center text-gray-600">Already have an account? <a href="login.php" class="login-link">Login here</a></p>
    </div>

</body>

</html>
