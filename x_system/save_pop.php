<?php

$index = isset($_POST['index']) ? $_POST['index'] : null; 

// 이미지 업로드 처리
$imageUrl = ""; // 이미지 URL 초기화

if (isset($_FILES['popup_image']['name']) && $_FILES['popup_image']['name'] != '') {
    $target_dir = "uploads/img/pop/";
    $file_extension = pathinfo($_FILES["popup_image"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . time() . '_' . uniqid() . '.' . $file_extension;
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES["popup_image"]["tmp_name"], $target_file)) {
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $imageUrl = $scheme . '://' . $host . '/x_system/' . $target_file;
    }
}



// 기존 데이터 로드
$filename = 'pop_json.json';
$existingData = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
if (!is_array($existingData)) {
    $existingData = [];
}



if ($index !== null && isset($existingData[$index])) {
    // 수정 로직
    $existingData[$index] = [
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'title' => $_POST['title'],
        // 이미지 URL 처리: 새 이미지가 없으면 기존 URL 유지
        'image_url' => $imageUrl ?: $existingData[$index]['image_url'],
         'pop_link' => $_POST['pop_link'],
         'pop_position_top' => $_POST['pop_position_top'],
        'pop_position_left' => $_POST['pop_position_left']
    ];
} else {
     $uniqueId = uniqid(); // 유니크넘버 생성
    // 새 항목 추가 로직
    $newData = [
       'uniqueId' => $uniqueId,
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'title' => $_POST['title'],
        'image_url' => $imageUrl,
         'pop_link' => $_POST['pop_link'],
          'pop_position_top' => $_POST['pop_position_top'],
        'pop_position_left' => $_POST['pop_position_left']
    ];
    $existingData[] = $newData;
}



// 파일에 저장
file_put_contents('pop_json.json', json_encode($existingData, JSON_PRETTY_PRINT));

echo "<script>
    alert('팝업이 성공적으로 저장되었습니다.');
    window.location.href = 'pop_list.php';
</script>";
?>
