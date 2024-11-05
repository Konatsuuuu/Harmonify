<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Harmonify - Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid items-center justify-center min-h-screen">
    <div class="grid p-4 border rounded-lg justify-center items-center divide-y-2 space-y-4">
        <div class="grid items-center justify-center p-4 space-y-4">
            <div class="mb-4 text-2xl font-bold">Registration</div>
            <div class="flex justify-between w-full m-2">
                <label for="email" class="text-lg">Email</label>
                <input id="email" type="text" class="border ml-4 rounded">
            </div>
            <div class="flex justify-between w-full m-2">
                <label for="username" class="text-lg">Username</label>
                <input id="username" type="text" class="border ml-4 rounded">
            </div>
            <div class="flex justify-between w-full m-2">
                <label for="password" class="text-lg">Password</label>
                <input id="password" type="password" class="border ml-4 rounded">
            </div>
            <div class="flex justify-between w-full m-2">
                <span for="password_confirmation" class="text-lg">Confirm Password</span>
                <input for="password_confirmation" type="password" class="border ml-4 rounded">
            </div>
            <div class="flex justify-end items-center space-x-2">
                <button type="submit" onclick="createUser()" class="m-1 px-4 py-2 bg-[#A1D2CE] text-[#50858B] rounded-lg"> Register </button>
            </div>
        </div>
        <div class="grid p-4 justify-center items-center">
        <div class="flex m-2">
            <span class="text-xl p-2">Or...</span>
            <span>
                {{-- google login button from official website --}}
                <button class="gsi-material-button">
                    <div class="gsi-material-button-state"></div>
                    <div class="gsi-material-button-content-wrapper">
                        <div class="gsi-material-button-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                            <path fill="none" d="M0 0h48v48H0z"></path>
                        </svg>
                        </div>
                        <span class="gsi-material-button-contents">Continue with Google</span>
                        <span style="display: none;">Continue with Google</span>
                    </div>
                </button>
            </span>

        </div>
    </div>
    </div>

</body>
</html>

<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
    import { getAuth, createUserWithEmailAndPassword  } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-auth.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-analytics.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
    apiKey: "AIzaSyDOcUz9FFkzTGWT-7GOT5rGZK_SVmmtxfg",
    authDomain: "harmonify-af9f4.firebaseapp.com",
    projectId: "harmonify-af9f4",
    storageBucket: "harmonify-af9f4.firebasestorage.app",
    messagingSenderId: "536611376141",
    appId: "1:536611376141:web:bb3cf2960825757b3e5944",
    measurementId: "G-DGEF2BKFH9"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);

    // Initialize Firebase Authentication and get a reference to the service
    const auth = getAuth(app);

    window.createUser = function ()
    {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        createUserWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            // Signed up
            const user = userCredential.user;
            // ...
            alert("User registered successfully!");
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            // ..
            alert(`Error: ${errorMessage}`);
        });
    }
</script>
