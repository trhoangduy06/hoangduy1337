<?php

// Telegram Bot API token và chat_id (thay giá trị này bằng token và chat_id của bạn)
$apiToken = "7109674743:AAEWzStMNuYRTErxQgSY0LExtuVJcShhyI4"; 
$chat_id = "6898590295"; 

// Lấy địa chỉ IP của người truy cập
$user_ip = $_SERVER['REMOTE_ADDR'];

// Gửi yêu cầu API để lấy thông tin vị trí của địa chỉ IP
$location_data = file_get_contents("http://ip-api.com/json/$user_ip?fields=country,city,regionName");

// Giải mã dữ liệu JSON từ API
$location = json_decode($location_data);

// Kiểm tra nếu dữ liệu được trả về hợp lệ
if ($location && $location->status == 'success') {
    $country = $location->country;
    $region = $location->regionName;
    $city = $location->city;
    $location_info = "$city, $region, $country";
} else {
    $location_info = "Không thể xác định vị trí";
}

// Tạo thông báo để gửi về Telegram
$message = "IP Address: $user_ip\nLocation: $location_info\n@trhoagduy";

// Gửi thông báo về Telegram
$url = "https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&text=" . urlencode($message);

// Sử dụng file_get_contents để gửi thông báo
file_get_contents($url);
?>