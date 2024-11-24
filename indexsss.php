<?php
require 'header.php';
if (isset($_GET['message'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['message']) . "');</script>";
}

?>

<div class="container vh-100 d-flex align-items-center justify-content-center" style="background: url('assets/img/logo coffe.jpg') no-repeat center center; background-size: cover; position: relative;">
    <div style="background-color: rgba(139, 69, 19, 0.6); position: absolute; inset: 0;"></div>
    <div class="card col-md-6 col-sm-8 col-10 position-relative">
        <div class="card-body p-4">
            <h2 class="text-center text mb-4">Login</h2>
            <form action="cek_login.php" method="post">
                <div class="form-group mb-3">
                    <label for="username" class="text">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control"
                        placeholder="Enter your username"
                        required />
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="text">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required />
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            id="togglePassword">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Toggle password visibility
    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.getElementById("password");
        const passwordIcon = document.getElementById("togglePasswordIcon");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.remove("fa-eye");
            passwordIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordIcon.classList.remove("fa-eye-slash");
            passwordIcon.classList.add("fa-eye");
        }
    });
    document.querySelector("form").addEventListener("submit", async function(e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(e.target);
        try {
            const response = await fetch("cek_login.php", {
                method: "POST",
                body: formData,
            });

            if (!response.ok) throw new Error("Server error");

            const result = await response.json();

            if (result.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Login Successful",
                    text: "Redirecting...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(() => {
                    window.location.href = result.redirect;
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: result.message,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred. Please try again later.",
                showConfirmButton: true,
            });
        }
    });
</script>

<?php
require 'footer.php';
?>