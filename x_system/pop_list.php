<?php

session_start(); // 세션 시작

// 세션에 로그인 여부 확인
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // 로그인되어 있지 않으면 index.php로 리다이렉트
    header('Location: index.php');
    exit;
}




// pop_json.json 파일에서 데이터 로드
$data = json_decode(file_get_contents('pop_json.json'), true);

// 현재 날짜와 시간
$now = new DateTime();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMIN - 팝업 목록</title>
    <link rel="stylesheet" type="text/css" href="main.css">

</head>
<body>
    <div class="main_bg">
        <div class="main_warp">
            <div class="left_warp">
                <div class="left_logo"></div>
                <div class="left_tit_text">ADMIN</div>
                <div class="left_menu_warp">
                    <a href="pop_list.php"><div class="btn on">
                    팝업관리자
                    </div></a>
                    <!-- <a href="news_list.php"><div class="btn ">
                    언론보도
                    </div></a> -->
                </div>
            </div>
            <div class="right_warp">
            <div class="right_warp1">
                <div class="right_tit">팝업관리자 - 팝업목록</div>
                <div class="right_cont">
                    <div class="right_cont1">
                    <table class="pop_list_table" >
                        <tr class="tit">
                            <th width="20%">진행여부</th>
                            <th width="40%">팝업제목</th>
                            <th width="20%">진행날짜</th>
                            <th width="20%"> </th>
                        </tr>
                        <?php foreach ($data as $index => $popup): ?>
                            <?php
                                // 날짜 비교
                                $startDate = new DateTime($popup['start_date']);
                                $endDate = new DateTime($popup['end_date']);
                                if ($now < $startDate) {
                                    $status = '대기중';
                                } elseif ($now > $endDate) {
                                    $status = '종료';
                                } else {
                                    $status = '진행중';
                                }
                                $class = '';
                                switch ($status) {
                                    case '대기중':
                                        $class = 'waiting';
                                        break;
                                    case '종료':
                                        $class = 'finished';
                                        break;
                                    case '진행중':
                                        $class = 'ongoing';
                                        break;
                                    default:
                                        $class = '';
                                        break;
                                }
                            ?>
                            <tr>
                                <td class="status <?= $class ?>"><?= $status ?></td>
                                <td><?= htmlspecialchars($popup['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= $startDate->format('Y-m-d H:i') ?> ~ <?= $endDate->format('Y-m-d H:i') ?></td>
                                <td>
                                <button onclick="location.href='pop_form.php?index=<?= $index ?>'">수정</button>

                                    <button class="del" onclick="deletePopup(<?= $index ?>)">삭제</button>
                                </td>
                            </tr>   
                        <?php endforeach; ?>
                    </table>
                    </div>
                </div>
                <div onclick="location.href='pop_form.php'" class="right_main_btn">팝업 추가</div>

            </div>
            </div>
        </div>
    </div>




    <script>
    

        function deletePopup(index) {
            if (confirm('정말로 삭제하시겠습니까?')) {
                // AJAX 요청으로 삭제 처리
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'pop_delete.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        window.location.reload(); // 성공적으로 삭제 후 페이지 새로고침
                    } else {
                        alert('삭제에 실패했습니다.');
                    }
                };
                xhr.send('index=' + index);
            }
        }

    </script>
</body>
</html>
