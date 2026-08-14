<?php
session_start();

// Khởi tạo session tracking nếu chưa có
if (!isset($_SESSION['request_log'])) {
    $_SESSION['request_log'] = [];
    $_SESSION['total_connections'] = 0;
    $_SESSION['unique_ips'] = [];
}

// Lấy thông tin client
$client_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$request_time = date('Y-m-d H:i:s');

// Thêm request vào log
$request_log = $_SESSION['request_log'];
$new_request = [
    'time' => $request_time,
    'method' => $request_method,
    'url' => $request_uri,
    'ip' => $client_ip,
    'user_agent' => $user_agent,
    'status' => 'Success'
];

array_unshift($request_log, $new_request);
if (count($request_log) > 50) {
    array_pop($request_log);
}
$_SESSION['request_log'] = $request_log;

// Cập nhật tổng connections
$_SESSION['total_connections']++;

// Thêm IP vào danh sách unique
if (!in_array($client_ip, $_SESSION['unique_ips'])) {
    $_SESSION['unique_ips'][] = $client_ip;
}

// Trả về JSON nếu là AJAX request
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'total_connections' => $_SESSION['total_connections'],
        'unique_visitors' => count($_SESSION['unique_ips']),
        'requests' => $_SESSION['request_log'],
        'client_ip' => $client_ip,
        'server_time' => date('Y-m-d H:i:s')
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSTAT - PHP Connection Monitor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0a1a;
            color: #fff;
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            text-align: center;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #16213e;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            border: 1px solid #2a3a6e;
        }
        
        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #a8a8a8;
        }
        
        .table-container {
            background: #16213e;
            border-radius: 15px;
            padding: 20px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #0f3460;
            padding: 12px;
            text-align: left;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #2a3a6e;
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
        }
        
        .badge-get { background: #4caf50; color: white; }
        .badge-post { background: #2196f3; color: white; }
        .badge-put { background: #ff9800; color: white; }
        .badge-delete { background: #f44336; color: white; }
        
        .refresh-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            margin: 20px;
            transition: all 0.3s;
        }
        
        .refresh-btn:hover {
            background: #764ba2;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 DSTAT - PHP Connection Monitor</h1>
        <p>Real-time Connection Tracking</p>
    </div>
    
    <div class="container">
        <div style="text-align: center;">
            <button class="refresh-btn" onclick="location.reload()">🔄 Refresh</button>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo $_SESSION['total_connections']; ?></div>
                <div class="stat-label">Total Connections</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo count($_SESSION['unique_ips']); ?></div>
                <div class="stat-label">Unique Visitors</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $client_ip; ?></div>
                <div class="stat-label">Your IP</div>
            </div>
        </div>
        
        <div class="table-container">
            <h3>📋 Request Log</h3>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Method</th>
                        <th>URL</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['request_log'] as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['time']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo strtolower($request['method']); ?>">
                                <?php echo htmlspecialchars($request['method']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($request['url']); ?></td>
                        <td><?php echo htmlspecialchars($request['ip']); ?></td>
                        <td><?php echo htmlspecialchars(substr($request['user_agent'], 0, 50)); ?>...</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
