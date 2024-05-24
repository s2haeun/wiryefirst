<?php
session_start(); // 세션 시작

// 퍼블리셔 아이디와 비밀번호 파일
$CredentialsFile = 'password.json';

// 퍼블리셔 아이디와 비밀번호 로드
$CredentialsData = json_decode(file_get_contents($CredentialsFile), true);
$storedId = $CredentialsData['id'] ?? '';
$storedPassword = $CredentialsData['password'] ?? '';

// 로그인 폼이 제출되었는지 확인
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputId = $_POST['id'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    // 입력된 아이디와 비밀번호가 일치하는지 확인
    if ($inputId === $storedId && $inputPassword === $storedPassword) {
        // 세션 변수 설정
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $inputId;

        // 로그인 성공 시 리다이렉트
        header('Location: pop_list.php');
        exit;
    } else {
        // 로그인 실패 메시지
        $loginFailed = true;
    }
}

// 로그인되어 있는지 확인하여 리다이렉트
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header('Location: pop_list.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ADMIN - LOGIN</title>
    <link rel="stylesheet" type="text/css" href="main.css?a">
</head>
<body>

    <?php if (isset($loginFailed) && $loginFailed): ?>
        <p>아이디 또는 비밀번호가 틀렸습니다. 다시 시도해주세요.</p>
    <?php endif; ?>

    <div class="main_bg">
        <div class="main_flex">
        <p id="logo"> <img src="../img/logo_b.png" width="100%"/></p>
            <h1 class="text_type_3"> ADMIN</h1>

            <form action="index.php" method="post">
                <input class="id_bg_type_1" type="text" id="id" name="id" placeholder="아이디">
                <input class="password_bg_type_1" type="password" id="password" name="password" placeholder="비밀번호">
                <button class="login_btn_type_2" type="submit"> LOGIN </button>
            </form>
        </div>
    </div>

</body>
</html>
