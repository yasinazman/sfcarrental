<script>
// Fungsi untuk memaparkan Modal (Panggil fungsi ini bila butang di klik)
function openAuthModal() {
    document.getElementById('auth-modal').style.display = 'flex';
}

// Fungsi untuk menutup Modal
function closeAuthModal() {
    document.getElementById('auth-modal').style.display = 'none';
}

// Tutup modal secara automatik jika user klik di luar kotak modal
window.onclick = function(event) {
    const modal = document.getElementById('auth-modal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Fungsi untuk tukar Tab Login / Register
function toggleAuthTab(target) {
    const tabLogin = document.getElementById('tab-login');
    const tabSignup = document.getElementById('tab-signup');
    const formLogin = document.getElementById('form-login-section');
    const formSignup = document.getElementById('form-signup-section');

    if(target === 'login') {
        tabLogin.classList.add('active');
        tabSignup.classList.remove('active');
        formLogin.classList.add('active');
        formSignup.classList.remove('active');
    } else {
        tabSignup.classList.add('active');
        tabLogin.classList.remove('active');
        formSignup.classList.add('active');
        formLogin.classList.remove('active');
    }
}

// Fungsi mata password (tunjuk/sorok)
function viewPassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>