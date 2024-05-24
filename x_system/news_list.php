<?php

session_start(); // 세션 시작

// 세션에 로그인 여부 확인
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // 로그인되어 있지 않으면 index.php로 리다이렉트
    header('Location: index.php');
    exit;
}


// pop_json.json 파일에서 데이터 로드
$data = json_decode(file_get_contents('news_data.json'), true);
$data = array_reverse($data); // 데이터를 역순으로 정렬
?>

<!DOCTYPE html>
<html>
<head>
     <title>ADMIN - 언론보도 목록</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<div class="main_bg">
    <div class="main_warp">
        <div class="left_warp">
            <div class="left_logo"></div>
            <div class="left_tit_text">ADMIN</div>
            <div class="left_menu_warp">
                <a href="pop_list.php"><div class="btn ">
                팝업관리자
                </div></a>
                <a href="news_list.php"><div class="btn on">
                언론보도
                </div></a>
            </div>
        </div>
        <div class="right_warp">
        <div class="right_warp1">
            <div class="right_tit">언론보도 목록</div>
            <div class="right_cont">
                <div class="right_cont1">
                 <table class="pop_list_table" >
                     <tr class="tit">
                        <th width="60%">제목</th>
                        <th width="20%">기사날짜</th>
                       
                        <th width="20%"> </th>
                    </tr>
                     <?php foreach ($data as $index => $news): ?>
                        
                        <tr>
                            <td class="news_titt"><?= htmlspecialchars($news['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($news['created_at'], ENT_QUOTES, 'UTF-8') ?> </td>
                                <td>
                                    <!-- 수정 버튼 -->
                                <button onclick="location.href='news_form.php?index=<?= count($data) - $index - 1 ?>'">수정</button>
                                <button class="del" onclick="deletePopup(<?= count($data) - $index - 1 ?>)">삭제</button>
                            </td>
                        </tr>   
                     <?php endforeach; ?>
                 

                 </table>
                </div>
            </div>
            <div onclick="location.href='news_form.php'" class="right_main_btn">언론보도 추가</div>

        </div>
         </div>
    </div>
 </div>






    <script>
      

       function deletePopup(index) {
            if (confirm('정말로 삭제하시겠습니까?')) {
                // AJAX 요청으로 삭제 처리
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'news_delete.php', true);
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
