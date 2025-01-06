// Khi trang web được tải
window.addEventListener("load", function () {
    // Lấy phần tử hiển thị thông báo
    const welcomeMessage = document.getElementById("welcome-message");

    // Gán nội dung thông báo
    welcomeMessage.textContent = "Chào mừng trở lại! Hãy đăng nhập để tiếp tục.";

    // Thêm kiểu dáng động (tuỳ chọn)
    welcomeMessage.style.color = "#00ff00"; // Màu xanh lá
    welcomeMessage.style.fontSize = "18px"; // Kích thước chữ
    welcomeMessage.style.marginBottom = "20px"; // Khoảng cách dưới
    welcomeMessage.style.fontStyle = "italic"; // Kiểu chữ nghiêng
});