<?php

// 기본 이미지 사용 여부 체크
$useDefaultImage = isset($_POST['use_default_image']) ? true : false;

$index = isset($_POST['index']) ? $_POST['index'] : null; 

// 파일 업로드 처리
$imageUrl = ""; // 이미지 URL 초기화
if (isset($_FILES['news_image']['name']) && $_FILES['news_image']['name'] != '') {
    $target_dir = "uploads/img/news/"; 
     $file_extension = pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . time() . '_' . uniqid() . '.' . $file_extension;
    
    
    // 디렉토리가 없으면 생성
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // 파일을 지정된 위치로 이동
    if (move_uploaded_file($_FILES["news_image"]["tmp_name"], $target_file)) {
        // 동적으로 현재 서버의 URL 생성
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $imageUrl = $scheme . '://' . $host . '/x_system/' . $target_file; // 이미지 URL 생성
    }
} elseif ($useDefaultImage) {
    // 기본 이미지의 URL을 설정
    $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    // 예: 기본 이미지 경로 설정, 실제 경로에 맞게 수정해야 함
    $imageUrl = $scheme . '://' . $host . '/x_system/uploads/img/news/default_news_image.jpg';
}


// 기존 데이터 로드
$filename = 'news_data.json';
$existingData = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
if (!is_array($existingData)) {
    $existingData = [];
}

if ($index !== null && isset($existingData[$index])) {
    // 수정 로직
    $existingData[$index] = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        // 이미지 URL 처리: 새 이미지가 없으면 기존 URL 유지
        'image_url' => $imageUrl ?: $existingData[$index]['image_url'],
        'use_default_image' => $useDefaultImage,
        'news_link' => $_POST['news_link'],
         'created_at' => $_POST['news_datatime']
    ];
} else {
    // 새 항목 추가 로직
    $newData = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'image_url' => $imageUrl,
        'use_default_image' => $useDefaultImage,
        'news_link' => $_POST['news_link'],
         'created_at' =>  $_POST['news_datatime'] // 현재 날짜와 시간 추가
    ];
    $existingData[] = $newData;
}

// 변경된 데이터를 파일에 저장
file_put_contents($filename, json_encode($existingData, JSON_PRETTY_PRINT));

echo "<script>
    alert('뉴스가 성공적으로 저장되었습니다.');
    window.location.href = 'news_list.php';
</script>";

?>
