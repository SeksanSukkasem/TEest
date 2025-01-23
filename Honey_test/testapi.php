<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลการตรวจจับช้าง</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">ข้อมูลการตรวจจับช้าง</h1>
        
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">วันที่และเวลา</th>
                        <th class="px-4 py-2">ตำแหน่งกล้อง</th>
                        <th class="px-4 py-2">การตรวจจับ</th>
                        <th class="px-4 py-2">ระดับความรุนแรง</th>
                        <th class="px-4 py-2">สถานะ</th>
                        <th class="px-4 py-2">รูปภาพ</th>
                        <th class="px-4 py-2">การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // ดึงข้อมูลจาก API
                    $api_url = 'https://aprlabtop.com/elephant_api/get_detections.php';
                    $response = file_get_contents($api_url);
                    
                    if ($response === FALSE) {
                        echo '<tr><td colspan="8" class="px-4 py-2 text-center text-red-600">ไม่สามารถเชื่อมต่อกับ API ได้</td></tr>';
                    } else {
                        $data = json_decode($response, true);
                        
                        if ($data['status'] === 'success' && !empty($data['data'])) {
                            foreach ($data['data'] as $row) {
                                echo '<tr class="border-b hover:bg-gray-50">';
                                
                                // ID
                                echo '<td class="px-4 py-2 text-center">' . htmlspecialchars($row['id']) . '</td>';
                                
                                // วันที่และเวลา
                                $timestamp = new DateTime($row['timestamp']);
                                echo '<td class="px-4 py-2">' . $timestamp->format('d/m/Y H:i:s') . '</td>';
                                
                                // ตำแหน่งกล้อง
                                echo '<td class="px-4 py-2">' . htmlspecialchars($row['camera_address']) . '</td>';
                                
                                // การตรวจจับ
                                echo '<td class="px-4 py-2">' . $row['detection_display'] . '</td>';
                                
                                // ระดับความรุนแรง
                                echo '<td class="px-4 py-2"><span class="px-2 py-1 rounded ' . 
                                    htmlspecialchars($row['intensity_class']) . '">' . 
                                    htmlspecialchars($row['intensity_text']) . '</span></td>';
                                
                                // สถานะ
                                echo '<td class="px-4 py-2">' . htmlspecialchars($row['status']) . '</td>';
                                
                                // รูปภาพ
                                echo '<td class="px-4 py-2">';
                                if (!empty($row['image_path'])) {
                                    echo '<a href="' . htmlspecialchars($row['image_path']) . '" target="_blank">
                                            <img src="' . htmlspecialchars($row['image_path']) . '" 
                                                 alt="ภาพตรวจจับ" 
                                                 class="w-16 h-16 object-cover rounded">
                                          </a>';
                                } else {
                                    echo '<span class="text-gray-400">ไม่มีรูปภาพ</span>';
                                }
                                echo '</td>';
                                
                                // การจัดการ
                                echo '<td class="px-4 py-2 text-center">';
                                if (!empty($row['edit_link'])) {
                                    echo $row['edit_link'];
                                } else {
                                    echo '<span class="text-gray-400">-</span>';
                                }
                                echo '</td>';
                                
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="8" class="px-4 py-2 text-center">ไม่พบข้อมูล</td></tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Auto-refresh ทุก 1 นาที
    setTimeout(function() {
        location.reload();
    }, 60000);
    </script>
</body>
</html>