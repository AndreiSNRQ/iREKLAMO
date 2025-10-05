<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>iREKLAMO+ | Login</title>
    <link rel="icon" href="fist.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');

.permanent-marker-regular {
    font-family: "Permanent Marker", cursive;
    font-weight: 400;
    font-style: normal;
}
</style>

<body class="scroll-smooth max-h-screen">
    <div class="container max-w-screen min-h-screen flex justify-center items-center bg-gray-200">
        <div class="row flex flex-col gap-4">
            <h1 class="text-4xl font-bold text-[2rem] text-center"><i class="fa fa-hand-fist text-[3rem]"></i><span class="bg-gradient-to-r from-slate-900 to-red-600 bg-clip-text text-transparent permanent-marker-regular italic font-light tracking-wide"> IREKLAMO+</span></h1>
            <div class="col h-[20rem] w-[35rem] inset-shadow-xs shadow-md rounded-xl py-10">
                <p class="text-lg text-center font-bold">Login into your Account</p>
                <?php if (isset($_SESSION['error'])): ?>
                    <p class="text-red-500 text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                <br>
                <?php if (isset($_GET['error'])): ?>
                    <p class="text-red-500 text-center">Invalid username or password.</p>
                <?php endif; ?>
                <form class="flex flex-col gap-3 px-10" action="authenticate.php" method="post">
                    <input type="text" name="username" placeholder="Username" class="border border-gray-300 p-2 w-full mb-2 rounded-sm" required />
                    <input type="password" name="password" placeholder="Password" class="border border-gray-300 p-2 w-full mb-2 rounded-sm" required />
                    <button type="submit" class="bg-blue-500 text-white p-2 w-full">Login</button>
                    <p class="text-center"><a href="#" class="text-blue-500 hover:underline">Forgot Password?</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>