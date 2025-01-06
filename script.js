// Đóng thông báo UI
function closeNotification() {
    const notification = document.getElementById("ui-notification");
    notification.classList.add("hidden");
}

// Chuyển đổi sang form đăng ký
function toggleRegister() {
    document.getElementById("login-section").style.display = "none";
    document.getElementById("register-section").style.display = "block";
}

// Chuyển đổi sang form đăng nhập
function toggleLogin() {
    document.getElementById("register-section").style.display = "none";
    document.getElementById("login-section").style.display = "block";
}