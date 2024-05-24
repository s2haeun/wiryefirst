<?php

// 팝업 인덱스 받기
$indexToDelete = isset($_POST['index']) ? (int)$_POST['index'] : -1;

// 파일에서 기존 데이터 로드
$filename = 'news_data.json';
if (file_exists($filename)) {
    $data = json_decode(file_get_contents($filename), true);
    if (!is_array($data)) {
        $data = [];
    }

    // 인덱스를 사용하여 해당 데이터 삭제
    if ($indexToDelete >= 0 && $indexToDelete < count($data)) {
        array_splice($data, $indexToDelete, 1); // 데이터 삭제
        // 변경된 데이터를 파일에 저장
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
        echo "성공적으로 삭제되었습니다.";
    } else {
        echo "삭제할 데이터를 찾을 수 없습니다.";
    }
} else {
    echo "데이터 파일이 존재하지 않습니다.";
}

?>
